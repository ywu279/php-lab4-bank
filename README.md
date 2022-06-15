# php-lab4-bank
implement a 5-page application consisting of **Index.php**, **Disclaimer.php**, **CustomerInfo.php**, **DepositCalculator.php** and **Complete.php**.

<*CST8257 Web Applications Development - lab 4*>

## Built with
- [PHP](https://www.php.net/) 7.4.29 
- [Bootstrap v3.3.6](https://cdn.jsdelivr.net/npm/bootstrap@3.3.6/dist/css/bootstrap.min.css)

## Get started
1. Download PhpStorm
2. Configure PHP interpreter level to 7.4

   <img src="https://user-images.githubusercontent.com/58931129/173491958-0dda08b9-3935-4a95-885c-c446998f26cd.png" width="500px">

## Objectives
1. Form processing - **GET** and **POST**
2. Read form data - in the receiving PHP page, the values of the input data on the web form can be extracted using `extract($_POST)` - which automatically creates variables from the array, with the key as name and the value as variable content.
3. Form validation - submit form to the same page itself using `$_SERVER[PHP_SELF]`
4. Form validation - `isset()`, regular expression
5. PHP function
6. PHP session management
    ```
    session_start();
    
    if(!isset($_SESSION["termCheck"]))
    {
        header("Location: Disclaimer.php");
        exit();
    }
    
    session_destroy( );
    ```
7. PHP common components(a.k.a. masterpage or \_layout) using `include()` or `require()`
    ```
    include("./Common/Header.php");
    
    include("./Common/Footer.php");
    ```
    
## Features
### 1. Home page
<img src="https://user-images.githubusercontent.com/58931129/173864978-4fc9b5fd-6f48-4543-a0bf-7bed30cfd9be.png" width="600px">

### 2. Terms and Conditions
<img src="https://user-images.githubusercontent.com/58931129/173865191-66ad4feb-64ec-477f-bf7d-fc248d1478ce.png" width="600px">

### 3. Customer Information
<img src="https://user-images.githubusercontent.com/58931129/173865696-c16b3a3e-73f6-4f38-a9a5-a57037146d5c.png" width="600px">

### 4. Calculator
<img src="https://user-images.githubusercontent.com/58931129/173865862-309eb531-75fb-49ae-8d53-d619bf49f310.png" width="600px">

### 5. Complete
<img src="https://user-images.githubusercontent.com/58931129/173865997-eed92532-fe40-4239-8322-c7e3a0aa655c.png" width="600px">

