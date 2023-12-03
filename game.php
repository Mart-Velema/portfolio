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
        include "components/header.php";
    ?>
    <main style="padding-top: 0px;">
        <?php
            $level = $_GET['level'];
            include "components/SCUFF.php";
        ?>
    </main>
</body>
</html>