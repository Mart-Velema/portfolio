<?php
/*
* Filename      : afstanden.php
* Assignment    : afstanden berekenen
* Created       : 21-11-2023
* Description   : determine distances between two cities with an array
* Programmer    : Mart Velema
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - Afstanden berekenen</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <?php
            $distances = array(
                "Berlin" => array(
                    "Berlin" => 0,
                    "Moscow" => 1607.99,
                    "Paris" => 876.96,
                    "Prague" => 280.34,
                    "Rome" => 1181.67),
                "Moscow" => array(
                    "Berlin" => 1607.99,
                    "Moscow" => 0,
                    "Paris" => 2484.92,
                    "Prague" => 1664.04,
                    "Rome" => 2374.26),
                "Paris" => array(
                    "Berlin" => 876.96,
                    "Moscow" => 641.31,
                    "Paris" => 0,
                    "Prague" => 885.38,
                    "Rome" => 1105.76),
                "Prague" => array(
                    "Berlin" => 280.34,
                    "Moscow" => 1664.04,
                    "Paris" => 885.38,
                    "Prague" => 0,
                    "Rome" => 922),
                "Rome" => array(
                    "Berlin" => 1181.67,
                    "Moscow" => 2374.26,
                    "Paris" => 1105.76,
                    "Prague" => 922,
                    "Rome" => 0));
        ?>
        <form action="#" method="post">
            <label for="start">Start location</label>
            <select name="start" id="start">
                <?php
                    foreach($distances as $x => $city)
                    {
                        echo "<option value='$x'>$x</option>";
                    }
                ?>
            </select>
            <label for="end">End location</label>
            <select name="end" id="end">
                <?php
                    foreach($distances as $x => $city)
                    {
                        echo "<option value='$x'>$x</option>";
                    }
                ?>
            </select>
            <button type="submit">Submit</button>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $start  = filter_input(INPUT_POST, "start");
                    $end    = filter_input(INPUT_POST, "end");
                    $km = $distances[$start];
                    $km = $km[$end];
                    echo "<p>The distance between <b>$start</b> and <b>$end</b> is <b>$km</b> km</p>";
                };
            ?>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>