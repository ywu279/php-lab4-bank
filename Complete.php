<?php
    error_reporting(E_ALL ^ E_NOTICE); //specify All errors and warnings are displayed
    session_start();

    if (!isset($_SESSION["termCheck"])) {
        header("Location:Disclaimer.php");
        exit();
    }
    elseif(!isset($_SESSION["name"]) && !isset($_SESSION["postcode"]) && !isset($_SESSION["phone"]) && !isset($_SESSION["email"]) && !isset($_SESSION["contact"]) && !isset($_SESSION["time"]))
    {
        header("Location: CustomerInfo.php");
        exit();
    }
    elseif (!isset($_SESSION["amount"]) && !isset($_SESSION["rate"]) && !isset($_SESSION["year"]))
    {
        header("Location: DepositCalculator.php");
        exit();
    }

    //Before you use any session, you always have to check if that session has value or not!
    $name = $_SESSION["name"] ?? "";
    $phone = $_SESSION["phone"] ?? "";
    $email = $_SESSION["email"] ?? "";
    $contact = $_SESSION["contact"] ?? "";
    $time = $_SESSION["time"] ?? array();
    $timeMsg = implode(" or ", $time);

    include("./Common/Header.php");


    echo ("<div class='container'>
                <h1>Thank you, <span style='font-weight: bold;'>$name</span>, for using our deposit calculation tool.</h1>");
                if($contact == "phone")
                    {
                        echo "<p>Our customer service department will call you tomorrow $timeMsg at $phone.</p>";
                    }
                    elseif($contact == "email")
                    {
                        echo "<p>An email about the details of our GIC has been sent to $email.</p><br>";
                    }
    echo "</div>";


    include("./Common/Footer.php");

    session_destroy( );
?>
