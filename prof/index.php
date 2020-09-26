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
        <div id="session-email"><?php echo $_SESSION["session_email"]?></div>
        <div class="content">
            <div class="topsec">Welcome</div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-7"></div>
                    <div class="col-lg-3">
                        <input type="text" id="search-bar" placeholder="Search courses">
                        <div id="drop-down" class="drop-down">
                            <div class="drop-course-item">
                                <div class="add-course"><img src="/includes/images/add.png" alt="add icon" class="add-img"/>
                                <div class="course-id" hidden="true">asdfasd</div>
                                </div>
                                <div class="course-code">15-122</div>
                                <div class="course-name">Principles of Imperative Computing</div>
                                <div class="lecture">lecture: 2</div>
                                <div class="section">section: P</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="/prof/prof.js"></script>
    </body>
    <!-- footer ends -->
</html>