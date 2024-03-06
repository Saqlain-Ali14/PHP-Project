<?php
// include("logincheckup.php");
$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "DataBase Not Connected";
}

if (isset($_POST["enrollment"])) {
    $studentid = $_POST['studentid'];
    $courseid = $_POST['courseid'];
    $session = $_POST['session'];
    $year = $_POST['year'];

    echo $query = "insert into student_enrollment(sid,cid,session,year) values ('$studentid','$courseid','$session',$year)";
    if (mysqli_query($con, $query)) {
        echo "Data has been added";

    } else {
        echo "Data not added";
    }
}

//delete code
if (isset($_GET["delete_id"])) {
    $deleteId = $_GET['delete_id'];

    $deleteQuery = "DELETE FROM student_enrollment WHERE seid = $deleteId";

    if (mysqli_query($con, $deleteQuery)) {
        echo "Data Deleted";
    } else {
        echo "Data Not Deleted";
    }
}



 $query = "SELECT * FROM student_enrollment"; 
 $result = mysqli_query($con, $query);

$query = "select * from student";
$result = mysqli_query($con, $query);

$query="select * from course";
$results = mysqli_query($con, $query);
$query="SELECT s.name,se.session,se.year,se.seid,c.name as coursename FROM `student_enrollment` se 
join student s on se.sid=s.id
join course c on se.cid=c.id";
$resultss = mysqli_query($con, $query);






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentEnrollment</title>
    <link rel="stylesheet" href="css/stylerollment.css">
    <h1 class="welcome-heading">"Welcome to Enrollment Page"</h1>
    <style>
    .error-message  {
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

    <form action="student_enrollment.php" method="post" id="marksForm">

        <input type="text" name="session" placeholder="Session"class="form-input">
        <input type="text" name="year" placeholder="Year"class="form-input">
        <select name="studentid" class="form-input">
            
            <?php while ($row = mysqli_fetch_assoc($result))
             { ?>

                
                <option value="<?php echo $row["id"]; ?> "> <?php echo $row["name"]; ?> </option>

            <?php } ?>
        </select>


        <select name="courseid" class="form-input">
            <?php while ($row = mysqli_fetch_assoc($results)) { ?>

                <option value="<?php echo $row["id"]; ?>">
                <?php echo $row["name"]; ?> 
                
                    
                </option>

            <?php } ?>
        </select>


        <input type="submit" value="submit" name="enrollment" class="form-button">


    </form>

    <div id="error-message" class="error-message"></div>

    <table border="1">
        <tr>
            <th>Id#</th>
            <th>Student Name</th>
            <th>Session</th>
            <th>Year</th>
            <th>Course Name</th>
            <th>Delete</th>
            

        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultss)) { ?>
            <tr>
                
            <td>
                <?php echo $row['seid']?>
            </td>

                <td>
                    <?php echo $row['name'] ?>
                </td>
                <td>
                    <?php echo $row['session'] ?>
                </td>
                <td>
                    <?php echo $row['year'] ?>
                </td>
                <td>
                    <?php echo $row['coursename'] ?>
                </td>
                
                <td><a href="student_enrollment.php?delete_id=<?php echo $row['seid']; ?>"
                        onclick="return confirm('Are you sure you want to delete this record?')"> <button type="button"
                            class="delete-button" name="delete"> Delete</button></a></td>

                

            </tr>
        <?php } ?>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>


$(document).ready(function () {
        $("#marksForm").submit(function (event) {
            // Remove previous error styles
            $('.error-input').removeClass('error-input');
            $('#error-message').text('');

            // Check if Name, Class, and Program fields are not empty
            if ($('[name="session"]').val() === "" || $('[name="year"]').val() === "")  
            {
                $('#error-message').text("Please fill in all fields.");
                $('[name="session"]').addClass('error-input');
                $('[name="year"]').addClass('error-input');
                event.preventDefault(); // Prevent form submission
            } 
            else 
            {
                
                if ($.isNumeric($('[name="session"]').val())) {
                        $('#error-message').text("Please enter valid characters for session (no numbers).");
                        $('[name="session"]').addClass('error-input');
                        event.preventDefault();
                    }

                // Check if credithours fields contain only characters
                if (!$.isNumeric($('[name="year"]').val())) 
                    {
                        $('#error-message').text("Please enter a numeric value for Year.");
                        $('[name="year"]').addClass('error-input');
                        event.preventDefault(); // Prevent form submission
                    }

                


            
            }
        });
    });




    
    </script>
</body>

</html>