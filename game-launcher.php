<?php
$logTime = microtime(true);
/*
* Filename      : game-launcher.php
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
        if(isset($_GET['nonav']))   //check if the nonav variable exists inside of the URL
        {
            if($_GET['nonav'] == 0) //check if the nonav variable is 0, if so, add the navbar
            {
                include "components/header.php";
            };
        }
        else
        {
            $_GET['nonav'] = 0;
            include "components/header.php";
        };
    ?>
    <main style="padding-top: 0px; background-image: none;">
        <?php
            if($_GET['scene'] == 'dev')
            {
                echo '<div class="dev">';
                $portraits = glob('img/assets/' . $_GET['page'] . '/*.png');     //make array out of all the images inside of the directory
                foreach($portraits as $portrait)
                {
                    $portraitCode = str_replace("img/assets/" . $_GET['page'] . "/", "", $portrait);   //strip out directory out of portrait name
                    $portraitCode = str_replace(".png", "", $portraitCode);                                 //strip out .png out of portrait name
                    echo
                    '<div class="image">' . 
                        '<img src="'. $portrait . '" alt="' . $portrait . '">' . 
                        '<p>' . $portrait . '<br></p>' .
                        '<p>' . $portraitCode . '<br><br></p>' .
                    '</div>';
                };
                echo '</div>';  
            }
            else
            {
                include "components/SCUFF.php";
            };
            if($_GET['nonav'] == 1)
            {
                echo
                '<div class="game-nonav">' .
                    '<a href="games.php">Go back</a>' .
                '</div>';
            };
            $logTime = (microtime(true) - $logTime);
            // echo '' . $logTime . ' &micro;s';
        ?>
    </main>
</body>
</html>