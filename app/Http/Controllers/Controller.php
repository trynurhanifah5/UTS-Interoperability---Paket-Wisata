<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use SimpleXMLElement;

class Controller extends BaseController
{
    protected function dynamicResponse(Request $request, $data, $statusCode = 200)
    {
        $acceptHeader = $request->header('Accept');
        $formatParam  = $request->query('format');

        // Jika klien meminta XML lewat Header Accept atau query ?format=xml
        if (strpos($acceptHeader, 'application/xml') !== false || $formatParam === 'xml') {
            $xml = new SimpleXMLElement('<response/>');
            $this->arrayToXml(json_decode(json_encode($data), true), $xml);

            return response($xml->asXML(), $statusCode)
                ->header('Content-Type', 'application/xml');
        }

        // Default: Response JSON
        return response()->json($data, $statusCode);
    }

    private function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item_' . $key;
            }
            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars((string)$value));
            }
        }
    }
}