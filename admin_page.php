<?php

include 'config.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
    header("location:login_form.php");

}


?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
    <style>

body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('');
            /* Replace with the path to your background image */
            background-size: cover;
            background-position: center;
            height: 120vh;

            justify-content: center;
            align-items: center;
            position: relative;

        }

        body::before {
            content: "";
            background-image: url('students.png');
            /* Replace with the path to your watermark image */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.4;
            /* Adjust the opacity as needed */
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: -1;

        }
    </style>

</head>

<body>
    <div class="container">

        <div class="content">
            <h3>Hi, <span>Admin</span></h3>
            <h1>Welcome <span>
                    <?php echo $_SESSION['admin_name'] ?>
                </span></h1>
            <p>This is an Admin Page</p>
            <a href="login_form.php" class="btn">Login</a>
            <a href="regsiter_form.php" class="btn">Regsiter</a>
            <a href="logout.php" class="btn">Logout</a>
            <br><br><br>
            <a href="index.php" class="btn">Student Page</a>
            <a href="teacher.php" class="btn">Teacher Page</a>
            <a href="Course.php" class="btn">Course Page</a>
            <br><br><br>
            <a href="student_enrollment.php" class="btn">Student Enrollment</a>
            <a href="marks.php" class="btn">Student Marks</a>

        </div>


    </div>

</body>

</html>