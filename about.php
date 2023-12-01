<?php
/*
* Filename      : about.php
* Assignment    : form page for portfolio
* Created       : 21-11-2023
* Description   : about page for portfolio
* Programmer    : Mart Velema
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - About</title>
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
            <input type="text" name="naam" id="naam" required placeholder="naam*">
            <label for="achternaam">Achternaam</label>
            <input type="text" name="achternaam" id="achternaam" placeholder="achternaam">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="email*">
            <label for="wachtwoord">Wachtwoord</label>
            <input type="password" name="wachtwoord" id="wachtwoord">
            <label for="onderwerp">Onderwerp</label>
            <select name="onderwerp" id="onderwerp">
                <option value="opmerking">Opmerking</option>
                <option value="compliment" selected>Compliment</option>
                <option value="klacht">Klackt</option>
            </select>
            <label for="bericht">Bericht</label>
            <textarea name="bericht" id="bericht" rows="10" placeholder="bericht"></textarea>
            <div class="radio">
                <label for="niewsbrief">niewsbrief?</label>
                <input type="checkbox" name="niewsbrief" id="nieuwsbrief">
            </div>
            <button type="submit">Submit</button>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $name       = filter_input(INPUT_POST, "naam");
                    $lastname   = filter_input(INPUT_POST, "achternaam");
                    $mail       = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                    $passwd     = filter_input(INPUT_POST, "wachtwoord");
                    $subject    = filter_input(INPUT_POST, "onderwerp");
                    $message    = filter_input(INPUT_POST, "bericht");
                    $newsletter = filter_input(INPUT_POST, "niewsbrief");
                    if($newsletter === "on")
                    {
                        $newsletter = "<br><br>U ontvangt een niewsbrief van ons";
                    };
                    echo "<p>Beste <b>" . $name ." " . $lastname ."</b>, <br><br> Uw bericht over <b>" . $subject . "</b> is aangekomen bij ons. Voor eventueel antwoord, wordt u bericht op <b>" . $mail . "</b>. Hieronder staat nogmaals uw bericht<br><br>" . $message ."" . $newsletter . "</p>";
                    // var_dump($name, $lastname, $mail, $passwd, $subject, $message, $newsletter);
                };
            ?>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>