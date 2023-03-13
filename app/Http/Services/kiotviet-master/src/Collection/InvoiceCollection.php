<?php

declare(strict_types=1);

namespace VienThuong\KiotVietClient\Collection;

use VienThuong\KiotVietClient\Model\Invoice;
use VienThuong\KiotVietClient\Model\InvoiceDetail;

class InvoiceCollection extends Collection
{
    public function getModelClass(): string
    {
        return Invoice::class;
    }

    public function transformItems(array $items): array
    {
        $transformItems = [];
        foreach ($items as $item) {
            $data = [];
            foreach ($item as $key => $value) {
                $data[$key] = $value;
                if ($value && $key == 'invoiceDetails') {
                    $data['invoiceDetails'] = [];
                    foreach($value as $invoiceDetail) {
                        $data['invoiceDetails'][] = new InvoiceDetail($invoiceDetail);
                    }
                    $data['invoiceDetails'] = new InvoiceDetailCollection($data['invoiceDetails']);
                }
            }
            $transformItems[] = new Invoice($data);
        }
        return $transformItems;
    }
}
