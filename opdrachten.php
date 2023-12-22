<?php
/*
* Filename      : opdrachten.php
* Assignment    : omreken opdrachtn
* Created       : 21-11-2023
* Description   : assignments for webdev
* Programmer    : Mart Velema
*/
include 'components/sql-login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - PHP opdracht 1</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php"
    ?>
    <main>
        <form action="#" method="post">
            <h2>Celcius en Farhenheit</h2>
            <label for="graden">Graden</label>
            <input type="number" name="graden" id="graden" placeholder="graden">
            <label for="gradentype">Naar</label>
            <select name="gradentype" id="gradentype">
                <option value="F">Farhenheit</option>
                <option value="C">Celcius</option>
            </select>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $gradenIn = filter_input(INPUT_POST, "graden");
                    $gradenUit = filter_input(INPUT_POST, "gradentype");
                    if(empty($gradenIn))
                    {
                        echo "<b>Graden veld is leeg</b>";
                    }
                    else
                    {
                        switch($gradenUit)
                        {
                            case($gradenUit === "F"):
                                $gradenIn = $gradenIn *(9/5)+32;
                                echo $gradenIn . 'F';
                                break;
                            case($gradenIn === "C"):
                                $gradenIn = ($gradenIn - 32) * 5/9; 
                                echo $gradenIn . 'C';
                                break;
                        };
                    }
                }
            ?>
            <h2>Km en Mijl</h2>
            <label for="afstand">afstand</label>
            <input type="text" name="afstand" id="afstand" placeholder="afstand">
            <label for="afstandtype">Naar</label>
            <select name="afstandtype" id="afstandtype">
                <option value="Km">Kilometer</option>
                <option value="Mi">Mijl</option>
            </select>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $afstandIn = filter_input(INPUT_POST, "afstand");
                    $afstandUit = filter_input(INPUT_POST, "afstandtype");
                    if(empty($afstandIn))
                    {
                        echo "<b>Afstand veld is leeg</b>";
                    }
                    else
                    {
                        switch($afstandUit)
                        {
                            case($afstandUit === "Km"):
                                $afstandIn = $afstandIn * 0.6214;
                                echo $afstandIn . 'Mijl';
                                break;
                            case($afstandUit === "Mi"):
                                $afstandIn = $afstandIn / 0.6214;
                                echo $afstandIn . 'Km';
                                break;
                        };
                    } 
                }
            ?>
            <h2>Omtrek circel</h2>
            <label for="omtrek">Radius</label>
            <input type="text" name="omtrek" id="omtrek" placeholder="radius">
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $omtrek = filter_input(INPUT_POST, "omtrek");
                    if(empty($omtrek))
                    {
                        echo "<b>Radius veld is leeg</b>";
                    }
                    else
                    {
                        $omtrek = ($omtrek * 2) * pi();
                        echo 'De omtrek is ' . $omtrek;
                    };
                }
            ?>
            <h1>Modulo %</h1>
            <label for="datum">Datum</label>
            <input type="text" name="datum" id="datum" placeholder="DD-MM-YYYY (no spaces)">
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $datum = filter_input(INPUT_POST, "datum");
                    if(empty($datum))
                    {
                        echo "<b>Datum veld is leeg</b>";
                    }
                    else
                    {
                        $dag = round($datum / 1000000);
                        $maand = round(($datum % ($dag * 1000000)/10000));
                        $jaar = round(($datum % ($dag * 1000000 + $maand *10000)));
                        echo "<p><b>" . $dag . "</b> dagen</p>";
                        echo "<p><b>" . $maand . "</b> maanden</p>";
                        echo "<p><b>" . $jaar . "</b> jaren</p>";
                    };
                }
            ?>
            <button type="submit">Submit</button>
        </form>
    </main>
    <?php
        include "components/footer.php"
    ?>
</body>
</html>