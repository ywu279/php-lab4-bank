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

    extract($_POST);

    $amountErr = "";
    $rateErr = "";
    $yearErr = "";

    $valid = false;

    if (isset($complete))
    {
        $amountErr = ValidatePrincipal($amount);
        $rateErr = ValidateRate($rate);
        $yearErr = ValidateYears($year);

        if(!$amountErr && !$rateErr && !$yearErr)
        {
            $_SESSION["amount"] = $amount;
            $_SESSION["rate"] = $rate;
            $_SESSION["year"] = $year;

            header("Location: Complete.php");
            exit();
        }
    }
    elseif (isset($previous))
    {
        //preserve the data input so users don't need to enter again
        $_SESSION["amount"] = $amount ?? "";
        $_SESSION["rate"] = $rate ?? "";
        $_SESSION["year"] = $year ?? "";

        header("Location: CustomerInfo.php");
    }
    elseif (isset($calculate))
    {
        $amountErr = ValidatePrincipal($amount);
        $rateErr = ValidateRate($rate);
        $yearErr = ValidateYears($year);

        if(!$amountErr && !$rateErr && !$yearErr)
        {
            $_SESSION["amount"] = $amount;
            $_SESSION["rate"] = $rate;
            $_SESSION["year"] = $year;

            $valid = true; //set $valid to be true to display the calculation table.
        }
    }
    else
    {
        //if the data has been stored in the session, display the data on the page when the user enters this page again
        $amount = $_SESSION["amount"] ?? "";
        $rate = $_SESSION["rate"] ?? "";
        $year = $_SESSION["year"] ?? "-1";
    }

    include("./Common/Header.php");

    print <<<EOS
        <div class="container">
            <p style="margin-top: 10px;">Enter principal amount, interest rate and select number of years to deposit</p>
            <form action="DepositCalculator.php" method="post">
                <div class="row form-group form-inline">
                    <label for="amount" class="col-md-2">Principal Amount: </label>
                    <input type="text" id="amount" name="amount" class="form-control col-md-3" value="$amount">
                    <span class="errorMsg">$amountErr</span>
                </div>
                <div class="row form-group form-inline">
                    <label for="rate" class="col-md-2">Interest Rate (%): </label>
                    <input type="text" id="rate" name="rate" class="form-control col-md-3" value="$rate">
                    <span class="errorMsg">$rateErr</span>
                </div>
                <div class="row form-group form-inline">
                    <label for="year" class="col-md-2">Years to Deposit: </label>
                    <select id="year" name="year" class="form-control col-md-3">
                        <option value="-1">Select...</option>
        EOS;

                        for ($y = 1; $y <= 20; $y++)
                        {
                        echo "<option value='$y'", ($year == $y) ? "selected>" : ">", $y, "</option>";
                        }

        print <<<EOS
                    </select>
                    <span class="errorMsg">$yearErr</span>
                </div>
                <button type="submit" name="previous" class="btn btn-primary">< Previous</button>
                <button type="submit" name="calculate" class="btn btn-primary">Calculate</button>
                <button type="submit" name="complete" class="btn btn-primary">Complete ></button>
            </form>       
    EOS;


    if($valid)
    {
        print <<<EOS
            <br>
            <p>The following is the result of the calculation:</p>
            <table class='table table-striped'>
                    <tr>
                        <th scope='col'>Year</th>
                        <th scope='col'>Principal at Year Start</th>
                        <th scope='col'>Interest for the Year</th>
                    </tr>
            EOS;

        for($i = 1; $i <= $year; $i++)
        {
            $interest = $amount * ($rate/100);

            print"<tr><td>$i</td><td>$";
            printf("%.2f", $amount);
            print"</td><td>$";
            printf("%.2f", $interest);
            print"</td></tr>";

            $amount = $amount + $interest;

        }
        echo "</table></div>";
    }



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

    function ValidateRate($rate): string
    {
        if(trim($rate) == "")
        {
            return "Interest rate can not be blank";
        }
        elseif(!is_numeric($rate))
        {
            return "Interest rate must be numeric";
        }
        elseif($rate < 0)
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

