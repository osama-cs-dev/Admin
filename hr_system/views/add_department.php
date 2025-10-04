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
    $stmt = $conn->prepare("INSERT INTO departments (name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        $msg = " Department added successfully!";
    } else {
        $msg = " Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
    <style>
        .content {
            margin-left: 260px;
            padding: 40px;
        }

        .form-box {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        h2 {
            color: #1e1e2f;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
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
            margin-top: 10px;
        }

        button:hover {
            background: #00aacc;
        }

        p {
            margin-top: 15px;
        }

        a {
            text-decoration: none;
            color: #00aacc;
        }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h2> Add New Department</h2>
    <div class="form-box">
        <form method="POST">
            <label>Department Name:</label><br>
            <input type="text" name="name" required><br><br>
            <button type="submit">Add Department</button>
        </form>

        <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

        <br><a href="view_departments.php">⬅ Back to Departments List</a>
    </div>
</div>

</body>
</html>
