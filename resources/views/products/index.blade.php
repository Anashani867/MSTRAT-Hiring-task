<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Products List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f9f9f9;
            color: #333;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        button, .create-btn {
            background-color: #2980b9;
            border: none;
            color: white;
            padding: 8px 15px;
            margin-right: 5px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 0.9rem;
        }
        button:hover, .create-btn:hover {
            background-color: #1f5f8b;
        }
        .create-btn {
            margin-bottom: 15px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2980b9;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        tr:hover {
            background-color: #f1f7fc;
        }
        #pagination {
            margin-bottom: 30px;
        }
        #pagination button {
            background-color: #27ae60;
            margin: 0 5px 10px 0;
        }
        #pagination button:hover {
            background-color: #1f8a46;
        }
    </style>
</head>
<body>
    <h1>Products List</h1>

    <button class="create-btn" onclick="window.location.href='/products/create'">Create New Product</button>

    <table border="1" cellpadding="10" cellspacing="0" id="products-table">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Description</th><th>Status</th><th>Amount</th><th>Currency</th><th>Actions</th>
            </tr>
        </thead>
        <tbody id="products-body"></tbody>
    </table>

    <div id="pagination"></div>

    <script>
        let currentPage = 1;

        async function fetchProducts(page = 1) {
            currentPage = page;
            const response = await fetch(`/api/products?page=${page}`);
            const data = await response.json();

            let rows = '';
            data.data.forEach(p => {
               rows += `<tr>
    <td>${p.id}</td>
    <td>${p.name}</td>
    <td>${p.description}</td>
    <td>${p.status}</td>
    <td>${p.amount}</td>
    <td>${p.currency}</td>
    <td>
        <button onclick="editProduct(${p.id})">Edit</button>
        <button onclick="deleteProduct(${p.id})">Delete</button>
    </td>
</tr>`;
            });

            document.getElementById('products-body').innerHTML = rows;

            let pag = '';
            if (data.prev_page_url) pag += `<button onclick="fetchProducts(${page - 1})">Previous</button>`;
            if (data.next_page_url) pag += `<button onclick="fetchProducts(${page + 1})">Next</button>`;
            document.getElementById('pagination').innerHTML = pag;
        }

        fetchProducts();

        async function editProduct(id) {
            const product = await fetch(`/api/products/${id}`).then(res => res.json());

            const name = prompt("Enter new name:", product.name);
            const description = prompt("Enter new description:", product.description);
            const amount = prompt("Enter amount:", product.amount);
            const currency = prompt("Enter currency:", product.currency);
            const status = prompt("Enter status (Available, OutOfStock, Discontinued):", product.status);

            const response = await fetch(`/api/products/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, description, amount, currency, status })
            });

            if (response.ok) {
                alert('Product updated');
                fetchProducts(currentPage);
            } else {
                alert('Failed to update');
            }
        }

        async function deleteProduct(id) {
            if (!confirm('Are you sure you want to delete this product?')) return;

            const response = await fetch(`/api/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                alert('Product deleted');
                fetchProducts(currentPage);
            } else {
                alert('Failed to delete');
            }
        }
    </script>
</body>
</html>
