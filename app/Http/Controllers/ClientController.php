<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cpf' => ['required', 'max:11', 'min:11'],
        ]);

        Client::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
        ]);

        return redirect()->route('dashboard');
    }
}
