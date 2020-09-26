<?php
session_start();
if (isset($_SESSION["loggedin"]) && isset($_SESSION["user_id"]) && $_SESSION["loggedin"] == true)
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
        <!-- header start -->
        <div class="content">
            <div class="getstartedwrapper">
                <div class="welcome-text">WELCOME TO EASY CALENDAR!!</div>
                <div class="get-started">Let's get started</div>
                <div id="studbutton" class="rolebutton active">I'm a Student</div>
                <div id="profbutton" class="rolebutton">I'm a Professor/TA</div>
                <div id="signup" class="signupbut"> Sign Up </div>
                <div id="loginbut" class="loginbut"> Log in </div>
            </div>
            <div class="grayout-container">
                <div class="form-container">
                    <div class="title">Sign up</div>
                </div>
            </div>
        </div>
        <script src="/includes/js/welcome.js"></script>
        <?php include("includes/templates/footer.php") ?>
    </body>
    <!-- footer ends -->
</html>
