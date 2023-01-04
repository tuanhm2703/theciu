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

class ProductSaleMassExport implements FromView, WithStyles, WithColumnWidths {
    private $products;
    public function __construct() {
        $this->products = Product::with([
            'categories:id,name',
            'images:path,imageable_id',
            'inventories.attributes'
        ])->withCount('inventories')->get();
    }
    public function view(): View {
        return view('admin.exports.product-sale-mass-update', [
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
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getProtection()->setSheet(true);
        $inventories_count = $this->products->sum('inventories_count');
        $sheet->getStyle('E3:H' . ($inventories_count + 1))->getProtection()
            ->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('E3:H' . ($inventories_count + 4))->getFont()->getColor()->setARGB('5abfaf');
        $sheet->getStyle('A1:H2')->getFont()->setBold(true);
        $sheet->freezePane([1, 2]);
        $sheet->getRowDimension(2)->setVisible(false);
        $sheet->getStyle('A1:H' . ($inventories_count + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H' . ($inventories_count + 4))->getAlignment()->setWrapText(true);
    }
}
