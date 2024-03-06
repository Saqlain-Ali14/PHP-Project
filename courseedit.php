<?php
$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "DataBase Not Connected";
}
if (isset($_POST['updatecourse']))
 {
    $id = $_GET['eid'];
    
    $name = $_POST['coursename'];
    $credithours = $_POST['credithours'];
    
   echo $query = "update course set name='$name',credithours='$credithours' where id=$id";
            
        
    if (mysqli_query($con, $query)) {
        echo "Data Has Been Addedd Successfully";
        header("Location:Course.php");
    } else {
        echo "Data not Added";
    }
}

//Show Record
if (isset($_GET['eid'])) {
    $id = $_GET['eid'];
    $query = "select * from course where id=$id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Edit.Php</title>
    <h1 class="welcome-heading">"Welcome to Course Edit Page"</h1>
    <style>
        /* Edit button style */
        .edit-button {
            background-color: #4CAF50;
            /* Green */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;

            font-size: 16px;
            display: inline-block;
        }

        /* Delete button style */
        .delete-button {
            background-color: #f44336;
            /* Red */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        /* ///////Border Setting///// */

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* //////INput Fields// */


        .form-input {
            margin-top: 20px;
            width: 20%;
            padding: 9px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            
        }

        .form-input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.6);
        }

        .form-button {
            background-color: #2ecc71;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 15px;
            margin-left: 50px;

        }

        .form-button:hover {
            background-color: #27ae60;
        }

        .form-button:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.6);
        }

        .welcome-heading {
            font-size: 30px;
            color: #3498db;
            color: #673AB7;
            /* Blue color */
            margin-bottom: 20px;
            text-align: center;


        }

        /* ///BACK BUTTON//// */


        .back-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background-color: #3498db;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #2980b9;
        }


        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url(''); /* Replace with the path to your background image */
            background-size: cover;
            background-position: center;
            height: 160vh;
            /* display: flex; */
            justify-content: center;
            align-items: center;
            position: relative;
            
        }

        body::before {
            content: "";
            background-image: url('pics/coursepage.jpg'); /* Replace with the path to your watermark image */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.3; /* Adjust the opacity as needed */
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

    <a href="Course.php" class="back-button">Back</a>

    <form action="courseedit.php?eid=<?php echo $row['id'] ?>" method="post" enctype="multipart/form-data">
        
        <input type="text" value="<?php echo $row['name'] ?>" name="coursename" class="form-input">
        <input type="text" value="<?php echo $row['credithours'] ?>" name="credithours" class="form-input">
        
        <input type="submit" name="updatecourse" value="submit" class="form-button">
    </form>

</body>

</html>