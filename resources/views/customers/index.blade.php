<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Customers List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            color: #2c3e50;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: white;
        }
        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #2980b9;
            color: white;
        }
        button {
            padding: 8px 12px;
            margin: 5px;
            border: none;
            background-color: #2980b9;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1f5f8b;
        }
        #pagination {
            margin-top: 20px;
        }
        .top-buttons {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Customers List</h1>

    <div class="top-buttons">
        <button onclick="window.location.href='customers/create'">Create New Customer</button>
        <button onclick="deleteSelected()">Delete Selected</button>
    </div>

    <table id="customers-table">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all" /></th>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody id="customers-body"></tbody>
    </table>

    <div id="pagination"></div>

    <script>
        let currentPage = 1;
        let customersData = [];

        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.select-customer');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        async function fetchCustomers(page = 1) {
            currentPage = page;
            const response = await fetch(`/api/customers?page=${page}`);
            const data = await response.json();
            customersData = data.data;

            let rows = '';
            data.data.forEach(customer => {
                rows += `<tr>
                    <td><input type="checkbox" class="select-customer" value="${customer.id}" /></td>
                    <td>${customer.id}</td>
                    <td>${customer.name}</td>
                    <td>${customer.email}</td>
                    <td>${customer.phone}</td>
                    <td>${customer.status}</td>
                    <td>
                        <button onclick="changeStatus(${customer.id})">Change Status</button>
                        <button onclick="deleteCustomer(${customer.id})">Delete</button>
                    </td>
                </tr>`;
            });

            document.getElementById('customers-body').innerHTML = rows;

            let pag = '';
            if(data.prev_page_url) pag += `<button onclick="fetchCustomers(${page - 1})">Previous</button>`;
            if(data.next_page_url) pag += `<button onclick="fetchCustomers(${page + 1})">Next</button>`;
            document.getElementById('pagination').innerHTML = pag;
        }

        async function changeStatus(id) {
            const newStatus = prompt("Enter new status (Active, Inactive, Deleted, Expired):");
            if(!newStatus) return alert('Cancelled');

            const response = await fetch(`/api/customers/${id}/status`, {
                method: 'PATCH',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({status: newStatus})
            });

            if(response.ok) {
                alert('Status updated');
                fetchCustomers(currentPage);
            } else {
                alert('Failed to update status');
            }
        }

        async function deleteCustomer(id) {
            if(!confirm('Are you sure you want to delete this customer?')) return;

            const response = await fetch('/api/customers', {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({ids: [id]})
            });

            if(response.ok) {
                alert('Customer deleted');
                fetchCustomers(currentPage);
            } else {
                alert('Failed to delete customer');
            }
        }

        async function deleteSelected() {
            const selected = Array.from(document.querySelectorAll('.select-customer:checked')).map(cb => parseInt(cb.value));
            if(selected.length === 0) return alert('No customers selected');

            if(!confirm(`Are you sure you want to delete ${selected.length} customers?`)) return;

            const response = await fetch('/api/customers', {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({ids: selected})
            });

            if(response.ok) {
                alert('Selected customers deleted');
                fetchCustomers(currentPage);
            } else {
                alert('Failed to delete selected customers');
            }
        }

        // Initial load
        fetchCustomers();
    </script>
</body>
</html>
