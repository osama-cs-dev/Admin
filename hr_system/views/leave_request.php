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
    $employee_id = $_POST['employee_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO leaves (employee_id, start_date, end_date, reason) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $employee_id, $start_date, $end_date, $reason);

    if ($stmt->execute()) {
        $msg = " Leave request submitted successfully!";
    } else {
        $msg = " Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Request</title>
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

        .form-box {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 500px;
        }

        h2 {
            color: #1e1e2f;
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
        }

        select, input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            resize: vertical;
        }

        textarea {
            min-height: 100px;
        }

        button {
            background: #00d4ff;
            color: #fff;
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
            text-decoration: none;
            color: #00aacc;
            display: inline-block;
            margin-top: 20px;
        }

        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h2>📄 Employee Leave Request</h2>
    <div class="form-box">
        <form method="POST">
            <label>Employee:</label>
            <select name="employee_id" required>
                <option value="">-- Select Employee --</option>
                <?php while ($emp = $employees->fetch_assoc()): ?>
                    <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label>Start Date:</label>
            <input type="date" name="start_date" required><br><br>

            <label>End Date:</label>
            <input type="date" name="end_date" required><br><br>

            <label>Reason:</label>
            <textarea name="reason" required></textarea><br><br>

            <button type="submit">Submit Leave Request</button>
        </form>

        <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
