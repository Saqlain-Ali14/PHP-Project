<?php
// include("logincheckup.php");
$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "DataBase Not Connected";
}
if (isset($_POST['addstudent'])) {
    $name = $_POST['studentname'];
    $class = $_POST['studentclass'];
    $program = $_POST['studentprogram'];
    $target = "uploads/";
    $uploadok = 1;
    $imagename = $_FILES['image']['name'];
    $newfile = $target . $imagename;

    $imagefiletype = strtolower(pathinfo($newfile, PATHINFO_EXTENSION));
    // Allow certain file formats
    if ($imagefiletype != "jpg" && $imagefiletype != "png" && $imagefiletype != "jpeg" && $imagefiletype != "gif") {
        echo "Sorry!! Only Jpg,png,jpeg and Gif are Allowed";
        $uploadok = 0;
    } else {
        if ($_FILES['image']['size'] > 500000) {
            echo "Sorry!! You can upload only file upto 5MB";
            $uploadok = 0;
        } else {
            if (file_exists($newfile)) {
                echo " <b>Sorry, file already exists. <b> ";
                $uploadok = 0;
            } else {

                move_uploaded_file($_FILES['image']['tmp_name'], $newfile);
                echo $query = "insert into student(name,class,program,image) values ('$name','$class','$program','$imagename')";

                if (mysqli_query($con, $query)) {
                    echo "Data has been Added Successfully";
                } else {
                    echo "Data not Added";
                }

            }
        }
    }

}
if (isset($_GET['did'])) {
    $id = $_GET['did'];
    $query = "delete from student where id=$id";
    $result = mysqli_query($con, $query);
    if (mysqli_query($con, $query)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}
$query = "select * from student";
$result = mysqli_query($con, $query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page</title>
    <link rel="stylesheet" href="css/stylestudent.css">
    <h1 class="welcome-heading">"Welcome to Student Page"</h1>
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 5px;
        }

        .error-input {
            border: 1px solid red;
        }
    </style>

</head>

<body>


    <a href="admin_page.php" class="back-button">Back</a>

    <form action="index.php" method="post" enctype="multipart/form-data" id="marksForm">
        <input type="text" name="studentname" placeholder="Name" class="form-input">
        <input type="text" name="studentclass" placeholder="Class" class="form-input">
        <input type="text" name="studentprogram" placeholder="Program" class="form-input">
        <input type="file" name="image" class="form-input">
        <input type="submit" name="addstudent" value="submit" class="form-button">


    </form>

    <div id="error-message" class="error-message"></div>
    <br><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Class</th>
            <th>Program</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                    <?php echo $row['id'] ?>
                </td>
                <td>
                    <?php echo $row['name'] ?>
                </td>
                <td>
                    <?php echo $row['class'] ?>
                </td>
                <td>
                    <?php echo $row['program'] ?>
                </td>
                <td>
                    <img src="uploads/<?php echo $row['image'] ?>" height="120px" width="120px" />
                </td>
                <td><a href="edit.php?eid=<?php echo $row['id'] ?>"> <button class="edit-button"> Edit</button></a></td>
                <td><a href="index.php?did=<?php echo $row['id'] ?>"> <button class="delete-button"> Delete</button></a>
                </td>

            </tr>
        <?php } ?>


    </table>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>


        $(document).ready(function () {
            $("#marksForm").submit(function (event) {
                // Remove previous error styles
                $('.error-input').removeClass('error-input');
                $('#error-message').text('');

                // Check if MidTerm, FinalTerm, and Sessional fields are not empty
                if ($('[name="studentname"]').val() === "" || $('[name="studentclass"]').val() === "" || $('[name="studentprogram"]').val() === "") {
                    $('#error-message').text("Please fill in all marks fields.");
                    $('[name="studentname"]').addClass('error-input');
                    $('[name="studentclass"]').addClass('error-input');
                    $('[name="studentprogram"]').addClass('error-input');
                    event.preventDefault(); // Prevent form submission
                }
                else {
                    
                    // Check if Image field is not empty
                    // if ($('[name="image"]').val() === "") 
                    // {
                    //     $('#error-message').text("Please select an image file.");
                    //     $('[name="image"]').addClass('error-input');
                    //     event.preventDefault(); // Prevent form submission
                    // }

                    if (!/^[a-zA-Z\s]+$/.test($('[name="studentname"]').val()))
                     {
                    $('#error-message').text("Please enter valid characters for Name (no numbers).");
                    $('[name="studentname"]').addClass('error-input');
                    event.preventDefault(); // Prevent form submission
                    }

                    if (!/^[a-zA-Z\s]+$/.test($('[name="studentclass"]').val())) 
                    {
                    $('#error-message').text("Please enter valid characters for Class (no numbers).");
                    $('[name="studentclass"]').addClass('error-input');
                    event.preventDefault(); // Prevent form submission
                     }

                if (!/^[a-zA-Z\s]+$/.test($('[name="studentprogram"]').val())) 
                {
                    $('#error-message').text("Please enter valid characters for Program (no numbers).");
                    $('[name="studentprogram"]').addClass('error-input');
                    event.preventDefault(); // Prevent form submission
                }

                // Check if Image field is not empty
                if ($('[name="image"]').val() === "")
                 {
                    $('#error-message').text("Please select an image file.");
                    $('[name="image"]').addClass('error-input');
                    event.preventDefault(); // Prevent form submission
                }

                 

                
                }
            })
        });

    </script>
</body>

</html>