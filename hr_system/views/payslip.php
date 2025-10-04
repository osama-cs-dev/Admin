<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";

$result = $conn->query("
    SELECT employees.name, payroll.basic_salary
    FROM payroll
    JOIN employees ON payroll.employee_id = employees.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f4f6f8;
        }

        .content {
            margin-left: 260px;
            padding: 40px;
        }

        h2 {
            color: #1e1e2f;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #00d4ff;
            color: white;
        }

        tr:hover {
            background: #f1faff;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #00aacc;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h2> Payslip</h2>

    <table>
        <tr>
            <th>Employee</th>
            <th>Basic Salary</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>$<?= number_format($row['basic_salary'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
