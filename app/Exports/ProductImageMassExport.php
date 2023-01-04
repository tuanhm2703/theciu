<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PHPExcel_Style_Protection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductImageMassExport implements FromView, WithStyles, WithColumnWidths {
    private $products;
    public function __construct() {
        $this->products = Product::with('categories:id,name', 'images:path,imageable_id')->get();
    }
    public function view(): View {
        return view('admin.exports.product-image-mass-update', [
            'products' => $this->products
        ]);
    }
    public function columnWidths(): array {
        return [
            'A' => 50,
            'B' => 50,
            'C' => 50,
            'D' => 50,
            'E' => 50,
            'F' => 50,
            'G' => 50,
            'H' => 50,
            'I' => 50,
            'J' => 50,
            'K' => 50,
            'L' => 50,
            'M' => 50,
            'N' => 50,
            'O' => 50,
            'P' => 50,
            'Q' => 50,
            'R' => 50,
            'S' => 50,
            'T' => 50,
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getProtection()->setSheet(true);
        $products_count = $this->products->count();
        $sheet->getStyle('E4:N' . ($products_count + 4))->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('Q4:Q' . ($products_count + 4))->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('S4:S' . ($products_count + 4))->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('E2')->getFont()->getColor()->setARGB('FF0000');
        $sheet->getStyle('E5:M' . ($products_count + 4))->getFont()->getColor()->setARGB('5abfaf');
        $sheet->getStyle('A1:S4')->getFont()->setBold(true);
        $sheet->freezePane([1, 5]);
        $sheet->getRowDimension(2)->setVisible(false);
        $sheet->getStyle('A1:S' . ($products_count + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:S' . ($products_count + 4))->getAlignment()->setWrapText(true);
    }
}
