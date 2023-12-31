<?php
$logTime = microtime(true); //start time logging
/*
* Filename      : floor.php
* Created       : 28-11-2023
* Description   : FLOOR level editor for SCUFF
* Programmer    : Mart Velema
*/
include 'components/sql-login.php';
$maxOptions = 3 //maximum amount of options SCUFF can reliably create, this is an artificial limit that can be increased, but changes need to be reflected in the json encoder
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
        <form method="get" class="settings">
            <h3>settings</h3>
            <label for="scene">Select scene mode</label>
            <select name="scene" id="scene">
                <option value="single">Single-image scenes</option>
                <option value="double">Double-image scenes</option>
            </select>
            <label for="dir">Set directory</label>
            <input type="text" name="dir" id="dir">
            <button type="submit">Set</button>
        </form>
        <!-- <form method="get" style="grid-column: 1 / 2; width: 100%;">
            
        </form> -->
            <?php
                if(empty($_GET['dir']))
                {   //error handling for unset dir
                    echo '<p class="warning">Data for directory is unset! please set this requierd data before continiuing</p>';
                    $_GET['scene'] = NULL;
                };
                if($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    if(!array_key_exists('submit', $_POST))
                    {
                        $_POST['submit'] = NULL;
                    };
                    switch($_POST['submit'])
                    {   //switch to decode what action to preform
                        case "generate":
                            //putting all the form data into the session to proccess later on
                            //decoding options
                            for ($i=0; $i < $maxOptions; $i++) 
                            { 
                                ${'option' . $i} = filter_input(INPUT_POST, "option". $i);
                                ${'option' . $i} = !empty(${'option' . $i}) ? filter_input(INPUT_POST, "option" . $i . "action") . ${'option' . $i} : NULL;
                            };
                            $backgroundImg = filter_input(INPUT_POST, "backgroundImg");
                            $background = empty($backgroundImg) ? filter_input(INPUT_POST, "background") : $backgroundImg;
                            if($background === '#000000')
                            {
                                $background = NULL;
                            }
                            if($_GET['scene'] == 1)
                            {   //encoding for single-image scenes
                                $page = empty($_SESSION['form-data']) ? 0 : count($_SESSION['form-data']);
                                $_SESSION['form-data'][$page] = 
                                [
                                    "img" => 
                                    [
                                        "img"       => str_replace('.png', '', filter_input(INPUT_POST, "img")),
                                        "talking"   => filter_input(INPUT_POST, "img-talking"),
                                        "rotate"    => filter_input(INPUT_POST, "img-rotate")
                                    ],
                                    "item"          => str_replace('.png', '', filter_input(INPUT_POST, "item")),
                                    "dialogue"      => filter_input(INPUT_POST, "dialogue"),
                                    "background"    => $background,
                                    "action" =>
                                    [
                                        "setMarker" => filter_input(INPUT_POST, "setMarker"),
                                        "option0"   => $option0,
                                        "option1"   => $option1,
                                        "option2"   => $option2
                                    ]
                                ];
                            }
                            else
                            {   //encoidng for double-image scenes
                                $page = empty($_SESSION['form-data']) ? 0 : count($_SESSION['form-data']);
                                $_SESSION['form-data'][$page] = 
                                [
                                    "imL" => 
                                    [
                                        "img"       => str_replace('.png', '', filter_input(INPUT_POST, "imgL")),
                                        "talking"   => filter_input(INPUT_POST, "imgL-talking"),
                                        "rotate"    => filter_input(INPUT_POST, "imgL-rotate")
                                    ],
                                    "imgR" => 
                                    [
                                        "img"       => str_replace('.png', '', filter_input(INPUT_POST, "imgR")),
                                        "talking"   => filter_input(INPUT_POST, "imgR-talking"),
                                        "rotate"    => filter_input(INPUT_POST, "imgR-rotate")
                                    ],
                                    "item"          => str_replace('.png', '', filter_input(INPUT_POST, "item")),
                                    "dialogue"      => filter_input(INPUT_POST, "dialogue"),
                                    "background"    => $background,
                                    "action" =>
                                    [
                                        "setMarker" => filter_input(INPUT_POST, "setMarker"),
                                        "option1"   => $option0,
                                        "option1"   => $option1,
                                        "option2"   => $option2
                                    ]
                                ];
                            };
                            $_SESSION['form-data'][0]['dir'] = $_GET['dir'];
                            break;
                        case "done":
                            //putting the entire form-data from the session into a .json to download
                            $json = json_encode($_SESSION['form-data'], JSON_PRETTY_PRINT);
                            $file = fopen('upload/game.json', 'w');
                            fwrite($file, $json);
                            fclose($file);
                            break;
                        case "reset":
                            //reset the session
                            unset($_SESSION['form-data']);
                            break;
                    };
                };
                echo 
                '<form action="floor.php?' . http_build_query($_GET) . '#editor" method="post">' . 
                '<h3 id="editor">Primary images</h3>';
                if(array_key_exists('submit', $_POST) && $_POST['submit'] === 'done')
                {
                    //download link for .json :)
                    echo '<a href="upload/game.json" download>Download your completed game here!</a>';
                };
                switch($_GET['scene'])
                {
                    case 'single':
                        //form for single-image scenes
                        echo
                        '<label for="img">Filename image</label>' .
                        '<input type="text" name="img" id="img" placeholder="image filename">' . 
                        '<label for="img-talking">Talking</label>' .
                        '<input type="checkbox" name="img-talking" id="img-talking" value="1">' .
                        '<label for="img-rotate">Rotate</label>' .
                        '<input type="checkbox" name="img-rotate" id="img-rotate" value="1">';
                        break;
                    case 'double':
                        //form for double-image scenes
                        echo
                        '<label for="imgL">Filename left image</label>' .
                        '<input type="text" name="imgL" id="imgL" placeholder="left image filename">' .
                        '<label for="imgL-talking">Talking</label>' .
                        '<input type="checkbox" name="imgL-talking" id="imgL-talking" value="1">' .
                        '<label for="imgL-rotate">Rotate</label>' .
                        '<input type="checkbox" name="imgL-rotate" id="imgL-rotate" value="1">' .
                        '<label for="imgR">Filename right image</label>' .
                        '<input type="text" name="imgR" id="imgR" placeholder="right image filename">' .
                        '<label for="imgR-talking">Talking</label>' .
                        '<input type="checkbox" name="imgR-talking" id="imgR-talking" value="1">' .
                        '<label for="imgR-rotate">Rotate</label>' .
                        '<input type="checkbox" name="imgR-rotate" id="imgR-rotate" value="1">';
                        break;
                    default:
                        //print warning in case unset dir
                        echo '<p class="warning">Incorrect scene settings! Please select a correct scene type</p>';
                        break;
                };
            ?>
            <!--Form that's equal for both single and double scenes!-->
            <label for="item">Filename item</label>
            <input type="text" name="item" id="item" placeholder="item name">
            <label for="dialogue">Dialogue</label>
            <textarea name="dialogue" id="dialogue" placeholder="Put here your dialogue"></textarea>
            <label for="background">Backgrond (leave default for default colour)</label>
            <input type="color" name="background" id="background">
            <label for="backgroundImg">Or set a background image</label>
            <input type="text" name="backgroundImg" id="backgroundImg">
            <h3>Actions</h3>
            <label for="setMarker">Marker (Set to 0 to mark current page)</label>
            <input type="text" name="setMarker" id="setMarker" placeholder="marker">
            <?php
                for ($i=0; $i < $maxOptions; $i++) { 
                    echo
                    '<label for="option' . $i .'">Option ' . $i .'</label>' .
                    '<select name="option' . $i .'action" id="option' . $i .'action">' .
                        '<option value="give_">give</option>' .
                        '<option value="take_">take</option>' .
                        '<option value="jump_">jump</option>' .
                    '</select>' .
                    '<input type="text" name="option' . $i .'" id="option' . $i .'" placeholder="option' . $i .'">';
                };
            ?>
            <div>
                <?php
                    if(!empty($_GET['dir']))
                    {
                        //buttons that will only show up once dir is set correctly
                        echo 
                        '<button type="submit" name="submit" value="generate">Generate</button>' .
                        '<button type="submit" name="submit" value="done">Done</button>' .
                        '<button type="submit" name="submit" value="reset">Reset</button>';
                    };
                ?>
            </div>
            <a href="#manual"><button>View manual</button></a>
            <div class="console">
                <?php
                    if(!empty($_GET['dir']))
                    {
                        echo '<p><a href="game-launcher.php?scene=dev&page=' . $_GET['dir'] . '" target="_blank">Images:' . $_GET['dir'] .'</a> Output console:</p>';    //dev page where all the images of said dir are put in a grid
                    };
                    if(isset($_SESSION['form-data']))
                    {
                        for ($i=0; $i < count($_SESSION['form-data']); $i++)
                        { 
                            echo '<pre>page #' . $i . '<br>';
                            var_export($_SESSION['form-data'][$i]);
                            echo ';</pre>';
                        };
                    };
                ?>
            </div>
            <h3 id="manual">Manual</h3>
            <p>
            Welcome to the FLOOR Level-Editor. In here, you can make levels for the SCUFF Engine.<br>
            To use this engine, you first need to set up the correct directory and scene. You can do so in the menu on the top left side of this page. Set up the mode for single or double image scene, and enter a directory where the imgaes are saved.<br>
            When setting up a background for the scene, a background iamge takes priorty over a background colour.<br><br>
            Once all the input fields are filled in, press "Generate" to complete a page.<br>
            Repeat untill you have made all of the pages, select the "done" checkbox to get the .json file that contains all the data for SCUFF to use.<br><br>
            <a href="#editor"><button>Go to top</button></a>
            <?php
                $logTime = microtime(true) - $logTime . ' seconds';
                echo '<p class="warning">Loadtime: ' . $logTime . ' Seconds</p>';
            ?>
            </p>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>