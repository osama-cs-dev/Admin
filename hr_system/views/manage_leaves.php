<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";


if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    $stmt = $conn->prepare("UPDATE leaves SET status=? WHERE id=?");
    $stmt->bind_param("si", $action, $id);
    $stmt->execute();
    header("Location: manage_leaves.php");
    exit;
}

$result = $conn->query("
    SELECT leaves.*, employees.name 
    FROM leaves 
    JOIN employees ON leaves.employee_id = employees.id
    ORDER BY leaves.start_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Leaves</title>
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
            color: #fff;
        }

        tr:hover {
            background: #f1faff;
        }

        a.action {
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            margin: 0 3px;
        }

        a.approve {
            background: #28a745;
        }

        a.reject {
            background: #dc3545;
        }

        a.disabled {
            color: #888;
            pointer-events: none;
        }

        a.back {
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
    <h2> Leave Requests</h2>

    <table>
        <tr>
            <th>Employee</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['start_date']) ?></td>
                <td><?= htmlspecialchars($row['end_date']) ?></td>
                <td><?= htmlspecialchars($row['reason']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <?php if ($row['status'] == "Pending"): ?>
                        <a class="action approve" href="manage_leaves.php?action=Approved&id=<?= $row['id'] ?>">✅ Approve</a>
                        <a class="action reject" href="manage_leaves.php?action=Rejected&id=<?= $row['id'] ?>">❌ Reject</a>
                    <?php else: ?>
                        <span class="action disabled">-</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a class="back" href="dashboard.php"> Back to Dashboard</a>
</div>

</body>
</html>
