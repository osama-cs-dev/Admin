<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";

// Delete department
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM departments WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: view_departments.php");
    exit;
}

$result = $conn->query("SELECT * FROM departments");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Departments</title>
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

        a {
            text-decoration: none;
            color: #00aacc;
            font-weight: bold;
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

        .add-button {
            display: inline-block;
            background: #00d4ff;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .action-link {
            margin: 0 5px;
            color: #1e1e2f;
        }

        .action-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h2>📋 Departments List</h2>

    <a href="add_department.php" class="add-button">➕ Add New Department</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <a href="edit_department.php?id=<?= $row['id'] ?>" class="action-link">✏️ Edit</a> |
                        <a href="view_departments.php?delete_id=<?= $row['id'] ?>" class="action-link" onclick="return confirm('Are you sure?')">❌ Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">No departments found.</td></tr>
        <?php endif; ?>
    </table>

    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
