<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function customers(Request $request) {
        try {
            $start = $request->start ?? 0;
            $end = $request->end ?? 10;

            $fileName = public_path('/seeders/customers.json');
            $jsonData = json_decode(file_get_contents($fileName), true);
            $response = ['pessoas' => ['id' => []]];

            for($i = $start; $i < $end; $i++) {
                if(isset($jsonData['pessoas']['id'][$i])) {
                    $response['pessoas']['id'][] = $jsonData['pessoas']['id'][$i];
                }
            }

            sleep(rand(2, 5));

            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function orders(Request $request) {
        try {
            $start = $request->start ?? 0;
            $end = $request->end ?? 10;

            $fileName = public_path('/seeders/orders.json');
            $jsonData = json_decode(file_get_contents($fileName), true);
            $response = ['pedidos' => ['id' => []]];

            for($i = $start; $i < $end; $i++) {
                if(isset($jsonData['pedidos']['id'][$i])) {
                    $response['pedidos']['id'][] = $jsonData['pedidos']['id'][$i];
                }
            }

            sleep(rand(2, 5));

            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function invoices(Request $request) {
        try {
            $start = $request->start ?? 0;
            $end = $request->end ?? 10;

            $fileName = public_path('/seeders/invoices.json');
            $jsonData = json_decode(file_get_contents($fileName), true);
            $response = ['duplicatas' => ['id' => []]];

            for($i = $start; $i < $end; $i++) {
                if(isset($jsonData['duplicatas']['id'][$i])) {
                    $response['duplicatas']['id'][] = $jsonData['duplicatas']['id'][$i];
                }
            }

            sleep(rand(2, 5));

            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}