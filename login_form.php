<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

session_start();
 include 'config.php';
 
if (isset($_POST['submit'])) {


    $email = $_POST['email'];
    $pass = md5($_POST['password']);

     $query = "select * from user_form where email='$email' && password='$pass' ";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            
            header("location:admin_page.php");
            
            exit();
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            
            header("location:user_page.php");
            exit();
        }
        

    } else {
        $error[] = "Incorrect Email or Password";
    }

}
;
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link rel="stylesheet" href="style.css">
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

    <div class="form-conatiner">

        <form action="login_form.php" method="post" id="marksForm">
            <h3>Login Now</h3>

            <div id="error-message" class="error-message"></div>

            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
                ;
            }
            ;
            ?>


            <input type="email" name="email"  placeholder="Enter Your email">
            <input type="password" name="password"  placeholder="Enter Your password">


            <input type="submit" name="submit" value="Login Now" class="form-btn">
            <p>Don't Have An Account?? <a href="regsiter_form.php">Register Now</a></p>
        </form>
    </div>

</body>

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
                if ($('[name="email"]').val() === "" || $('[name="password"]').val() === "") 
                {
                    $('#error-message').text("Please fill in all  fields.");
                    $('[name="email"]').addClass('error-input');
                    $('[name="password"]').addClass('error-input');
                    
                    event.preventDefault(); // Prevent form submission
                } 
                
            })
            });



</script>

</html>