<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        h2 {
            font-size: 16px;
        }
    </style>
    <h1>Compra do dia {{ date('d/m/Y', strtotime($purchase->created_at)) }}</h1>

    <h2>Cliente: {{ $purchase->client->name }}</h2>
    <h2>Vendedor: {{ $purchase->user->name }}</h2>

    <div>
        <h3>Produtos</h3>
        <table>
            <tr>
                <th>Nome do Produto</th>
                <th>Preço/unidade</th>
                <th>Quantidade</th>
                <th>SubTotal</th>
            </tr>

            @foreach ($purchase->products as $product)
                <tr>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        R$ {{ $product->pivot->price }}
                    </td>
                    <td>
                        {{ $product->pivot->quantity }}
                    </td>
                    <td>
                        R$ {{ $product->pivot->quantity * $product->pivot->price }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Total: {{ $purchase->total }}</td>
            </tr>
        </table>
    </div>

    <div>
        <h3>Parcelas</h3>
        <table>
            <tr>
                <th>Data de vencimento</th>
                <th>Valor</th>
                <th>Forma de pagamento</th>
            </tr>

            @foreach ($purchase->parcels as $parcel)
                <tr>
                    <td>
                        {{ date('d/m/Y', strtotime($parcel->date)) }}
                    </td>
                    <td>
                        R$ {{ $parcel->price }}
                    </td>
                    <td>
                        {{ $parcel->payment_method }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
