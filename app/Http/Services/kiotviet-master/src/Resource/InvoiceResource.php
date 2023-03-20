<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Resource;

use GuzzleHttp\Psr7\Request;
use VienThuong\KiotVietClient\Collection\InvoiceCollection;
use VienThuong\KiotVietClient\Endpoint;
use VienThuong\KiotVietClient\Model\Invoice;

class InvoiceResource extends BaseResource
{
    public function getEndPoint() : string
    {
        return Endpoint::INVOICE_ENDPOINT;
    }

    public function getExpectedModel() : string
    {
        return Invoice::class;
    }

    public function getCollectionClass() : string
    {
        return InvoiceCollection::class;
    }

    public function remove(string $id, array $headers = [])
    {
        $endpoint = $this->getEndPoint();

        $request = new Request('DELETE', $endpoint, $headers, json_encode([
            'id' => $id
        ]));

        $response = $this->client->execute($request);

        return array_merge(['id' => $id, 'class' => $this->getExpectedModel()], $response->parseResponse());
    }


}
