<?php
session_start();
if (isset($_SESSION["loggedin"]) && isset($_SESSION["user_id"]) && $_SESSION["loggedin"] == true)
{
    header("location: home.php");
}
?>