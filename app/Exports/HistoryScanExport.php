<?php

namespace App\Exports;

use App\Models\PlaceCheckpoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HistoryScanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents,
    WithCustomStartCell
{
    protected Request $request;
    protected bool $myPlaceOnly;
    protected bool $isSuperAdmin;
    protected int $no = 1;

    public function __construct(Request $request, bool $myPlaceOnly = false, bool $isSuperAdmin = false)
    {
        $this->request      = $request;
        $this->myPlaceOnly  = $myPlaceOnly;
        $this->isSuperAdmin = $isSuperAdmin;
    }

    public function collection()
    {
        $query = PlaceCheckpoint::query()
            ->with(['place:id,place_code,title', 'user:id,name,email']);

        if ($this->myPlaceOnly) {
            $query->whereHas('place', fn($q) => $q->where('creator_id', Auth::id()));
        }

        if ($this->request->filled('place_code')) {
            $query->where('place_code', 'like', '%' . $this->request->place_code . '%');
        }

        if (!$this->myPlaceOnly && $this->request->filled('user')) {
            $user = $this->request->user_filter;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$user}%")->orWhere('email', 'like', "%{$user}%"));
        }

        if ($this->request->filled('device')) {
            $query->where('device_type', 'like', '%' . $this->request->device . '%');
        }

        if ($this->request->filled('platform')) {
            $query->where('platform', 'like', '%' . $this->request->platform . '%');
        }

        if ($this->request->filled('date_start') && $this->request->filled('date_end')) {
            $query->whereBetween('checked_at', [
                Carbon::parse($this->request->date_start)->startOfDay(),
                Carbon::parse($this->request->date_end)->endOfDay(),
            ]);
        }

        return $query->orderByDesc('checked_at')->get();
    }

    private function appliedFilters(): array
    {
        return array_filter([
            'Place Code'  => $this->request->place_code,
            'User'        => $this->isSuperAdmin ? $this->request->user_filter : null,
            'Device'      => $this->request->device,
            'Platform'    => $this->request->platform,
            'Date Start'  => $this->request->date_start,
            'Date End'    => $this->request->date_end,
        ], fn($v) => filled($v));
    }

    public function startCell(): string
    {
        $filterRows = max(count($this->appliedFilters()), 1);
        return 'A' . (4 + $filterRows + 2);
    }

    public function headings(): array
    {
        $cols = ['No', 'Place Code', 'Place Title'];
        if ($this->isSuperAdmin) {
            $cols[] = 'User Name';
            $cols[] = 'User Email';
        }
        array_push($cols, 'Device', 'Platform', 'Browser', 'Checked At');
        return $cols;
    }

    public function map($row): array
    {
        $data = [
            $this->no++,
            "\t" . $this->clean($row->place_code ?? '-'),
            $this->clean(optional($row->place)->title ?? '-'),
        ];
        if ($this->isSuperAdmin) {
            $data[] = $this->clean(optional($row->user)->name ?? 'Guest');
            $data[] = $this->clean(optional($row->user)->email ?? '-');
        }
        $data[] = $this->clean($row->device_type ?? '-');
        $data[] = $this->clean($row->platform ?? '-');
        $data[] = $this->clean($row->browser ?? '-');
        $data[] = $row->checked_at ? $row->checked_at->format('Y-m-d H:i:s') : '-';
        return $data;
    }

    /**
     * Strip illegal XML control characters that make the .xlsx unreadable
     * ("format or extension is not valid") while keeping tab, LF and CR.
     */
    private function clean($value): string
    {
        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u', '', (string) $value);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet;
                $filters    = $this->appliedFilters();
                $filterRows = max(count($filters), 1);
                $headerRow  = 4 + $filterRows + 2;
                $highestCol = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'QRUN History Scan Report');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

                $sheet->setCellValue('A2', 'Generated At');
                $sheet->setCellValue('B2', now()->format('Y-m-d H:i:s'));

                $row = 4;
                $sheet->setCellValue("A{$row}", 'Applied Filters');
                $sheet->getStyle("A{$row}")->getFont()->setBold(true);
                $row++;

                if (count($filters)) {
                    foreach ($filters as $label => $value) {
                        $sheet->setCellValue("A{$row}", $label);
                        $sheet->setCellValue("B{$row}", $value);
                        $row++;
                    }
                } else {
                    $sheet->setCellValue("A{$row}", 'Status');
                    $sheet->setCellValue("B{$row}", 'All Data');
                }

                $sheet->getStyle("A{$headerRow}:{$highestCol}{$headerRow}")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E78']],
                ]);

                $sheet->getStyle("A{$headerRow}:{$highestCol}{$highestRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                $sheet->getRowDimension($headerRow)->setRowHeight(24);
                $sheet->freezePane('A' . ($headerRow + 1));
            }
        ];
    }
}
