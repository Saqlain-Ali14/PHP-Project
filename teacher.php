<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "DataBase Not Connected";
}
if (isset($_POST['addteacher'])) {
    $name = $_POST['teachername'];
    $designation = $_POST['teacherdesignation'];
    $course = $_POST['teachercourse'];
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
                echo $query = "insert into teacher(name,designation,course,image) values ('$name','$designation','$course','$imagename')";

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
    $query = "delete from teacher where id=$id";
    $result = mysqli_query($con, $query);
    echo "Data has been deleted Successfully";
}
$query = "select * from teacher";
$result = mysqli_query($con, $query);


// search code




if (isset($_POST['searchTeacherName'])) {
    $searchTeacherName = $_POST['searchTeacherName'];
    $searchQuery = "SELECT * FROM teacher WHERE name LIKE '%$searchTeacherName%'";
    $searchResult = mysqli_query($con, $searchQuery);

    // Display search results
    echo '<table border="3">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Course</th>
                <th>Image</th>
                
            </tr>';
            
    while ($row = mysqli_fetch_assoc($searchResult)) {
        echo  '<tr> 
               <td>' . $row['id'] . '</td> 
                <td>' . $row['name'] . '</td>
                <td>' . $row['designation'] . '</td>
                <td>' . $row['course'] . '</td>
                <td><img src="uploads/' . $row['image'] . '" height="250px" width="250px" /></td>
                
                
            </tr>';
    }
    echo '</table>';
    
    exit; // Stop further execution
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>Teacher Page</title>

    <h1 class="welcome-heading">"Welcome to Teacher Page"</h1>
    <link rel="stylesheet" href="css/styleteacher.css">

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
<form action="teacher.php" method="post" id="searchForm">
    <label for="searchTeacherName"><b>Search by Teacher Name :</b> </label>
    <input type="text" name="searchTeacherName" id="searchTeacherName" class="form-input">
    <input type="submit" value="Search" class="form-button">
</form>
<div id="searchResults"></div>

    
<a href="admin_page.php" class="back-button">Back</a>


    <form action="teacher.php" method="post" enctype="multipart/form-data" id="marksForm">
        <input type="text" name="teachername" placeholder="Name" class="form-input" >
        <input type="text" name="teacherdesignation" placeholder="Designation" class="form-input" >
        <input type="text" name="teachercourse" placeholder="course" class="form-input" >
        <input type="file" name="image" class="form-input" >
        <input type="submit" name="addteacher" value="submit" class="form-button">

    </form>
    <div id="error-message" class="error-message"></div>
    <br><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Course</th>
            <th>Image</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                   <b> <?php echo $row['id'] ?></b>
                </td>
                <td>
                  <b>  <?php echo $row['name'] ?></b>
                </td>
                <td>
                  <b>  <?php echo $row['designation'] ?> </b>
                </td>
                <td>
                <b>    <?php echo $row['course'] ?> </b>
                </td>
                <td>
                    <img src="uploads/<?php echo $row['image'] ?>" height="110px" width="110px" />
                </td>
                <td><a href="teacheredit.php?eid=<?php echo $row['id'] ?>"> <button class="edit-button"> Edit</button></a>
                </td>
                <td><a href="teacher.php?did=<?php echo $row['id'] ?>"><button class="delete-button">Delete</button></a>
                </td>
            </tr>
        <?php } ?>

    </table>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
//live  search code
$(document).ready(function () {
            $("#searchTeacherName").keyup(function () {
                // Retrieve the search query
                var searchTeacherName = $(this).val();

                // Check if the input field is not empty
                if (searchTeacherName.trim() !== "") {
                    // Send an Ajax request to fetch search results
                    $.ajax({
                        type: "POST",
                        // url: "teacher.php",
                        data: { searchTeacherName: searchTeacherName },
                        success: function (data) {
                            // Display search results
                            $("#searchResults").html(data);
                        }
                    });
                } 
                
                else 
                {
                    // Clear the display if input field is empty
                    $("#searchResults").html("");
                }
                
                
            });
        });


// live search code ends

// form validations
    $(document).ready(function () {
        $("#marksForm").submit(function (event) {
            // Remove previous error styles
            $('.error-input').removeClass('error-input');
            $('#error-message').text('');

            // Check if MidTerm, FinalTerm, and Sessional fields are not empty
            if ($('[name="teachername"]').val() === "" || $('[name="teacherdesignation"]').val() === "" || $('[name="teachercourse"]').val() === "") {
                $('#error-message').text("Please fill in all marks fields.");
                $('[name="teachername"]').addClass('error-input');
                $('[name="teachercourse"]').addClass('error-input');
                $('[name="teacherdesignation"]').addClass('error-input');
                event.preventDefault(); // Prevent form submission
            }
            else {
                
                

                if (!/^[a-zA-Z\s]+$/.test($('[name="teachername"]').val()))
                 {
                $('#error-message').text("Please enter valid characters for Name (no numbers).");
                $('[name="teachername"]').addClass('error-input');
                event.preventDefault(); // Prevent form submission
                }

                if (!/^[a-zA-Z\s]+$/.test($('[name="teachercourse"]').val())) 
                {
                $('#error-message').text("Please enter valid characters for Course (no numbers).");
                $('[name="teachercourse"]').addClass('error-input');
                event.preventDefault(); // Prevent form submission
                 }

            if (!/^[a-zA-Z\s]+$/.test($('[name="teacherdesignation"]').val())) 
            {
                $('#error-message').text("Please enter valid characters for Designation (no numbers).");
                $('[name="teacherdesignation"]').addClass('error-input');
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