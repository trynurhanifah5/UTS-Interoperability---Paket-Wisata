<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use SimpleXMLElement;

class Controller extends BaseController
{
    protected function dynamicResponse(Request $request, $data, $statusCode = 200)
    {
        $acceptHeader = (string) $request->header('Accept');
        $formatParam  = $request->query('format');

        // Jika klien meminta XML lewat Header Accept atau query ?format=xml
        if (strpos($acceptHeader, 'application/xml') !== false || $formatParam === 'xml') {
            $xml = new SimpleXMLElement('<response/>');
            $arrayData = json_decode(json_encode($data), true) ?? [];
            $this->arrayToXml($arrayData, $xml);

            return response($xml->asXML(), $statusCode)
                ->header('Content-Type', 'application/xml');
        }

        // Default: Response JSON
        return response()->json($data, $statusCode);
    }

    private function arrayToXml($data, &$xml)
    {
        foreach ((array) $data as $key => $value) {
            $safeKey = is_numeric($key) ? 'item_' . $key : preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $key);

            if (is_array($value)) {
                $subnode = $xml->addChild($safeKey);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($safeKey, htmlspecialchars((string) ($value ?? '')));
            }
        }
    }
}