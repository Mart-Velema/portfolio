<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - PHP opdracht 3</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php"
    ?>
    <main>
        <form action="#" method="post">
            <label for="leeftijd">Leeftijd</label>
            <input type="text" name="leeftijd" id="leeftijd">
            <label for="kleur">lievelingskleur</label>
            <input type="text" name="kleur" id="kleur">
            <label for="dier">lievelingsdier</label>
            <input type="text" name="dier" id="dier">
            <button type="submit">Submit</button>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $leeftijd   = filter_input(INPUT_POST, "leeftijd");
                    $kleur      = filter_input(INPUT_POST, "kleur");
                    $dier       = filter_input(INPUT_POST, "dier");
                    if(empty($leeftijd) OR empty($kleur) OR empty($dier))
                    {
                        echo "<b>Een of meerdere velden zijn niet ingevuld</b>";
                    }
                    else
                    {
                        $geluk = 0;
                        echo"
                        <p>leeftijd: <b>$leeftijd</b></p>
                        <p>lievelingskleur: <b>$kleur</b></p>
                        <p>lievelingsdier: <b>$dier</b></p>";
                            switch($leeftijd) 
                            {
                                case($leeftijd <=10):
                                    $geluk = $geluk + 1;
                                    break;
                                case($leeftijd >=11 && $leeftijd <= 20):
                                    $geluk = $geluk + 2;
                                    break;
                                case($leeftijd >=21 && $leeftijd <= 30):
                                    $geluk = $geluk + 3;
                                    break;
                                case($leeftijd >=31 && $leeftijd <= 40):
                                    $geluk = $geluk + 4;
                                    break;
                                case($leeftijd >=41):
                                    $geluk = $geluk + 5;
                                    break;
                            };
                            switch($kleur) 
                            {
                                case($kleur === "paars"):
                                    $geluk = $geluk + 2;
                                    break;
                                case($kleur === "rood"):
                                    $geluk = $geluk + 4;
                                    break;
                                case($kleur === "blauw"):
                                    $geluk = $geluk + 6;
                                    break;
                                case($kleur !== "paars" && $kleur !== "rood"  && $kleur !== "blauw"  ):
                                    $geluk = $geluk = 0;
                                    break;
                            };
                            switch($dier) 
                            {
                            case($dier ==="cavia"):
                                $geluk = $geluk * 4;
                                echo "<img src='img/fedora.png' alt='guinea-pig-logo'>";
                                break;
                            case($dier ==="hond"):
                                $geluk = $geluk + 8;
                                break;
                            case($dier ==="cat"):
                                $geluk = $geluk + 3;
                                break;
                            case($dier !=="cavia" && $dier !=="hond" && $dier !=="cat"):
                                $geluk = $geluk + 1;
                                break;
                            };
                        echo"<p>Magic number: <b>$geluk</b></p>";
                            switch($geluk) 
                            {
                                case($geluk <=10):
                                    echo"<p>You will recieve 1 million Pomsoms tomorrow</p>";
                                    break;
                                case($geluk >=11 && $geluk <= 20):
                                    echo"<p>You will recieve a very valuable Unusual with your next craft</p>";
                                    break;
                                case($geluk >=21 && $geluk <= 30):
                                    echo"<p>A random Spy main will become a Medic main</p>";
                                    break;
                                case($geluk >=31 && $geluk <= 40):
                                    echo"<p>Your next MvM tour will yield a Golden Frying Pan</p>";
                                    break;
                                case($geluk >=41):
                                    echo"<p>Medic will Über you and make you topscore</p>";
                                    break;
                            };
                    };
                };
            ?>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>