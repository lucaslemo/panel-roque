<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function receiveUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'idCliente' => 'required|numeric',
            'nmCliente' => 'required|string',
            'tpCliente' => 'required|string',
            'codCliente' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $validated = $validator->validated();
            $user = User::where('email', $validated['email'])->first();
            $customer = Customer::where('extCliente', $validated['idCliente'])->first();

            if (!$user) {
                $user = new User;
                $user->name = $validated['email'];
                $user->email = $validated['email'];
                $user->password = Hash::make(Str::password());

                $user->save();
            }

            if (!$customer) {
                $customer = new Customer;
                $customer->extCliente = $validated['idCliente'];
                $customer->nmCliente = $validated['nmCliente'];
                $customer->tpCliente = $validated['tpCliente'] === 'F' ? 'pf' : 'pj';
                $customer->codCliente = $validated['codCliente'];

                $customer->save();
            }

            $user->customers()->sync($customer, false);

            return response()->json(['message' => 'Success!']);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        } 
    }
}
