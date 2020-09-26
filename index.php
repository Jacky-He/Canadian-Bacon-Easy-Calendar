<?php
session_start();
if (isset($_SESSION["loggedin"]) && isset($_SESSION["session_email"]) && $_SESSION["loggedin"] == true)
{
    header("location: home.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Home Page </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <meta name="description" content="">
        <link rel="stylesheet" href="/includes/styles/css/welcome.css">
        <?php include("includes/templates/header.php") ?>
        <!-- header start -->
        <div class="content">
            <div class="getstartedwrapper">
                <div class="welcome-text">WELCOME TO EASY CALENDAR!!</div>
                <div class="product-description">
                    
                <p>
                    Easy Calendar makes it super easy to add classes to your calendar. 
                </p> 
                <p>
                    In just three steps, you can set up your calendar for the new semester.
                </p>
                <p>
                    Just search for your classes, add them to your calendar, and download and import the ICS file to 
                    any calendar app of your choice. 
                </p>
                <p>    
                    Then, if you want to go to a lecture or office hours,
                     just click on the zoom link in the description of the event. 

                </p>
                </div>
                <div class="get-started">Let's get started</div>
                <div id="studbutton" class="rolebutton active">I'm a Student</div>
                <div id="profbutton" class="rolebutton">I'm a Professor/TA</div>
                <div id="signup" class="signupbut"> Sign Up </div>
                <div id="login" class="loginbut"> Log in </div>
            </div>
            <div id="grayout-container" class="grayout-container">
                <div class="form-container">
                    <div id="cancel" class="cancel"><img src="/includes/images/cancel.png" alt="cancel button" class="cancel-img"/></div>
                    <div id="form-title" class="title">Sign up</div>
                    <div class="subtitle">Email</div>
                    <input id="username" type="text" name="username" class="input" value="">
                    <div class="subtitle">Password</div>
                    <input id="password" type="password" name="password" class="input">
                    <div id="submit" class="submit">Confirm</div>
                </div>
            </div>
        </div>
        <script src="/includes/js/welcome.js"></script>
        <?php include("includes/templates/footer.php") ?>
    </body>
    <!-- footer ends -->
</html>
