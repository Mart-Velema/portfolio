<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - PHP minigames</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php"
    ?>
    <main>
        <form name="rps" action="#" method="post">
            <h1>Steen, Papier, Schaar!</h1>
            <div class="radio">
                <label for="steen">steen</label>
                <input type="radio" name="rps" id="steen" value=1>
            </div>
            <div class="radio">
                <label for="papier">papier</label>
                <input type="radio" name="rps" id="papier" value=2>
            </div>
            <div class="radio">
                <label for="schaar">schaar</label>
                <input type="radio" name="rps" id="schaar" value=3>
            </div>
            <input type="submit">
            <input type="reset">
                <?php
                /*
                *Steen = 1
                *Papier = 2
                *Schaar = 3
                */
                $rps_player = 0;
                $rps_ai = 0;
                    if ($_SERVER["REQUEST_METHOD"] == "POST") #radio waarde omzetten in bruikbare waarde
                    {
                        $rps_player = filter_input(INPUT_POST, "rps");
                        $rps_ai = rand(1 , 3); #kiest een random waarde te gebruiken voor de opties
                        switch($rps_player) 
                        {
                            case($rps_player == 1); #laat de keuze van de speler zien
                                echo "<p>Jij kiest <b>steen</b></p>";
                                break;
                            case($rps_player == 2);
                                echo "<p>Jij kiest <b>papier</b></p>";
                                break;
                            case($rps_player == 3);
                                echo "<p>Jij kiest <b>schaar</b></p>";
                                break;
                        };
                        switch($rps_ai)
                        {
                            case($rps_ai == 1); #laat de keuze van de PC zien
                                echo "<p>PC kiest <b>steen</b></p>";
                                break;
                            case($rps_ai == 2);
                                echo "<p>PC kiest <b>papier</b></p>";
                                break;
                            case($rps_ai == 3);
                                echo "<p>PC kiest <b>schaar</b></p>";
                                break;
                        };
                        switch($rps_player)
                        {
                            case($rps_player == $rps_ai); #gelijkspel
                                echo "<p>Gelijk spel!</p>";
                                break;
                            case($rps_player == 1 && $rps_ai == 3); #combinatie voor als de speler wint
                                echo "<p>Jij wint!</p>";
                                break;
                            case($rps_player == 2 && $rps_ai == 1);
                                echo "<p>Jij wint!</p>";
                                break;
                            case($rps_player == 3 && $rps_ai == 2);
                                echo "<p>Jij wint!</p>";
                                break;
                            case($rps_player == 3 && $rps_ai == 1); #combinatie voor als de speler verliest
                                echo "<p>Jij verliest</p>";
                                break;
                            case($rps_player == 1 && $rps_ai == 2);
                                echo "<p>Jij verliest</p>";
                                break;
                            case($rps_player == 2 && $rps_ai == 3);
                                echo "<p>Jij verliest</p>";
                                break;
                        }; 
                    };
                ?>
        </form>
    </main>
    <?php
        include "components/footer.php"
    ?>
</body>
</html>