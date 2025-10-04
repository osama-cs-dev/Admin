<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";

$month = date('Y-m'); 
if (isset($_GET['month'])) {
    $month = $_GET['month'];
}

$result = $conn->query("
    SELECT employees.name, 
           SUM(attendance.status='Present') AS present_days, 
           SUM(attendance.status='Absent') AS absent_days
    FROM attendance
    JOIN employees ON attendance.employee_id = employees.id
    WHERE DATE_FORMAT(attendance.date,'%Y-%m') = '$month'
    GROUP BY employees.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Attendance Report</title>
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

        form {
            margin-bottom: 25px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: inline-block;
        }

        input[type="month"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background: #00d4ff;
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #00aacc;
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
            color: #fff;
        }

        tr:hover {
            background: #f1faff;
        }

        a {
            text-decoration: none;
            color: #00aacc;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h2> Monthly Attendance Report (<?= htmlspecialchars($month) ?>)</h2>

    <form method="GET">
        <label>Select Month:</label>
        <input type="month" name="month" value="<?= htmlspecialchars($month) ?>">
        <button type="submit">View</button>
    </form>

    <table>
        <tr>
            <th>Employee</th>
            <th>Present Days</th>
            <th>Absent Days</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['present_days']) ?></td>
                <td><?= htmlspecialchars($row['absent_days']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
