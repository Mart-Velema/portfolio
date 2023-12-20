<?php
/*
* Filename      : opdrachten_2.php
* Assignment    : cijfers omzetten
* Created       : 21-11-2023
* Description   : assignemnts for webdev
* Programmer    : Mart Velema
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - PHP opdracht 2</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <form action="#" method="post">
            <label for="cijfer">Cijfer</label>
            <input type="text" name="cijfer" id="cijfer">
            <button type="submit">Submit</button>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $cijfer = filter_input(INPUT_POST, "cijfer");
                    echo"<p>cijfer $cijfer</p>";
                    echo"<p><b>if-statement:</b></p>";
                        if ($cijfer < 1) 
                        {
                            echo "ongeldig cijfer";
                        }
                        if ($cijfer >= 1 && $cijfer <= 3) 
                        {
                            echo "zeer slecht";
                        }
                        if ($cijfer >= 4 && $cijfer <= 5) 
                        {
                            echo "onvoldoende";
                        }
                        if ($cijfer >= 6 && $cijfer <= 7) 
                        {
                            echo "voldoende";
                        }
                        if ($cijfer == 8) 
                        {
                            echo "goed";
                        }
                        if ($cijfer == 9) 
                        {
                            echo "zeer goed";
                        }
                        if ($cijfer == 10) 
                        {
                            echo "uitmuntend";
                        }
                        if ($cijfer > 10) 
                        {
                            echo "ongeldig cijfer";
                        }
                    echo"<p><b>Switchcase:</b></p>";
                    switch ($cijfer) 
                        {
                        case ($cijfer < 1):
                            echo "ongeldig cijfer";
                            break;
                        case ($cijfer >= 1 && $cijfer <= 3):
                            echo "zeer slecht";
                            break;
                        case ($cijfer >= 4 && $cijfer <= 5):
                            echo "onvoldoende";
                            break;
                        case ($cijfer >= 6 && $cijfer <= 7):
                            echo "voldoende";
                            break;
                        case ($cijfer == 8):
                            echo "goed";
                            break;
                        case ($cijfer == 9):
                            echo "zeer goed";
                            break;
                        case ($cijfer == 10):
                            echo "uitmuntend";
                            break;
                        case ($cijfer > 10):
                            echo "ongeldig cijfer";
                            break;
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