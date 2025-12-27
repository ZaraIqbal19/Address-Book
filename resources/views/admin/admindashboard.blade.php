<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styling -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #eef2ff, #f8fafc);
            min-height: 100vh;
        }

        .dashboard-title {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .dashboard-card {
            border-radius: 18px;
            padding: 20px;
            transition: all 0.3s ease;
            background: #fff;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 6px;
            height: 100%;
        }

        .card-products::before { background: #0d6efd; }
        .card-categories::before { background: #198754; }
        .card-orders::before { background: #ffc107; }
        .card-customers::before { background: #dc3545; }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .dashboard-label {
            font-size: 13px;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 1px;
        }

        .dashboard-count {
            font-size: 42px;
            font-weight: 700;
            margin-top: 10px;
        }

        footer {
            margin-top: 60px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <!-- Heading -->
    <div class="row mb-5">
        <div class="col">
            <h2 class="dashboard-title">Admin Dashboard</h2>
            <p class="text-muted">Store overview & statistics</p>
        </div>
    </div>

    <!-- Cards -->
    <div class="row g-4">

        <div class="col-md-3">
            <div class="dashboard-card card-products">
                <div class="dashboard-label">Total Products</div>
                <div class="dashboard-count text-primary">
                    {{ $totalProducts }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card card-categories">
                <div class="dashboard-label">Total Categories</div>
                <div class="dashboard-count text-success">
                    {{ $totalCategories }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card card-orders">
                <div class="dashboard-label">Total Orders</div>
                <div class="dashboard-count text-warning">
                    {{ $totalOrders }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="dashboard-card card-customers">
                <div class="dashboard-label">Total Customers</div>
                <div class="dashboard-count text-danger">
                    {{ $totalCustomers }}
                </div>
            </div>
        </div>

    </div>

    <footer>
        © {{ date('Y/M/D') }} Admin Panel
    </footer>

</div>

</body>
</html>
