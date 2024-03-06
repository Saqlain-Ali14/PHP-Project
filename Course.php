<?php
// include("logincheckup.php");
$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "Data Base Not Connected";
}
if (isset($_POST['addcourse'])) {

    $name = $_POST['coursename'];
    $credithours = $_POST['credithours'];

    echo $query = "insert into course (name,credithours) values ('$name','$credithours')";
    if (mysqli_query($con, $query)) {
        echo "Data has been Added Successfully";
    } else {
        echo "Record Not Added";
    }

}
if (isset($_GET['did'])) {
    $id = $_GET['did'];
    $query = "delete from course where id=$id";
    $result = mysqli_query($con, $query);
}
$query = "select * from course";

$result = mysqli_query($con, $query);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Page</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="css\style_Course.css">

    <h1 class="welcome-heading">"Welcome to Course Page"</h1>
    
    
</head>

<body>


    <a href="admin_page.php" class="back-button">Back</a>

    <form action="Course.php" method="post" id="marksForm">


        <input type="text" name="coursename" placeholder="Course Name" class="form-input" >
        <input type="text" name="credithours" placeholder=" Credit Hours" class="form-input" >
        <input type="submit" name="addcourse" value="submit" class="form-button" >


    </form>


    <div id="error-message" class="error-message"></div>
    

    <table border="1">
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Credit Hours</th>
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
                    <?php echo $row['credithours'] ?>
                </td>


                <td><a href="Courseedit.php?eid=<?php echo $row['id'] ?>"><button class="edit-button">Edit</button></a></td>
                <td>
                    <a href="Course.php?did=<?php echo $row['id'] ?>"> <button class="delete-button">Delete</button></a>
                </td>


            </tr>
        <?php } ?>



    </table>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>


$(document).ready(function () {
        $("#marksForm").submit(function (event) {
            // Remove previous error styles
            $('.error-input').removeClass('error-input');
            $('#error-message').text('');

            // Check if Name, Class, and Program fields are not empty
            if ($('[name="coursename"]').val() === "" || $('[name="credithours"]').val() === "") 
            {
                $('#error-message').text("Please fill in all fields.");
                $('[name="coursename"]').addClass('error-input');
                $('[name="credithours"]').addClass('error-input');
                event.preventDefault(); // Prevent form submission
            } 
            else 
            {
                
                if ($.isNumeric($('[name="coursename"]').val())) {
                        $('#error-message').text("Please enter valid characters for Course Name (no numbers).");
                        $('[name="coursename"]').addClass('error-input');
                        event.preventDefault();
                    }

                // Check if credithours fields contain only characters
                if (!$.isNumeric($('[name="credithours"]').val())) 
                    {
                        $('#error-message').text("Please enter a numeric value for CreditHours.");
                        $('[name="credithours"]').addClass('error-input');
                        event.preventDefault(); // Prevent form submission
                    }


            
            }
        });
    });




    
    </script>

</html>