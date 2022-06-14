<?php
    session_start();
    extract($_POST);
    $termErr = "";

    if(isset($start)) //check if the page is requested due to the form submission, NOT the first time request
    {
        if(isset($termCheck))
        {
            $_SESSION["termCheck"] = $termCheck;
            header("Location: CustomerInfo.php");
            exit();
        }
        else
        {
            $termErr = "You must agree the terms and conditions!";
        }
    }
//    else {
//        if(isset($_SESSION["term"]))
//        {
//            $term = $_SESSION["term"];
//        }
//    }

    include("./Common/Header.php");
?>

<div class="container">
    <h1>Term and Conditions</h1>
    <table class="table table-bordered">
        <tr>
            <td>
                <p>I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and made available on the Bank's website</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>I agree that the bank before opening any deposit account, will carry out a due diligence as required under Know Your Customer guidelines of the bank. I would be required to submit necessary documents or proofs, such as identity, address, photograph and any such information, I agree to submit the above documents again at periodic intervals, as may be required by the Bank.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>I agree that the Bank can at its sole discretion, amend any of the services/facilities given in my account either wholly or partially at any time by giving me at least 30 days notice and/or provide an option to me to switch to other services/facilities.</p>
            </td>
        </tr>
    </table>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <div class="text-danger">
                <?php echo $termErr ?>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" id="termCheck" name="termCheck" class="form-check-input">
                <label for="termCheck" class="form-check-label">I have read and agree with the terms and conditions</label>
            </div>
        </div>
        <button type="submit" name="start" class="btn btn-primary">Start</button>
    </form>
</div>

<?php include("./Common/Footer.php"); ?>