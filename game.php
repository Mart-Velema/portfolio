<?php
/*
* Filename      : game.php
* Created       : 26-11-2023
* Description   : PHP frontpage for games
* Programmer    : Mart Velema
*/
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
            if($_GET['nonav'] == 0) //check if hte nonav variable is 0, if so, add the navbar
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
            include "components/SCUFF.php";
        ?>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>