<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PHPExcel_Style_Protection;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductShipmentMassExport implements FromView, WithStyles, WithColumnWidths {
    private $products;
    public function __construct() {
        $this->products = Product::all();
    }
    public function view(): View {
        return view('admin.exports.product-shipment-mass-update', [
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
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getProtection()->setSheet(true);
        $products_count = $this->products->count();
        $sheet->getStyle('D3:G' . ($products_count + 2))->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('D3:G' . ($products_count + 2))->getFont()->getColor()->setARGB('5abfaf');
        $sheet->getStyle('A1:G2')->getFont()->setBold(true);
        $sheet->freezePane([1, 2]);
        $sheet->getRowDimension(2)->setVisible(false);
        $sheet->getStyle('A1:G' . ($products_count + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G' . ($products_count + 2))->getAlignment()->setWrapText(true);
    }
}
