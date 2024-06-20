<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function create()
    {
        $clients = Client::all();

        $products = Product::all();

        return view("purchase.create", compact("clients", 'products'));
    }

    public function store(Request $request)
    {

        $purchase = DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'client_id' => $request->client_id,
                'total' => $request->total_price,
            ]);

            $products = json_decode($request->products);


            $data = [];
            foreach ($products as $product) {

                if (isset($data[$product->id])) {
                    $data[$product->id]['quantity']++;
                } else {
                    $data[$product->id]['quantity'] = 1;
                    $data[$product->id]['price'] = $product->price;
                }
            }


            $purchase->products()->attach($data);


            return $purchase->fresh('products');;
        });

        return redirect()->route('purchase.show', $purchase);
    }

    public function show(Purchase $purchase)
    {
        return view('purchase.show', [
            'purchase' => $purchase->fresh('products', 'client'),
        ]);
    }
}
