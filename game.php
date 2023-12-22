<?php
$logTime = microtime(true);
/*
* Filename      : game.php
* Created       : 26-11-2023
* Description   : PHP page for enabling SCUFF to work
* Programmer    : Mart Velema
*/
include 'components/sql-login.php';
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $action = filter_input(INPUT_POST, 'give');
    if(isset($action))
    {
        setcookie($action, 1, time() + (60 * 60 * 24 * 365));
        $action = '';
    };
    $action = filter_input(INPUT_POST, 'take');
    if(isset($action))
    {
        setcookie($action, 1, time() - (60 * 60 * 24 * 365 + 10));
        $action = '';
    };
    $_SERVER['REQUEST_METHOD'] = NULL;
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - SCUFF</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        // if(isset($_GET['nonav']))   //check if the nonav variable exists inside of the URL
        // {
        //     if($_GET['nonav'] == 0) //check if hte nonav variable is 0, if so, add the navbar
        //     {
        //         include "components/header.php";
        //     };
        // }
        // else
        // {
        //     $_GET['nonav'] = 0;
        //     include "components/header.php";
        // };
    ?>
    <main style="padding-top: 0px; background-image: none;">
        <?php
            var_dump($_FILES);
            include "components/SCUFF.php";
            $logTime = (microtime(true) - $logTime);
            // echo '' . $logTime . ' &micro;s';
        ?>
    </main>
</body>
</html>