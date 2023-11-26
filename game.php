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
    <title>Portfolio Mart - Game</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <main>
        <div class='main-game'>
            <?php
                $level = $_GET['level'];
                include "components/game-renderer.php";
            ?>
        </div>
    </main>
</body>
</html>