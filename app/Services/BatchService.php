<?php

namespace App\Services;

use App\Exports\ProductGeneralMassExport;
use App\Exports\ProductImageMassExport;
use App\Exports\ProductSaleMassExport;
use App\Exports\ProductShipmentMassExport;
use App\Imports\BatchUpdateImport;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BatchService {
    const GENERAL_BATCH_UPDATE_TYPE = 'general_update';
    const SALE_BATCH_UPDATE_TYPE = 'sale_update';
    const IMAGE_BATCH_UPDATE_TYPE = 'image_update';
    const SHIPMENT_BATCH_UPDATE_TYPE = 'shipment_update';
    public function updateGeneralInfo($data) {
    }

    public function updateSaleInfo($data) {
    }

    public static function updateImages() {
        return Excel::download(new ProductImageMassExport, 'products.xlsx');
    }

    public function getBatchUpdateFile($type) {
        switch ($type) {
            case self::GENERAL_BATCH_UPDATE_TYPE:
                return $this->getGeneralInfoMassFile();
                break;
            case self::SALE_BATCH_UPDATE_TYPE:
                return $this->getSaleInfoMassFile();
                break;
            case self::IMAGE_BATCH_UPDATE_TYPE:
                return $this->getImageInfoMassFile();
                break;
            case self::SHIPMENT_BATCH_UPDATE_TYPE:
                return $this->getShipmentInfoMassFile();
                break;
            default:
                # code...
                break;
        }
    }

    public function updateBatch($file) {
        $collection = Excel::toCollection(new BatchUpdateImport, $file)[0];
        $type = $collection[1][0];
        switch ($type) {
            case self::IMAGE_BATCH_UPDATE_TYPE:
                return $this->updateBatchImage($collection);
                break;
            case self::GENERAL_BATCH_UPDATE_TYPE:
                return $this->updateBatchGeneral($collection);
            case self::SALE_BATCH_UPDATE_TYPE:
                return $this->updateBatchSale($collection);
            case self::SHIPMENT_BATCH_UPDATE_TYPE:
                return $this->updateBatchShipment($collection);
                break;
        }
    }

    public function updateBatchGeneral($collection) {
        unset($collection[0]);
        unset($collection[1]);
        $product_ids = [];
        foreach ($collection as $c) {
            $product = Product::find($c[0]);
            if ($product) {
                $product->sku = $c[1];
                $product->name = $c[2];
                $product->description = $c[3];
                $product->save();
                $product_ids[] = $product->id;
            }
        }
        return $product_ids;
    }

    public function updateBatchImage($collection) {
        unset($collection[0]);
        unset($collection[1]);
        unset($collection[2]);
        unset($collection[3]);
        $product_ids = [];
        foreach ($collection as $c) {
            $product = Product::find($c[0]);
            if ($product) {
                $images = [];
                for ($i = 4; $i <= 12; $i++) {
                    if (!empty($c[$i])) {
                        $images[] = $c[$i];
                    }
                }
                $images = array_unique($images);
                if (count($images) > 0) {
                    $product_ids[] = $product->id;
                    DB::beginTransaction();
                    try {
                        $product->images()->delete();
                        $product->createImagesFromUrls($images);
                        DB::commit();
                    } catch (\Throwable $th) {
                        DB::rollBack();
                    }
                }
            }
        }
        return $product_ids;
    }

    public function updateBatchShipment($collection) {
        unset($collection[0]);
        unset($collection[1]);
        $product_ids = [];
        foreach ($collection as $c) {
            $product = Product::find($c[0]);
            if ($product) {
                $product->weight = $c[3];
                $product->length = $c[4];
                $product->width = $c[5];
                $product->height = $c[6];
                $product->save();
                $product_ids[] = $product->id;
            }
        }
        return $product_ids;
    }

    public function updateBatchSale($collection) {
        unset($collection[0]);
        unset($collection[1]);
        $product_ids = [];
        foreach ($collection as $c) {
            $inventory = Inventory::find($c[2]);
            if ($inventory) {
                $inventory->sku = $c[5];
                $inventory->price = $c[6];
                $inventory->stock_quantity = $c[7];
                $inventory->save();
                $inventory->product()->update(['sku' => $c[4]]);
                $product_ids[] = $inventory->product_id;
            }
        }
        return array_unique($product_ids);
    }

    public function getGeneralInfoMassFile() {
        return Excel::download(new ProductGeneralMassExport, 'mass_update_general_' . now()->timestamp . '.xlsx');
    }
    public function getSaleInfoMassFile() {
        return Excel::download(new ProductSaleMassExport, 'mass_update_sale_' . now()->timestamp . '.xlsx');
    }

    public function getImageInfoMassFile() {
        return Excel::download(new ProductImageMassExport, 'mass_update_media_' . now()->timestamp . '.xlsx');
    }

    public function getShipmentInfoMassFile() {
        return Excel::download(new ProductShipmentMassExport, 'mass_update_shipment_' . now()->timestamp . '.xlsx');
    }
}
