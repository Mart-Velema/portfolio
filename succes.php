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
    <title>Portfolio Mart - Succes</title>
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
                $email = filter_input(INPUT_POST, "niewsbrief");
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    echo 
                    '<div class="succes">' .
                    '<p>Invalid e-mail!</p>' .
                    '<a href="index.php">Go back to homepage</a>' .
                    '</div>';
                }
                else
                {
                    echo 
                    '<div class="succes">' .
                    '<p>You will recieve montly an email at <b>' . $email . '</b></p>' .
                    '<a href="index.php">Go back to homepage</a>' .
                    '</div>';
                };
            };
        ?>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>