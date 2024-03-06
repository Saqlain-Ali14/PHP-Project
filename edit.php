<?php
$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "DataBase Not Connected";
}
if (isset($_POST['updatestudent'])) {
    $id = $_GET['eid'];
    $oldname = $_POST['oldname'];
    $name = $_POST['studentname'];
    $class = $_POST['studentclass'];
    $program = $_POST['studentprogram'];
    $target = "uploads/";
    $uploadok = 1;
    $imagename = $_FILES['image']['name']; //null
    echo $imagename;
    $newfile = $target . $imagename;

    if ($imagename == "") 
    {
        echo $query = "update student set name='$name',class='$class', program='$program' where id=$id";

        $imagename = $oldname;
    }
     else {


        move_uploaded_file($_FILES['image']['tmp_name'], $newfile);

        $imagefiletype = strtolower(pathinfo($newfile, PATHINFO_EXTENSION));
        // Allow certain file formats
        if ($imagefiletype != "jpg" && $imagefiletype != "jpeg" && $imagefiletype != "png" && $imagefiletype != "gif") {
            echo "Sorry!!Only JPG,JPEG,PNG, and GIF are Allowed ";
            $uploadok = 0;
        } else {


            if ($_FILES['image']['size'] > 5000000) {
                echo "Sorry!!Only Upload file upto 5MB";
                $uploadok = 0;
            } else {
                echo $query = "update student set name='$name',class='$class', program='$program',image='$imagename' where id=$id";
            }
        }
    }
    if (mysqli_query($con, $query)) {
        echo "Data Has Been Addedd Successfully";
        header("Location:index.php");
    } else {
        echo "Data not Added";
    }
}





//Show Record
if (isset($_GET['eid'])) {
    $id = $_GET['eid'];
    $query = "select * from student where id=$id";
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
    <h1 class="welcome-heading">"Welcome to Edit Page"</h1>
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
    </style>



</head>

<body>

    <a href="index.php" class="back-button">Back</a>

    <form action="edit.php?eid=<?php echo $row['id'] ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $row['image'] ?>" name="oldname" class="form-input">
        <input type="text" value="<?php echo $row['name'] ?>" name="studentname" placeholder="Student Name"
            class="form-input">
        <input type="text" value="<?php echo $row['class'] ?>" name="studentclass" placeholder="Student Class"
            class="form-input">
        <input type="text" value="<?php echo $row['program'] ?>" name="studentprogram" placeholder="Student program"
            class="form-input">
        <input type="file" name="image" class="form-input">
        <img src="uploads/<?php echo $row['image'] ?>" height="50px"  width="50px" />
        <input type="submit" name="updatestudent" value="submit" class="form-button">
    </form>

</body>

</html>