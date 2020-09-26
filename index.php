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
        <link rel="stylesheet" href="/includes/styles/css/styles.css">
        <!-- header start -->
        <?php include("includes/templates/header.php") ?>
        <div class="content">
            
        </div>
        <script src="/includes/js/welcome.js"></script>
        <?php include("includes/templates/footer.php") ?>
    </body>
    <!-- footer ends -->
</html>
