<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Orders List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f9f9f9;
            color: #333;
        }
        h1, h2 {
            color: #2c3e50;
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
        button {
            background-color: #2980b9;
            border: none;
            color: white;
            padding: 8px 12px;
            margin-right: 5px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 0.9rem;
        }
        button:hover {
            background-color: #1f5f8b;
        }
        form {
            background: white;
            padding: 20px;
            max-width: 400px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #34495e;
        }
        form input[type="text"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
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
    <h1>Orders List</h1>

    <table border="1" cellpadding="10" cellspacing="0" id="orders-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Total Amount</th>
                <th>Currency</th>
                <th>Server Datetime</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="orders-body"></tbody>
    </table>

    <div id="pagination"></div>

    <h2>Edit Order</h2>
    <form id="edit-form" onsubmit="updateOrder(event)">
        <input type="hidden" id="edit-id" />
        <label>Total Amount:
            <input type="text" id="edit-total-amount" required />
        </label>
        <label>Currency:
            <input type="text" id="edit-currency" required />
        </label>
        <button type="submit">Update</button>
    </form>

    <script>
        let currentPage = 1;

        async function fetchOrders(page = 1) {
            currentPage = page;
            const response = await fetch(`/api/orders?page=${page}`);
            const data = await response.json();

            let rows = '';
            data.data.forEach(order => {
                rows += `<tr>
                    <td>${order.id}</td>
                    <td>${order.customer.name}</td>
                    <td>${order.product.name}</td>
                    <td>${order.total_amount}</td>
                    <td>${order.currency}</td>
                    <td>${order.server_datetime || ''}</td>
                    <td>
                        <button onclick="deleteOrder(${order.id})">Delete</button>
                        <button onclick="showEditForm(${order.id}, '${order.total_amount}', '${order.currency}', ${order.customer_id}, ${order.product_id})">Edit</button>
                    </td>
                </tr>`;
            });

            document.getElementById('orders-body').innerHTML = rows;

            let pag = '';
            if(data.prev_page_url) pag += `<button onclick="fetchOrders(${page - 1})">Previous</button>`;
            if(data.next_page_url) pag += `<button onclick="fetchOrders(${page + 1})">Next</button>`;
            document.getElementById('pagination').innerHTML = pag;
        }

        async function deleteOrder(id) {
            if(!confirm('Are you sure you want to delete this order?')) return;

            const response = await fetch(`/api/orders/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ids: [id] })            });

            if(response.ok) {
                alert('Order deleted');
                fetchOrders(currentPage);
            } else {
                alert('Failed to delete order');
            }
        }

        function showEditForm(id, totalAmount, currency, customerId, productId) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-total-amount').value = totalAmount;
            document.getElementById('edit-currency').value = currency;
            document.getElementById('edit-form').dataset.customerId = customerId;
            document.getElementById('edit-form').dataset.productId = productId;
            document.getElementById('edit-form').scrollIntoView({ behavior: 'smooth' });
        }

        async function updateOrder(event) {
            event.preventDefault();

            const id = document.getElementById('edit-id').value;
            const total_amount = document.getElementById('edit-total-amount').value;
            const currency = document.getElementById('edit-currency').value;
            const customer_id = document.getElementById('edit-form').dataset.customerId;
            const product_id = document.getElementById('edit-form').dataset.productId;

            const response = await fetch(`/api/orders/${id}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    total_amount,
                    currency,
                    customer_id,
                    product_id,
                    server_datetime: null,
                    datetime_utc: null
                })
            });

            if (response.ok) {
                alert('Order updated successfully');
                fetchOrders(currentPage);
            } else {
                alert('Failed to update order');
            }
        }

        // Load orders on page load
        fetchOrders();
    </script>
</body>
</html>
