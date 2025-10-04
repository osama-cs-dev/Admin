<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";

$msg = "";


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM departments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $department = $result->fetch_assoc();
} else {
    header("Location: view_departments.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE departments SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        $msg = " Department updated successfully!";
        header("Location: view_departments.php");
        exit;
    } else {
        $msg = " Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Department</title>
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
            max-width: 400px;
        }

        h2 {
            color: #1e1e2f;
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
        }

        input {
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
    <h2>✏ Edit Department</h2>
    <div class="form-box">
        <form method="POST">
            <label>Department Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($department['name']) ?>" required><br><br>
            <button type="submit">Update Department</button>
        </form>

        <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>

        <a href="view_departments.php">⬅ Back to Departments List</a>
    </div>
</div>

</body>
</html>
