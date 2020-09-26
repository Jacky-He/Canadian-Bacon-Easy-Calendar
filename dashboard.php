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

        <div id="session-email" hidden="true"><?php echo $_SESSION["session_email"]?></div>

        <?php include("includes/js/makeics.php") ?>
        <script src="includes/js/search_course.js"></script>
        <div class = "bg">
        <div class="search">
            <input id="search-bar" type="text" placeholder="Search Course" onkeydown="processKeyDown()" onclick="processClick()" class="searchCourse"/>
            <br>
            <div class="dropdown-content">
                <p id="suggest0">No course found.</p>
                <p id="suggest1">C1</p>
                <p id="suggest2">C2</p>
                <!-- <p id="suggest3">C3</p>
                <p id="suggest4">C4</p> -->
            </div>
        </div>
        <div class="buttons">     
        <button onclick="addToICS()">Add to Calendar</button>
        <button onclick="downloadCal()">Download Calendar</button>
        <button onclick="removeFromICS()">Remove from Calendar</button>
        </div>
        <div class="courseList">
            <p class = "titleP"> Your Courses </p>
            <ul id="course-list">
            <ul>
        </div>
        <script>
            updateList();
        </script>
        </div>
    </body>
</html>
