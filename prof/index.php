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
        <!-- header start -->

        <script src="/js/test.js"></script>
    </body>
    <!-- footer ends -->
</html>