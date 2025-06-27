<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial; padding: 20px; }
        .box { display: inline-block; padding: 20px; margin: 10px; border: 1px solid #ccc; border-radius: 10px; width: 200px; text-align: center; }
    </style>
</head>
<body>
    <h1>📊 Dashboard</h1>

    <div id="summary">
        <div class="box" id="customers">Customers: ...</div>
        <div class="box" id="products">Products: ...</div>
        <div class="box" id="orders">Orders: ...</div>
    </div>

    <a href="/api/export/products" target="_blank">
    <button>⬇️ Export Products (Excel)</button>
</a>


    <br>
    <a href="/products">🔗 Products Page</a><br>
    <a href="{{ route('customers.index')}}">🔗 Customers Page</a><br>
    <a href="/orders">🔗 Orders Page</a>

    <script>
        async function loadCounts() {
            const [customers, products, orders] = await Promise.all([
                fetch('/api/customers').then(res => res.json()),
                fetch('/api/products').then(res => res.json()),
                fetch('/api/orders').then(res => res.json())
            ]);

            document.getElementById('customers').innerText = `Customers: ${customers.total}`;
            document.getElementById('products').innerText = `Products: ${products.total}`;
            document.getElementById('orders').innerText = `Orders: ${orders.total}`;
        }

        loadCounts();
    </script>
</body>
</html>
