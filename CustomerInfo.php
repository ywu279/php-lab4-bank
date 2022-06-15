<?php
    session_start(); //retrieve PHP session!
//see if a previously saved variable $termCheck in the session data store is set or not
//if resuming session fails （由于用户跳过Disclaimer直接通过URL进入该页或session expired的原因）, you should redirect the request to the disclaimer page.
    if(!isset($_SESSION["termCheck"]))
    {
        header("Location: Disclaimer.php");
        exit();
    }

    extract($_POST);

    $contactMethod_1 = "";
    $contactMethod_2 = "";
    $contactTime_1 = "";
    $contactTime_2 = "";
    $contactTime_3 = "";

    $nameErr = "";
    $postcodeErr = "";
    $phoneErr = "";
    $emailErr = "";
    $contactErr = "";
    $timeErr = "";

    if(isset($next)) //if the page is requested due to the form submission, NOT the first time request
    {
        $nameErr = ValidateName($name);
        $postcodeErr = ValidatePostalCode($postcode);
        $phoneErr = ValidatePhone($phone);
        $emailErr = ValidateEmail($email);
        $contactErr = ValidateContact($contact);
        $timeErr = ValidateTime($contact, $time);

        if(!$nameErr && !$postcodeErr && !$phoneErr && !$emailErr && !$contactErr && !$timeErr)
        {
            //store data in session
            $_SESSION["name"] = $name;
            $_SESSION["postcode"] = $postcode;
            $_SESSION["phone"] = $phone;
            $_SESSION["email"] = $email;
            $_SESSION["contact"] = $contact;
            $_SESSION["time"] = $time;

            header("Location: DepositCalculator.php");
        }
    }
    else
    {
        //if the data has been stored in the session, display/pre-check the data on the page when the user enters this page again
        $name = $_SESSION["name"] ?? "";
        $postcode = $_SESSION["postcode"] ?? "";
        $phone = $_SESSION["phone"] ?? "";
        $email = $_SESSION["email"] ?? "";
        $contact = $_SESSION["contact"] ?? "phone";
        if(isset($_SESSION["contact"]))
        {
            $contact = $_SESSION["contact"];
            if($contact == "phone")
            {
                $contactMethod_1 = "checked";
            }
            elseif($contact == "email")
            {
                $contactMethod_2 = "checked";
            }
//            $contactMethod_1 = ($contact == "phone") ? "checked" : "";
//            $contactMethod_2 = ($contact == "email") ? "checked" : "";
        }
        if(isset($_SESSION["time"]))
        {
            $time = $_SESSION["time"];
            if(in_array("morning", (array)$time))
            {
                $contactTime_1 = "checked";
            }
            if(in_array("afternoon", (array)$time))
            {
                $contactTime_2 = "checked";
            }
            if(in_array("evening", (array)$time))
            {
                $contactTime_3 = "checked";
            }
//            $contactTime_1 = (in_array("morning", (array)$time)) ? "checked" : "";
//            $contactTime_2 = (in_array("afternoon", (array)$time)) ? "checked" : "";
//            $contactTime_3 = (in_array("evening", (array)$time)) ? "checked" : "";
        }
    }

    include("./Common/Header.php");

    print <<<HTML
        <div class="container">
            <h1>Customer Information</h1>
            <hr>
            <form action="CustomerInfo.php" method="post">
                <div class="row form-group form-inline">
                    <label for="name" class="col-md-2">Name: </label>
                    <input type="text" id="name" name="name" class="form-control col-md-3" value="$name">
                    <span class="errorMsg">$nameErr</span>
                </div>
                <div class="row form-group form-inline">
                    <label for="postcode" class="col-md-2">Postal Code: </label>
                    <input type="text" id="postcode" name="postcode" class="form-control col-md-3" value="$postcode">
                    <span class="errorMsg">$postcodeErr</span>
                </div>
                <div class="row form-group form-inline">
                    <label for="phone" class="col-md-2">Phone Number: <br>(nnn-nnn-nnnn)</label>
                    <input type="text" id="phone" name="phone" class="form-control col-md-3" value="$phone">
                    <span class="errorMsg">$phoneErr</span>
                </div>
                <div class="row form-group form-inline">
                    <label for="email" class="col-md-2">Email Address: </label>
                    <input type="text" id="email" name="email" class="form-control col-md-3" value="$email">
                    <span class="errorMsg">$emailErr</span>
                </div>
                <hr>
                <div class="row form-group form-inline">
                    <p class="col-md-2">Preferred contact Method: </p>
                    <div class="form-check col-md-1">
                        <input type="radio" id="radio1" name="contact" value="phone" checked="checked" class="form-check-input" $contactMethod_1>
                        <label for="radio1" class="form-check-label">Phone</label>
                    </div>
                    <div class="form-check col-md-1">
                        <input type="radio" id="radio2" name="contact" value="email" class="form-check-input" $contactMethod_2>
                        <label for="radio2" class="form-check-label">Email</label>
                    </div>
                    <span class="errorMsg">$contactErr</span>
                </div>
                <div class="form-group form-inline">
                    <p>If phone is selected, when can we contact you? (check all applicable)</p>
                    <div class="form-check checkbox-inline">
                        <input type="checkbox" id="checkbox1" name="time[]" value="morning" class="form-check-input" $contactTime_1>
                        <label for="checkbox1" class="form-check-label">Morning</label>
                    </div>
                    <div class="form-check checkbox-inline">
                        <input type="checkbox" id="checkbox2" name="time[]" value="afternoon" class="form-check-input" $contactTime_2>
                        <label for="checkbox2" class="form-check-label">Afternoon</label>
                    </div>
                    <div class="form-check checkbox-inline">
                        <input type="checkbox" id="checkbox3" name="time[]" value="evening" class="form-check-input" $contactTime_3>
                        <label for="checkbox3" class="form-check-label">Evening</label>
                    </div>
                    <span class="errorMsg">$timeErr</span>
                </div>
                <button type="submit" name="next" class="btn btn-primary">Next ></button>
            </form>
        </div>
    HTML;

    function ValidateName($name): string
    {
        if(!trim($name))
        {
            return "Name can not be blank";
        }
        else
        {
            return "";
        }
    }

    function ValidatePostalCode($postalCode): string
    {
        $regex = "/[a-z][0-9][a-z]\s*[0-9][a-z][0-9]/i";
        if(!trim($postalCode))
        {
            return "Postal code can not be blank";
        }
        elseif(!preg_match($regex, $postalCode))
        {
            return "Incorrect postal code";
        }
        else
        {
            return "";
        }
    }

    function ValidatePhone($phone): string
    {
        $regex = "/^([2-9]\d{2})-([2-9]{3})-(\d{4})$/";
        if(!trim($phone))
        {
            return "Phone number can not be blank";
        }
        elseif(!preg_match($regex, $phone))
        {
            return "Incorrect phone number";
        }
        else
        {
            return "";
        }
    }

    function ValidateEmail($email): string
    {
        $regex = "/\b[a-z0-9._%+-]+@(([a-z0-9-]+)\.)+[a-z]{2,4}\b/i";
        if(!trim($email))
        {
            return "Email can not be blank";
        }
        elseif(!preg_match($regex, $email))
        {
            return "Incorrect email";
        }
        else
        {
            return "";
        }
    }

    function ValidateContact($contact): string
    {
        if(!$contact)
        {
            return "Preferred contact method can not be blank";
        }
        else
        {
            return "";
        }
    }

    function ValidateTime($contact, &$time): string //using '&' to pass array by reference
    {
        if($contact == "phone" && !isset($time))
        {
            return "When preferred contact method is phone, you have to select one or more contact times";
        }
        else
        {
            return "";
        }
    }


    include("./Common/Footer.php");
?>
