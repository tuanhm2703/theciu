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

class ProductGeneralMassExport implements FromView, WithStyles, WithColumnWidths {
    private $products;
    public function __construct() {
        $this->products = Product::with('categories:id,name', 'images:path,imageable_id')->get();
    }
    public function view(): View {
        return view('admin.exports.product-general-mass-update', [
            'products' => $this->products
        ]);
    }
    public function columnWidths(): array {
        return [
            'A' => 50,
            'B' => 50,
            'C' => 50,
            'D' => 50
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getProtection()->setSheet(true);
        $products_count = $this->products->count();
        $sheet->getStyle('B2:D' . ($products_count + 1))->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('C2:D' . ($products_count + 4))->getFont()->getColor()->setARGB('5abfaf');
        $sheet->getStyle('A1:S2')->getFont()->setBold(true);
        $sheet->freezePane([1, 2]);
        $sheet->getRowDimension(2)->setVisible(false);
        $sheet->getStyle('A1:D' . ($products_count + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:D' . ($products_count + 4))->getAlignment()->setWrapText(true);
    }
}
