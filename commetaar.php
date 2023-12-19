<?php
/*
* Filename      : commetaar.php
* Assignment    : commetaar pagina
* Created       : 21-11-2023
* Description   : comments page for portfolio
* Programmer    : Mart Velema
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - Commetaar pagina</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <form action="#" method="post">
            <label for="naam">Naam</label>
            <input type="text" name="naam" id="naam">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            <div class="radio">
                <label for="student">Student</label>
                <input type="radio" name="beroep" id="student" value="student">
            </div>
            <div class="radio">
                <label for="onderwijzer">onderwijzer</label>
                <input type="radio" name="beroep" id="onderwijzer" value="onderwijzer">
            </div>
            <label for="commetaar">Commetaar</label>
            <textarea name="commetaar" id="commetaar" cols="30" rows="10"></textarea>
            <div class="radio">
                <label for="mailen">Iedereen mailen</label>
                <input type="checkbox" name="mailen" id="mailen">
            </div>
            <input type="submit" value="submit">
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $naam        = filter_input(INPUT_POST, "naam");
                    $email       = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                    $beroep      = filter_input(INPUT_POST, "beroep");
                    $commetaar   = filter_input(INPUT_POST, "commetaar");
                    $mailen      = filter_input(INPUT_POST, "mailen");
                    if($mailen == 1)
                    {
                        $mailen = "Alle gebruikers worden hier van op de hoogte gebracht";
                    }
                    else
                    {
                        $mailen =  "Alle gebruikers worden niet op de hoogte gebracht";
                    }
                    echo '<p>Beste <b>' .$naam . '</b>,<br><br>Je gaat commentaar plaatsen als <b>' . $beroep . '</b> met hetvolgende e-mailadres: <b>' . $email . '</b>. Het commentaar is als volgt: <br><br>' . $commetaar . '.<br><br>' . $mailen . '.</p>';
                };
            ?>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>