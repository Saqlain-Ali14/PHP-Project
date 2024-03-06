<?php

@include 'config.php';
if(isset($_POST['submit']))
{

$name=$_POST['name'];
$email=$_POST['email'];
$pass= md5($_POST['password']);
$cpass= md5($_POST['cpassword']);
$user_type=($_POST['user_type']);
echo $query ="select * from user_form where email='$email' && password='$pass' ";

$result=mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0)
{
    $error[]='User Already Exist!' ;
    
}
else
{
    if($pass != $cpass)
    {
        $error[]='Password Does"t Match!' ;
    }
    else
    {
        echo $query="insert into user_form (name,email,password,user_type) values ('$name','$email','$pass','$user_type')";
        mysqli_query($conn,$query);
       header("location:login_form.php");
    }
}

};
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regsiter Form</title>
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

<form action="regsiter_form.php" method="post" id="marksForm">
    <h3>Regsiter Now</h3>
    <div id="error-message" class="error-message"></div>

    <?php
    if(isset($error))
    {
        foreach($error as $error)
        {
            echo '<span class="error-msg">'.$error.'</span>';
        };
    };
    ?>
    <input type="text" name="name" placeholder="Enter Your Name">
    <input type="email" name="email"  placeholder="Enter Your email">
    <input type="password" name="password"  placeholder="Enter Your password">
    <input type="password" name="cpassword"  placeholder="Confirm Your password">
    <select name="user_type" >
        <!-- <option value="user">Student</option> -->
        <option value="admin">Admin</option>
        <!-- <option value="admin">Teacher</option> -->

    </select>
    <input type="submit" name="submit" value="Register Now" class="form-btn">
    <p>Already Have An Account?? <a href="login_form.php">Login Now</a></p>
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
                if ($('[name="name"]').val() === "" || $('[name="email"]').val() === "" || $('[name="password"]').val() === "" || $('[name="cpassword"]').val() === "") 
                {
                    $('#error-message').text("Please fill in all  fields.");
                    $('[name="name"]').addClass('error-input');
                    $('[name="email"]').addClass('error-input');
                    $('[name="password"]').addClass('error-input');
                    $('[name="cpassword"]').addClass('error-input');
                    
                    event.preventDefault(); // Prevent form submission
                } 
                
            })
            });



</script>

</html>