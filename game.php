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
        <div class='main-game'>
            <?php
                include "components/game-renderer.php";
            ?>
        </div>
    </main>
</body>
</html>