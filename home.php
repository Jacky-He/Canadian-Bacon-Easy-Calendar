<?php 
session_start();
if (isset($_GET["session_email"]) && $_GET["session_email"] != "")
{
    $email = $_GET["session_email"];
    $_SESSION["session_email"] = $email;
    $_SESSION["loggedin"] = true;
}

if (!isset($_SESSION["loggedin"]) || !isset($_SESSION["session_email"]) || $_SESSION["loggedin"] == false)
{
    header("location: index.php");
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
        <?php include("includes/templates/header.php") ?>
    </head>
    <body>
        <div class="nav">
            <ul class="nav-list">
            <a href="home.php"><li class="nav1">Home</li></a>
            <a href="logout.php"><li class="nav2">Log out</li></a>
            <a href="contact.php"><li class="nav3">Contact</li></a>
            <a href="dashboard.php"><li class="nav4">Dashboard</li></a>
            </ul> 
        </div>
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
                
            </div>
        <script src="/js/test.js"></script>
    </body>
    <!-- footer ends -->
</html>