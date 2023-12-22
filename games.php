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
        include "components/header.php";
    ?>
    <main>
        <div class="content">
            <div class="block" id="custom-game">
                <label for="gamefile"><h2>Custom game</h2></label>
                <div class="inner-block">
                    <form action="game.php" method="post" enctype="multipart/form-data" id="gameform">
                        <label for="gamefile">
                            Have a custom game made by you or by a friend? Well you're in luck! Drop the file in here to play that awesome custom game<br>
                            Click to upload game file!
                        </label>
                        <input type="file" name="gamefile" id="gamefile">
                    </form>
                </div>
            </div>
            <?php
                $id = "games";
                include "components/block-renderer.php";
            ?>
        </div>
    </main>
    <?php
        include "components/footer.php";
    ?>
    <script>
        document.getElementById('gamefile').onchange = function()
        {
            document.getElementById('gameform').submit();   
        };
    </script>
</body>
</html>