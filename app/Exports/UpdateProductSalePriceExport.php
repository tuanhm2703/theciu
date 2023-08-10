<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPExcel_Style_Protection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UpdateProductSalePriceExport implements FromView, WithStyles,WithColumnFormatting
{
    public function view(): View {
        return view('admin.exports.product-promotion-update');
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A1:C1')->getProtection();
        $sheet->getRowDimension(2)->setVisible(false);
    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
