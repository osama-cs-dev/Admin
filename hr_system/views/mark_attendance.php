<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";
$msg = "";


$employees = $conn->query("SELECT * FROM employees");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    foreach ($_POST['status'] as $emp_id => $status) {
        $stmt = $conn->prepare("INSERT INTO attendance (employee_id, date, status) VALUES (?, ?, ?)
                                 ON DUPLICATE KEY UPDATE status=?");
        $stmt->bind_param("isss", $emp_id, $date, $status, $status);
        $stmt->execute();
    }
    $msg = " Attendance recorded successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
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

        .form-box {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        label {
            font-weight: 500;
        }

        input, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        button {
            background: #00d4ff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background: #00aacc;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #00aacc;
        }

        p {
            margin-top: 10px;
            color: green;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h2>📝 Mark Daily Attendance</h2>
    <div class="form-box">
        <form method="POST">
            <label>Date:</label><br>
            <input type="date" name="date" required value="<?= date('Y-m-d') ?>"><br><br>

            <table>
                <tr>
                    <th>Employee</th>
                    <th>Status</th>
                </tr>
                <?php while ($emp = $employees->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($emp['name']) ?></td>
                        <td>
                            <select name="status[<?= $emp['id'] ?>]">
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <button type="submit">Mark Attendance</button>
        </form>

        <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
