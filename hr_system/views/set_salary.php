<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";
$msg = "";

// Get employees
$employees = $conn->query("SELECT * FROM employees");

// Save basic salary
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $basic_salary = $_POST['basic_salary'];

    $stmt = $conn->prepare("
        INSERT INTO payroll (employee_id, basic_salary) VALUES (?, ?)
        ON DUPLICATE KEY UPDATE basic_salary=?
    ");
    $stmt->bind_param("idd", $employee_id, $basic_salary, $basic_salary);

    if ($stmt->execute()) {
        $msg = "✅ Basic salary set successfully!";
    } else {
        $msg = "❌ Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Basic Salary</title>
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
            max-width: 500px;
        }

        label {
            font-weight: 500;
        }

        select, input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
        }

        button {
            background: #00d4ff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
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
    <h2>💰 Set Basic Salary</h2>
    <div class="form-box">
        <form method="POST">
            <label>Employee:</label><br>
            <select name="employee_id" required>
                <option value="">-- Select Employee --</option>
                <?php while ($emp = $employees->fetch_assoc()): ?>
                    <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label>Basic Salary:</label><br>
            <input type="number" step="0.01" name="basic_salary" required><br><br>

            <button type="submit">Save Salary</button>
        </form>

        <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
