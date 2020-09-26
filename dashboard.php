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
        <link rel="stylesheet" href="dashboard.css">
        <?php include("includes/templates/header.php") ?>
        <script src="includes/js/backgroundEvent.js"></script>
    </head>
    <body onclick="bgClick(event)">
        <div class="nav">
            <ul class="nav-list">
            <a href="home.php"><li class="nav1">Home</li></a>
            <a href="logout.php"><li class="nav2">Log out</li></a>
            <a href="contact.php"><li class="nav3">Contact</li></a>
            <a href="dashboard.php"><li class="nav4">Dashboard</li></a>
            </ul> 
        </div>
        <div id="session-email" hidden="true"><?php echo $_SESSION["session_email"]?></div>

        <?php include("includes/js/makeics.php") ?>
        <script src="includes/js/search_course.js"></script>
        <div class = "bg">
        <div class="search">
            <div class="searchWithin">
                <input id="search-bar" type="text" placeholder="Search Course"
                onkeydown="searchKeyDown()" onclick="searchClick()" class="searchCourse"/>
                <div id="dropdown" class="dropdown-content">
                    <p id="suggest0" onclick="autofill(0)">No course found.</p>
                    <p id="suggest1" onclick="autofill(1)">C1</p>
                    <p id="suggest2" onclick="autofill(2)">C2</p>
                    <!-- <p id="suggest3">C3</p>
                    <p id="suggest4">C4</p> -->
                </div>
            </div>
            <button class="remove-button" onclick="removeFromICS()">Remove Course</button>
            <button class="add-button" onclick="addToICS()">Add Course</button>
        </div>
        <div class="buttons">
        <button class="download-button" onclick="downloadCal()">Download Calendar</button>
        </div>
        <div class="courseList">
            <p class = "titleP"> Your Courses </p>
            <ul id="course-list">
            <ul>
        </div>
        <script>
            updateList();
        </script>
    </body>
    <script src="includes/js/clickProcessing.js"></script>
</html>
