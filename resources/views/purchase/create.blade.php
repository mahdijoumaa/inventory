<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purchase - Odoo Style</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f4f6f9;
}
.header-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 15px;
}
.status-badge {
    font-size: 14px;
    padding: 5px 10px;
}
.tab-box {
    background: white;
    padding: 15px;
    border-radius: 8px;
}
.table th, .table td {
    vertical-align: middle;
}
.total-box {
    text-align: right;
    font-weight: bold;
    font-size: 18px;
}
</style>

</head>
<body>

<div class="container mt-4">

```
<!-- HEADER -->
<div class="header-box d-flex justify-content-between align-items-center">
    <div>
        <h4>Purchase: <strong>PUR-00045</strong></h4>
        <p class="mb-1">Supplier: <strong>Mahdi169</strong></p>
        <p class="mb-0">Date: 31 Mar 2026</p>
    </div>

    <div>
        <span class="badge bg-warning status-badge">DRAFT</span><br><br>

        <button class="btn btn-primary btn-sm">Save</button>
        <button class="btn btn-success btn-sm">Confirm</button>
        <button class="btn btn-danger btn-sm">Cancel</button>
    </div>
</div>

<!-- TABS -->
<ul class="nav nav-tabs mb-3" id="purchaseTabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#products">Products</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#info">Other Info</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#history">History</button>
    </li>
</ul>

<div class="tab-content">

    <!-- PRODUCTS TAB -->
    <div class="tab-pane fade show active tab-box" id="products">

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Unit</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>
                        <button class="btn btn-success btn-sm">+</button>
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Food</td>
                    <td>Rice 25kg</td>
                    <td>120</td>
                    <td>kg</td>
                    <td>5</td>
                    <td>50</td>
                    <td>250</td>
                    <td><button class="btn btn-danger btn-sm">x</button></td>
                </tr>

                <tr>
                    <td>Drinks</td>
                    <td>Coca Cola 1L</td>
                    <td>300</td>
                    <td>pcs</td>
                    <td>10</td>
                    <td>3</td>
                    <td>30</td>
                    <td><button class="btn btn-danger btn-sm">x</button></td>
                </tr>
            </tbody>
        </table>

        <div class="total-box">
            TOTAL: 280
        </div>

    </div>

    <!-- OTHER INFO -->
    <div class="tab-pane fade tab-box" id="info">

        <div class="row">
            <div class="col-md-4">
                <label>Total Amount</label>
                <input type="text" class="form-control" value="280">
            </div>

            <div class="col-md-4">
                <label>Paid Amount</label>
                <input type="text" class="form-control" value="100">
            </div>

            <div class="col-md-4">
                <label>Due Amount</label>
                <input type="text" class="form-control" value="180">
            </div>
        </div>

        <div class="mt-3">
            <label>Notes</label>
            <textarea class="form-control" rows="3"></textarea>
        </div>

    </div>

    <!-- HISTORY -->
    <div class="tab-pane fade tab-box" id="history">

        <ul class="list-group">
            <li class="list-group-item">Created by Admin at 10:32 AM</li>
            <li class="list-group-item">Added product: Rice 25kg</li>
            <li class="list-group-item">Updated quantity: 5 → 10</li>
            <li class="list-group-item text-success">Purchase Confirmed</li>
        </ul>

    </div>

</div>
```

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
