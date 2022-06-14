<?php
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

    extract($_POST);

    $amountErr = "";
    $rateErr = "";
    $yearErr = "";

    if (isset($complete))
    {
        $errors = array();
        $errors[] = $amountErr = ValidatePrincipal($amount);
        $errors[] = $rateErr = ValidateRate($rate);
        $errors[] = $yearErr = ValidateYears($year);

        if(count($errors) == 0)
        {
            $_SESSION["amount"] = $amount;
            $_SESSION["rate"] = $rate;
            $_SESSION["year"] = $year;

            header("Location: Complete.php");
        }
    }
    elseif (isset($previous))
    {
        $_SESSION["amount"] = $amount ?? "";
        $_SESSION["rate"] = $rate ?? "";
        $_SESSION["year"] = $year ?? "";

        header("Location: CustomerInfo.php");
    }
    elseif (isset($calculate))
    {

    }

    //if the data has been stored in the session, display the data on the page when the user enters this page
    $amountValue = $amount ?? "";
    $rateValue = $rate ?? "";
    $yearValue = $year ?? "Select...";

    include("./Common/Header.php");

    print <<<EOS
        <div class="container">
            <p style="margin-top: 10px;">Enter principal amount, interest rate and select number of years to deposit</p>
            <form action="DepositCalculator.php" method="post">
                <div class="row form-group form-inline">
                    <label for="amount" class="col-md-2">Principal Amount: </label>
                    <input type="text" id="amount" name="amount" class="form-control col-md-3" value="$amountValue">
                    <span class="errorMsg">$amountErr</span>
                </div>
                <div class="row form-group form-inline">
                    <label for="rate" class="col-md-2">Interest Rate (%): </label>
                    <input type="text" id="rate" name="rate" class="form-control col-md-3" value="$rateValue">
                    <span class="errorMsg">$rateErr</span>
                </div>
                <div class="row form-group form-inline">
                    <label for="year" class="col-md-2">Years to Deposit: </label>
                    <select id="year" name="year" class="form-control col-md-3" value="$yearValue">
                        <option value="-1">Select...</option>
        EOS;

                        for ($y = 1; $y <= 20; $y++)
                        {
                        echo "<option value='$y'", ($yearValue == $y) ? "selected>" : ">", $y, "</option>";
                        }

        print <<<EOS
                    </select>
                    <span class="errorMsg">$yearErr</span>
                </div>
                <button type="submit" name="previous" class="btn btn-primary">< Previous</button>
                <button type="submit" name="calculate" class="btn btn-primary">Calculate</button>
                <button type="submit" name="complete" class="btn btn-primary">Complete ></button>
            </form>
        </div>
    EOS;

                    function ValidatePrincipal($amount): string
                    {
                        if(!trim($amount)) //empty string is translated to logical false
                        {
                            return "Principal amount can not be blank";
                        }
                        elseif(!is_numeric($amount))
                        {
                            return "Principal amount must be numeric";
                        }
                        elseif($amount <= 0)
                        {
                            return "Principal amount must be greater than 0";
                        }
                        else
                        {
                            return "";
                        }
                    }

    function ValidateRate($amount): string
    {
        if(!trim($amount))
        {
            return "Interest rate can not be blank";
        }
        elseif(!is_numeric($amount))
        {
            return "Interest rate must be numeric";
        }
        elseif($amount < 0)
        {
            return "Interest rate must be non-negative";
        }
        else
        {
            return "";
        }
    }

    function ValidateYears($years): string
    {
        if(!trim($years))
        {
            return "Number of years to deposit can not be blank";
        }
        elseif(!is_numeric($years))
        {
            return "Number of years to deposit must be numeric";
        }
        elseif($years < 1 || $years > 20)
        {
            return "Number of years to deposit must be a numeric between 1 and 20";
        }
        else
        {
            return "";
        }
    }

    include("./Common/Footer.php");
?>

