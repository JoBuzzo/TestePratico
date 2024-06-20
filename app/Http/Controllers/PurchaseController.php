<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Parcel;
use App\Models\Product;
use App\Models\Purchase;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{

    public function index()
    {
        return view('purchase.index', [
            'purchases' => Purchase::withCount('parcels', 'products')->with('client')->get(),
        ]);
    }

    public function create()
    {
        $clients = Client::all();

        $products = Product::all();

        return view("purchase.create", [
            'clients' => $clients,
            'products' => $products,
        ]);
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

                $data[$product->id]['quantity'] = $product->quantity;
                $data[$product->id]['price'] = $product->price;
            }


            $purchase->products()->attach($data);

            $parcels = json_decode($request->parcels);

            $data = [];
            foreach ($parcels as $parcel) {

                $date = DateTime::createFromFormat('d/m/Y', $parcel->date);
                $data[] = new Parcel([
                    'purchase_id' => $purchase->id,
                    'date' => $date->format('Y-m-d'),
                    'price' => $parcel->value,
                    'payment_method' => $parcel->payment,
                ]);
            }

            $purchase->parcels()->saveMany($data);

            return $purchase;
        });

        return redirect()->route('purchase.show', $purchase);
    }

    public function show(Purchase $purchase)
    {
        return view('purchase.show', [
            'purchase' => $purchase->fresh('products', 'client', 'parcels'),
        ]);
    }
}
