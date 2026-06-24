<?php

namespace App\Exports;

use App\Models\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PlaceReportExport extends StringValueBinder implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents,
    WithCustomValueBinder,
    WithCustomStartCell
{
    protected $request;
    protected $no = 1;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Place::query()
            ->with([
                'province:id,name',
                'regency:id,name',
                'district:id,name',
                'village:id,name',
                'creator:id,name,email'
            ])

            ->when(
                $this->request->filled('title'),
                fn($q) =>
                $q->where(
                    'title',
                    'like',
                    '%' . $this->request->title . '%'
                )
            )

            ->when(
                $this->request->filled('place_code'),
                fn($q) =>
                $q->where(
                    'place_code',
                    'like',
                    '%' . $this->request->place_code . '%'
                )
            )

            ->when(
                $this->request->filled('description'),
                fn($q) =>
                $q->where(
                    'description',
                    'like',
                    '%' . $this->request->description . '%'
                )
            )

            ->when(
                $this->request->filled('creator'),
                function ($query) {

                    $creator =
                        $this->request->creator;

                    $query->whereHas(
                        'creator',
                        function ($q)
                        use ($creator) {

                            $q->where(
                                'email',
                                'like',
                                "%{$creator}%"
                            )
                                ->orWhere(
                                    'name',
                                    'like',
                                    "%{$creator}%"
                                );
                        }
                    );
                }
            )

            ->when(
                $this->request->filled('province'),
                fn($q) =>
                $q->where(
                    'province_id',
                    $this->request->province
                )
            )

            ->when(
                $this->request->filled('regency'),
                fn($q) =>
                $q->where(
                    'regency_id',
                    $this->request->regency
                )
            )

            ->when(
                $this->request->filled('district'),
                fn($q) =>
                $q->where(
                    'district_id',
                    $this->request->district
                )
            )

            ->when(
                $this->request->filled('village'),
                fn($q) =>
                $q->where(
                    'village_id',
                    $this->request->village
                )
            )

            ->when(
                $this->request->updated_at_start &&
                    $this->request->updated_at_end,
                function ($query) {

                    $query->whereBetween(
                        'updated_at',
                        [
                            Carbon::parse(
                                $this->request
                                    ->updated_at_start
                            )->startOfDay(),

                            Carbon::parse(
                                $this->request
                                    ->updated_at_end
                            )->endOfDay()
                        ]
                    );
                }
            )

            ->when(
                $this->request->sort_by,
                function ($query) {

                    switch ($this->request->sort_by) {

                        case 'views':
                            $query->orderByDesc(
                                'views'
                            );
                            break;

                        case 'name':
                            $query->orderBy(
                                'title'
                            );
                            break;

                        case 'place_code':
                            $query->orderBy(
                                'place_code'
                            );
                            break;
                    }
                }
            )

            ->select([
                'id',
                'place_code',
                'title',
                'description',
                'creator_id',
                'phone_num',
                'views',
                'is_comment',
                'created_at',
                'updated_at',
                'province_id',
                'regency_id',
                'district_id',
                'village_id'
            ]);

        if (!Auth::user()->hasRole('superadmin')) {
            $query->where('creator_id', Auth::id());
        }

        return $query->get();
    }

    private function getAppliedFilters(): array
    {
        return array_filter([
            'Title' =>
            $this->request->title,

            'Place Code' =>
            $this->request->place_code,

            'Description' =>
            $this->request->description,

            'Creator' =>
            $this->request->creator,

            'Province ID' =>
            $this->request->province,

            'Regency ID' =>
            $this->request->regency,

            'District ID' =>
            $this->request->district,

            'Village ID' =>
            $this->request->village,

            'Updated Start' =>
            $this->request
                ->updated_at_start,

            'Updated End' =>
            $this->request
                ->updated_at_end,

            'Sort By' =>
            $this->request->sort_by

        ], fn($value) => filled($value));
    }

    public function startCell(): string
    {
        $filters = $this->getAppliedFilters();

        // Base layout:
        // Row 1 = Title
        // Row 2 = Generated At
        // Row 3 = Empty
        // Row 4 = Applied Filters title
        // Row 5+ = Filter values
        // Last = Empty row
        // Next = Table header

        $filterCount = count($filters);

        // jika tidak ada filter tetap kasih 1 row
        $filterRows = max($filterCount, 1);

        $headerRow =
            4 + // applied filters title
            $filterRows +
            2; // spacer + header

        return 'A' . $headerRow;
    }
    public function headings(): array
    {
        return [
            'No',
            'Place Code',
            'Title',
            'Description',
            'Creator Name',
            'Creator Email',
            'Contact Person',
            'Views',
            'Comment Enabled',
            'Comment Count',
            'Province',
            'Regency',
            'District',
            'Village',
            'Created At',
            'Updated At'
        ];
    }

    public function map($place): array
    {
        return [
            $this->no++,
            (string) $place->place_code,
            $place->title,
            $place->description,
            optional($place->creator)->name,
            optional($place->creator)->email,
            $place->phone_num,
            $place->views,
            $place->is_comment
                ? 'Yes'
                : 'No',
            $place->comment_count != 0 ? $place->comment_count : "0",
            optional(
                $place->province
            )->name,
            optional(
                $place->regency
            )->name,
            optional(
                $place->district
            )->name,
            optional(
                $place->village
            )->name,
            $place->created_at,
            $place->updated_at
        ];
    }

    public function bindValue(
        $cell,
        $value
    ) {

        if (
            $cell->getColumn() === 'B'
        ) {

            $cell
                ->setValueExplicit(
                    (string) $value,
                    DataType::TYPE_STRING
                );

            return true;
        }

        return parent::bindValue(
            $cell,
            $value
        );
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class =>
            function (
                AfterSheet $event
            ) {

                $sheet =
                    $event->sheet;

                $filters =
                    $this->getAppliedFilters();

                // =================
                // TITLE
                // =================
                $sheet->mergeCells(
                    'A1:F1'
                );

                $sheet->setCellValue(
                    'A1',
                    'QRUN Place Report'
                );

                $sheet->getStyle(
                    'A1'
                )->getFont()
                    ->setBold(true)
                    ->setSize(16);

                // =================
                // GENERATED TIME
                // =================
                $sheet->setCellValue(
                    'A2',
                    'Generated At'
                );

                $sheet->setCellValue(
                    'B2',
                    now()->format(
                        'Y-m-d H:i:s'
                    )
                );

                // =================
                // FILTERS
                // =================
                $currentRow = 4;

                $sheet->setCellValue(
                    "A{$currentRow}",
                    'Applied Filters'
                );

                $sheet->getStyle(
                    "A{$currentRow}"
                )->getFont()
                    ->setBold(true);

                $currentRow++;

                if (
                    count($filters)
                ) {

                    foreach (
                        $filters
                        as $label =>
                        $value
                    ) {

                        $sheet
                            ->setCellValue(
                                "A{$currentRow}",
                                $label
                            );

                        $sheet
                            ->setCellValue(
                                "B{$currentRow}",
                                $value
                            );

                        $currentRow++;
                    }
                } else {

                    $sheet
                        ->setCellValue(
                            "A{$currentRow}",
                            'Status'
                        );

                    $sheet
                        ->setCellValue(
                            "B{$currentRow}",
                            'All Data'
                        );

                    $currentRow++;
                }

                $filters = $this->getAppliedFilters();

                $filterRows = max(
                    count($filters),
                    1
                );

                $headerRow =
                    4 + // Applied filters title
                    $filterRows +
                    2; // spacer + header

                $highestColumn =
                    $sheet
                    ->getHighestColumn();

                $highestRow =
                    $sheet
                    ->getHighestRow();

                // =================
                // HEADER TABLE
                // =================
                $sheet->getStyle(
                    "A{$headerRow}:{$highestColumn}{$headerRow}"
                )->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'color' => [
                            'rgb' =>
                            'FFFFFF'
                        ]
                    ],
                    'alignment' => [
                        'horizontal' =>
                        Alignment::HORIZONTAL_CENTER,
                        'vertical' =>
                        Alignment::VERTICAL_CENTER
                    ],
                    'fill' => [
                        'fillType' =>
                        Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' =>
                            '1F4E78'
                        ]
                    ]
                ]);

                // TABLE BORDER
                $sheet->getStyle(
                    "A{$headerRow}:{$highestColumn}{$highestRow}"
                )->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' =>
                            Border::BORDER_THIN
                        ]
                    ]
                ]);

                // ALIGN
                $sheet->getStyle(
                    'A:A'
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );

                $sheet->getStyle(
                    'B:B'
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );

                $sheet->getStyle(
                    'H:J'
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );

                // Freeze table
                $sheet->freezePane(
                    'A' .
                        ($headerRow + 1)
                );

                $sheet
                    ->getRowDimension(
                        $headerRow
                    )
                    ->setRowHeight(24);
            }
        ];
    }
}
