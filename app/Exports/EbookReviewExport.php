<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Ebook review answers export. Columns (which questions, in what order, and
 * whether base columns show) are decided by the controller and passed in here
 * already resolved, so this class just writes headings + rows.
 */
class EbookReviewExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    /**
     * @param array $headings Ordered column labels.
     * @param array $rows     Ordered list of rows; each an indexed array of scalars.
     */
    public function __construct(protected array $headings, protected array $rows)
    {
    }

    public function collection()
    {
        return collect($this->rows);
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function title(): string
    {
        return 'Reviews';
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();

        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E78']],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(22);
        $sheet->freezePane('A2');

        return [];
    }
}
