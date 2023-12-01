<?php
/*
* Filename      : game.php
* Created       : 22-11-2023
* Description   : homepage for games
* Programmer    : Mart Velema
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - Games</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        if(empty($_GET['nonav']))    //check if the $nonav tab exists inside of the URL
        {
            $nonav = 0;              //If empty, set to 0
        }
        else
        {
            $nonav = $_GET['nonav'];  //import the $nonav variable from the URL
        };
        if($nonav == 0)
        {
            include "components/header.php";
        };
    ?>
    <main>
        <div class="content">
            <?php
                $id = "games";
                include "components/block-renderer.php";
            ?>
        </div>
    </main>
</body>
</html>