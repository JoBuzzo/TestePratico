<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function __invoke(Purchase $purchase)
    {
        $purchase->fresh('products', 'parcels', 'client', 'user');

        $pdf = Pdf::loadView('pdf.purchase', [
            'purchase' => $purchase,
        ]);

        return $pdf->download('compra.pdf');
    }
}
