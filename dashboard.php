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
        <title> My Calendar </title>
        <link rel="stylesheet" href="search.css">
        <?php include("includes/templates/header.php") ?>
        <?php include("includes/js/makeics.php") ?>
        <div id="session-email" hidden="true"><?php echo $_SESSION["session_email"]?></div>
        <div class = "bg">
        <div class="search">
            <input id="search-bar" type="text" placeholder="Search Course" class="searchCourse"/>
            <br>
            <div class="dropdown-content">
                <spam>No course found.</spam>
            </div>
        </div>
                
        <button onclick="addToICS()">Add to Calendar</button>
        <button onclick="downloadCal()">Download Calendar</button>
        </div>
    </body>
</html>
