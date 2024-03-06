<?php
$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "DataBase not connected";
}
if (isset($_POST["updatemarks"]))
 {
    $id = $_GET['eid'];
    $studentid = $_POST['studentid'];
    $courseid = $_POST['courseid'];
    $midmarks = $_POST['mid'];
    $finalmarks = $_POST['final'];
    $Sessionalmarks = $_POST['smarks'];


    echo $query = "update marks set midterm=$midmarks,final=$finalmarks,sessional=$Sessionalmarks,sid=$studentid,cid=$courseid where mid=$id";
    

    if (mysqli_query($con, $query))
     {
        echo "Data Updated Successfully";
        header("location:marks.php");
    } else {
        echo "Data Not Added";
    }

}

//Show Record
if (isset($_GET['eid'])) 
{
    $id = $_GET['eid'];
     $query = "select * from marks where mid=$id";
     $result = mysqli_query($con, $query);
     $row = mysqli_fetch_assoc($result);


}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Edit Page</title>
    <h1 class="welcome-heading">"Welcome to Marks Edit Page"</h1>
    
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
            width: 12%;
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
    <a href="marks.php" class="back-button">Back</a>
    <form action="marks.php?eid=<?php echo $row['mid'] ?>" method="post" id="marksForm">


        <label>Mid Term</label>
        <input type="text" value="<?php echo $row['midterm'] ?>" name="mid" class="form-input">
        <label>Final Term</label>
        <input type="text" value="<?php echo $row['final'] ?>" name="final" class="form-input">
        <label>Sessional</label>
        <input type="text" value="<?php echo $row['sessional'] ?>" name="smarks" class="form-input">


        
        <input type="submit" name="updatemarks" class="form-button">


    </form>


</body>

</html>