<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";

$msg = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department_id = $_POST['department_id'];
    $salary = $_POST['salary'];

    $stmt = $conn->prepare("INSERT INTO employees (name, email, phone, department_id, salary) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssid", $name, $email, $phone, $department_id, $salary);

    if ($stmt->execute()) {
        $msg = " Employee added successfully!";
    } else {
        $msg = " Error: " . $stmt->error;
    }
}


$departments = $conn->query("SELECT * FROM departments");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
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

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
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
            margin-top: 15px;
        }

        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h2>Add New Employee</h2>
    <div class="form-box">
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" required><br><br>

            <label>Email:</label>
            <input type="email" name="email" required><br><br>

            <label>Phone:</label>
            <input type="text" name="phone" required><br><br>

            <label>Department:</label>
            <select name="department_id" required>
                <option value="">-- Select Department --</option>
                <?php while ($dept = $departments->fetch_assoc()): ?>
                    <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label>Salary:</label>
            <input type="number" name="salary" step="0.01" required><br><br>

            <button type="submit">Add Employee</button>
        </form>

        <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

        <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
