<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; color: #4f46e5; margin-bottom: 5px; }
        p { text-align: center; font-size: 10px; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f3f4f6; color: #111; font-size: 11px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Sillage Parfums - Inventario de Productos</h2>
    <p>Generado el {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th class="text-right">Precio Detal</th>
                <th class="text-right">Precio Mayor</th>
                <th class="text-right">Precio Divisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->marca_perfume ?? '-' }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="text-right">${{ number_format($product->retail_price, 2) }}</td>
                    <td class="text-right">{{ $product->wholesale_price ? '$' . number_format($product->wholesale_price, 2) : '-' }}</td>
                    <td class="text-right">{{ $product->precio_divisa ? '$' . number_format($product->precio_divisa, 2) : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
