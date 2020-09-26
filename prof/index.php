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
    header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Prof Page </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <meta name="description" content="">
        <script src="/vendors/ics.deps.min.js"></script>
        <script src="/vendors/ics.min.js"></script>
        <script src="/vendors/ics.js"></script>
        <script src="/js/functions.js"></script>
        <link rel="stylesheet" href="/includes/styles/css/styles.css">
        <link rel="stylesheet" href="/prof/prof.css">
        <link rel="stylesheet" href="/includes/vendors/bootstrap/bootstrap.min.css">
        <script src="/includes/vendors/bootstrap/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="session-email" hidden="true"><?php echo $_SESSION["session_email"]?></div>
        <div class="content">
            <div class="topsec">
                <div class="hellotext">
                Hello!
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="existing-courses">Your Courses</div>
                        <div id="no-course" class="no-course active">You currently have no courses</div>
                        <div id="courses-container"class="courses-container">
                            <!-- <a href="/prof/course/course.php?id=stuff" style="text-decoration: none; color: black">
                                <div class="course-id" hidden="true">asdfasd</div>
                                <div class="underline"></div>
                                <span class="course-code">15-122</span>
                                <span class="course-name" style="margin-left: 10px;">Principles of Imperative computing</span>
                                <span class="lecture" style="margin-left: 10px;"><span style="font-family:'montserratbold'">lecture: </span>2</span>
                                <span class="section" style="margin-left: 10px;"><span style="font-family:'montserratbold'">section: </span>P</span>
                            </a> -->
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" id="search-bar" placeholder="Search courses">
                        <div id="drop-down" class="drop-down">
                            <!-- <div class="drop-course-item">
                                <div class="add-course"><img src="/includes/images/add.png" alt="add icon" class="add-img"/>
                                <div class="course-id" hidden="true">asdfasd</div>
                                </div>
                                <div class="course-code">15-122</div>
                                <div class="course-name">Principles of Imperative Computing</div>
                                <div class="lecture">lecture: 2</div>
                                <div class="section">section: P</div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/prof/prof.js"></script>
    </body>
    <!-- footer ends -->
</html>