<?php
// include("logincheckup.php");
$con = mysqli_connect("localhost", "root", "", "Student_Management_System");
if (!$con) {
    echo "DataBase not connected";
}
if (isset($_POST["addmarks"])) {
    $studentid = $_POST['studentid'];
    $courseid = $_POST['courseid'];
    $midmarks = $_POST['mid'];
    $finalmarks = $_POST['final'];
    $Sessionalmarks = $_POST['smarks'];

    echo $query = "insert into marks(midterm,final,sessional,sid,cid) values ($midmarks,$finalmarks,$Sessionalmarks,$studentid,$courseid)";
    if (mysqli_query($con, $query)) {
        echo "Data Added";
    } else {
        echo "Data Not Added";
    }

}

$query = "select * from marks ";
$result = mysqli_query($con, $query);

$query = "select * from student";
$result = mysqli_query($con, $query);

$query = "select * from course";
$results = mysqli_query($con, $query);



//delete section
if (isset($_GET["delete_id"])) {
    $deleteId = $_GET['delete_id'];

    $deleteQuery = "DELETE FROM marks WHERE mid = $deleteId";

    if (mysqli_query($con, $deleteQuery)) {
        echo "Data Deleted";
    } else {
        echo "Data Not Deleted";
    }
}


$query = "SELECT s.name, se.session, se.year, c.name as coursename,
m.mid,m.sessional, m.midterm, m.final,(m.sessional + m.midterm + m.final) AS obtained_marks
FROM student_enrollment se
JOIN student s ON se.sid = s.id
JOIN course c ON se.cid = c.id
JOIN marks m ON m.cid = c.id";
$resultsss = mysqli_query($con, $query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks</title>
    <link rel="stylesheet" href="sytlemarks.css">
    <h1 class="welcome-heading">"Welcome to Marks Page"</h1>

    <style>
        .print-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
            margin-left: 10px;
        }

        .print-button:hover {
            background-color: #3498db;
        }


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


    <form action="marks.php" method="post" id="marksForm">

        <input type="text" name="mid" placeholder="MidTerm Marks" class="form-input">
        <input type="text" name="final" placeholder="FinalTerm Marks" class="form-input">
        <input type="text" name="smarks" placeholder="Sessional Marks" class="form-input">

        <select name="studentid" class="form-input" onchange="abc()">

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['name']; ?>


                </option>

            <?php } ?>
        </select>



        <select name="courseid" class="form-input" id="courseSelect" onclick="clearSelect()">

        </select>

        <input type="submit" name="addmarks" class="form-button">


    </form>

<!-- //form validation -->
<div id="error-message" class="error-message"></div>


    <table border="1">
        <tr>
            <th>ID #</th>
            <th>Student Name</th>
            <th>Course Name</th>
            <th>Sessional</th>
            <th>Mid Term Marks</th>
            <th>Final Marks</th>
            <th>Obtained Marks</th>
            <th>Total Marks</th>
            <th>Percentage%</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultsss)) { ?>
            <tr>
                <td>
                    <?php echo $row['mid'] ?>
                </td>
                <td>
                    <?php echo $row['name'] ?>
                </td>
                <td>
                    <?php echo $row['coursename'] ?>
                </td>
                <td>
                    <?php echo $row['sessional'] ?>
                </td>
                <td>
                    <?php echo $row['midterm'] ?>
                </td>
                <td>
                    <?php echo $row['final'] ?>
                </td>
                <td>
                    <?php echo $row['obtained_marks'] ?>
                </td>
                <td>60</td>
                <td>
                    <?php echo ($row['obtained_marks'] / 60) * 100 . "%" ?>
                </td>
                <!-- <td><a href=""> <button class="edit-button"> Edit</button></a></td> -->

                <td><a href="marksedit.php?eid=<?php echo $row['mid']; ?>"
                        onclick="return confirm('Warning!! Are you sure you want to Edit this record?')"> <button
                            type="button" class="edit-button" name="edit"> Edit</button></a></td>


                <td><a href="marks.php?delete_id=<?php echo $row['mid']; ?>"
                        onclick="return confirm('Warning!! Are you sure you want to delete this record?')"> <button
                            type="button" class="delete-button" name="delete"> Delete</button></a></td>

            </tr>
        <?php } ?>






    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>


            $(document).ready(function () 
            {
            $("#marksForm").submit(function (event)
             {
                // Remove previous error styles
                $('.error-input').removeClass('error-input');
                $('#error-message').text('');

                // Check if MidTerm, FinalTerm, and Sessional fields are not empty
                if ($('[name="mid"]').val() === "" || $('[name="final"]').val() === "" || $('[name="smarks"]').val() === "") 
                {
                    $('#error-message').text("Please fill in all marks fields.");
                    $('[name="mid"]').addClass('error-input');
                    $('[name="final"]').addClass('error-input');
                    $('[name="smarks"]').addClass('error-input');
                    event.preventDefault(); // Prevent form submission
                } 
                else 
                {
                    // Check if MidTerm, FinalTerm, and Sessional fields contain numeric data

                    if (!$.isNumeric($('[name="mid"]').val())) 
                    {
                        $('#error-message').text("Please enter a numeric value for MidTerm marks.");
                        $('[name="mid"]').addClass('error-input');
                        event.preventDefault(); // Prevent form submission
                    }

                    if (!$.isNumeric($('[name="final"]').val()))
                     {
                        $('#error-message').text("Please enter a numeric value for FinalTerm marks.");
                        $('[name="final"]').addClass('error-input');
                        event.preventDefault(); // Prevent form submission
                    }

                    if (!$.isNumeric($('[name="smarks"]').val()))
                     {
                        $('#error-message').text("Please enter a numeric value for Sessional marks.");
                        $('[name="smarks"]').addClass('error-input');
                        event.preventDefault(); // Prevent form submission
                    }
                }
            })
            });





            function abc() {
                var studentId = document.querySelector('[name="studentid"]').value;

                //clear the code from the select tag
                document.getElementById('courseSelect').innerHTML = '';

                // AJAX request to fetch courses for the selected student
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {

                        $("#courseSelect").append(xhr.responseText);



                    }

                }


                xhr.open("GET", "getcourse.php?student=" + studentId, true);
                xhr.send();
            }

            //Print function for marks
            function printMarks() {
                window.print();
            }



    </script>
    <br><br>
    <button onclick="printMarks()" class="print-button">Print Marks</button>
</body>

</html>