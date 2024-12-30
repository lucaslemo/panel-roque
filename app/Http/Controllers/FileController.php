<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function xml(Request $request, string $id)
    {
        $content = Cache::get('orders_xml_' . $id, null);

        if (is_null($content)) {
            $url = "https://openapi.acessoquery.com/api/nfe_xml/" . $id;
            $token = config('app.query_token');
    
            $response = Http::withToken($token)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->get($url);
    
            $response->throw();

            $content = $response['data']['content'];
            Cache::put('orders_xml_' . $id, $content, now()->addMinutes(10));
        }

        $headers = ['Content-Type' => 'application/xml'];

        return response($content, headers: $headers);
    }

    public function nfe(Request $request, string $id)
    {
        $url = "https://openapi.acessoquery.com/api/nfe_pdf/" . $id;

        $token = config('app.query_token');

        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get($url);

        $response->throw();

        $headers = ['Content-Type' => 'application/pdf'];

        return response($response, headers: $headers);
    }

    public function ticket(Request $request, string $id)
    {
        $url = "https://openapi.acessoquery.com/api/boleto_pdf/" . $id;

        $token = config('app.query_token');

        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get($url);

        $response->throw();

        $headers = ['Content-Type' => 'application/pdf'];

        return response($response, headers: $headers);
    }
}
