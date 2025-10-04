<!-- views/sidebar.php -->
<div class="sidebar">
    <h2>HR Dashboard</h2>
    <ul>
        <li><a href="view_employees.php"> View Employees</a></li>
        <li><a href="view_departments.php"> View Departments</a></li>
        <li><a href="mark_attendance.php"> Mark Attendance</a></li>
        <li><a href="view_attendance.php"> View Attendance</a></li>
        <li><a href="leave_request.php"> Leave Request</a></li>
        <li><a href="manage_leaves.php"> Manage Leaves</a></li>
        <li><a href="set_salary.php"> Set Salary</a></li>
        <li><a href="payslip.php">View Payslip</a></li>
        <li><a href="report_by_department.php"> Report by Department</a></li>
        <li><a href="logout.php" class="logout"> Logout</a></li>
    </ul>
</div>

<style>
    .sidebar {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}
.sidebar {
    width: 240px;
    height: 100vh;
    background: #1e1e2f;
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
    overflow-y: auto; /* مهم */
}

.logout {
    color: #ff6b6b !important;
    padding: 10px;
    display: block;
}

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: #f4f6f8;
}

.sidebar {
    width: 240px;
    height: 100vh;
    background: #1e1e2f;
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 22px;
    color: #00d4ff;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 15px 0;
}

.sidebar ul li a {
    color: #ccc;
    text-decoration: none;
    font-size: 16px;
    display: block;
    padding: 10px;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar ul li a:hover {
    background: #00d4ff;
    color: #1e1e2f;
}

.logout {
    color: #ff6b6b !important;
}
</style>
