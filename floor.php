<?php
    /*
    * Filename      : floor.php
    * Created       : 28-11-2023
    * Description   : FLOOR level editor for SCUFF
    * Programmer    : Mart Velema
    */
    session_start();
    $log = microtime(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - FLOOR</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <form method="get" style="grid-column: 1 / 2; height:min-content; width: 100%;">
            <h3>settings</h3>
            <label for="scene">Select scene mode</label>
            <select name="scene" id="scene">
                <option value="1">Single-image scenes</option>
                <option value="2">Double-image scenes</option>
            </select>
            <label for="dir">Set directory</label>
            <input type="text" name="dir" id="dir" required>
            <button type="submit">Set</button>
        </form>
        <?php
            if(empty($_GET))
            {
                echo '<p class="warning">Data for directory is unset! please set this requierd data before continiuing</p>';
                $_GET['scene'] = NULL;
            };
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if(empty($_SESSION['form-data']))
                {
                    $_SESSION['form-data'] = NULL;
                };
                switch($_POST['submit'])
                {
                    case "generate":
                        if($_GET['scene'] == 1)
                        {
                            $page = count($_SESSION['form-data']);
                            $_SESSION['form-data'][$page] = 
                            [
                                "img" => 
                                [
                                    "img"       => filter_input(INPUT_POST, "img"),
                                    "talking"   => filter_input(INPUT_POST, "img-talking"),
                                    "rotate"    => filter_input(INPUT_POST, "img-rotate")
                                ],
                                "item"           => filter_input(INPUT_POST, "item"),
                                "dialogue"       => filter_input(INPUT_POST, "dialogue")
                            ];
                        }
                        else
                        {
                            $page = count($_SESSION['form-data']);
                            $_SESSION['form-data'][$page] = 
                            [
                                "imL" => 
                                [
                                    "img"       => filter_input(INPUT_POST, "imgL"),
                                    "talking"   => filter_input(INPUT_POST, "imgL-talking"),
                                    "rotate"    => filter_input(INPUT_POST, "imgL-rotate")
                                ],
                                "imgR" => 
                                [
                                    "img"       => filter_input(INPUT_POST, "imgR"),
                                    "talking"   => filter_input(INPUT_POST, "imgR-talking"),
                                    "rotate"    => filter_input(INPUT_POST, "imgR-rotate")
                                ],
                                "item"           => filter_input(INPUT_POST, "item"),
                                "dialogue"       => filter_input(INPUT_POST, "dialogue")
                            ];
                        };
                        $_SESSION['form-data'][0]['dir'] = $_GET['dir'];
                        break;
                    case "done":
                        break;
                    case "reset":
                        $_SESSION['form-data'] = NULL;
                        break;
                };
            };
            echo '<form action="floor.php?' . http_build_query($_GET) . '" method="post">';
                switch($_GET['scene'])
                {
                    case 1:
                        echo
                        '<label for="img">Filename image</label>' .
                        '<input type="text" name="img" id="img">' . 
                        '<label for="img-talking">Talking</label>' .
                        '<input type="checkbox" name="img-talking" id="img-talking" value="1">' .
                        '<label for="img-rotate">Rotate</label>' .
                        '<input type="checkbox" name="img-rotate" id="img-rotate" value="1">';
                        break;
                    case 2:
                        echo
                        '<label for="imgL">Filename left image</label>' .
                        '<input type="text" name="imgL" id="imgL">' .
                        '<label for="imgL-talking">Talking</label>' .
                        '<input type="checkbox" name="imgL-talking" id="imgL-talking" value="1">' .
                        '<label for="imgL-rotate">Rotate</label>' .
                        '<input type="checkbox" name="imgL-rotate" id="imgL-rotate" value="1">' .
                        '<label for="imgR">Filename right image</label>' .
                        '<input type="text" name="imgR" id="imgR">' .
                        '<label for="imgR-talking">Talking</label>' .
                        '<input type="checkbox" name="imgR-talking" id="imgR-talking" value="1">' .
                        '<label for="imgR-rotate">Rotate</label>' .
                        '<input type="checkbox" name="imgR-rotate" id="imgR-rotate" value="1">';
                        break;
                    default:
                        echo '<p class="warning">Incorrect scene settings! Please select a correct scene type</p>';
                        break;
                };
            ?>
            <label for="item">Filename item</label>
            <input type="text" name="item" id="item">
            <label for="dialogue">Dialogue</label>
            <textarea name="dialogue" id="dialogue" placeholder="Put here your dialogue"></textarea>
            <label for="backgroundCheck">Is background image?</label>
            <input type="checkbox" name="backgroundCheck" id="backgroundCheck" value="1">
            <label for="background">Background value</label>
            <input type="text" name="background" id="background">
            <div>
                <?php
                    if(isset($_GET['dir']))
                    {
                        echo 
                        '<button type="submit" name="submit" value="generate">Generate</button>' .
                        '<button type="submit" name="submit" value="done">Done</button>' .
                        '<button type="submit" name="submit" value="reset">Reset</button>';
                    };
                ?>
            </div>
            <div style="color:white; background-color:black; width:99%;">
                <?php
                    if(isset($_SESSION['form-data']))
                    {
                        echo 
                        '<p><a style="background-color: white;" href="game.php?page=dev&level=' . $_GET['dir'] . '">' . $_GET['dir'] .'</a>' .
                        'Output console:</p>';
                        for ($i=0; $i < count($_SESSION['form-data']); $i++) 
                        { 
                            var_export($_SESSION['form-data'][$i]);
                            echo "<br><br>";
                        };
                    };
                ?>
            </div>
            <p>
            Welcome to the FLOOR Level-Editor. In here, you can make levels for the SCUFF Engine.<br>
            To use this engine, you first need to set up the correct directory and scene. You can do so in the menu on the top left side of this page. Set up the mode for single or double image scene, and enter a directory where the imgaes are saved.<br><br>
            For build-in assets, enter "GR-Portrait"<br><br>
            Once all the input fields are filled in, press "Generate" to complete a page.<br>
            Repeat untill you have made all of the pages, select the "done" checkbox to get the .json file that contains all the data for SCUFF to use.<br><br>
            <?php
                $log = (microtime(true) - $log);
                echo 'loadtime: ' . $log . ' &micro;s';
            ?>
            </p>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>