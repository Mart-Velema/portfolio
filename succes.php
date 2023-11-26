<?php
/*
* Filename      : succes.php
* Created       : 21-11-2023
* Description   : succes page & portal to game page
* Programmer    : Mart Velema
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - Homepage</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $passw = filter_input(INPUT_POST, "niewsbrief");
                if($passw === "GR2R")
                {
                    echo "<div class='succes'>
                    <p>Excelent</p>
                    <a href='index.php'>Go back to homepage</a>
                    <a href='game.php?page=0'>...Or don't</a>
                </div>";
                }
                else
                {
                    if(!filter_var($passw, FILTER_VALIDATE_EMAIL))
                    {
                        echo "<div class='succes'>
                        <p>Invalid e-mail!</p>
                        <a href='index.php'>Go back to homepage</a>
                    </div>";
                    }
                    else
                    {
                        echo "        <div class='succes'>
                        <p>You will recieve montly an email at <b>" . $passw . "</b></p>
                        <a href='index.php'>Go back to homepage</a>
                    </div>";
                    };
                };
            };
        ?>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>