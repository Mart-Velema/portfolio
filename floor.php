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
        include "components/header.php"
    ?>
    <main>
        <?php
            if(empty($_GET['scene']))
            {
                echo '<p class="warning">No scene selected! Please select a scene.</p>';
                $_GET['scene'] ='';
            };
            if(empty($_GET['directory']))
            {
                echo '<p class="warning">No working directory selected! Please select directory where images are stored.</p>';
                $_GET['directory'] ='';
            };
        ?>
        <form method="get" style="grid-column: 1 / 2; height:min-content; width: 100%;">
            <h3>settings</h3>
            <label for="scene">Select scene mode</label>
            <select name="scene" id="scene">
                <option value="1">Single-image scenes</option>
                <option value="2">Double-image scenes</option>
            </select>
            <label for="directory">Set directory</label>
            <input type="text" name="directory" id="directory">
            <button type="submit">Set</button>
        </form>
        <form method="post">
            <?php
                switch($_GET['scene'])
                {
                    case 1:
                        echo
                        '<label for="img">Filename image</label>' .
                        '<input type="text" name="img" id="img">' . 
                        '<label for="img-talking">Talking</label>' .
                        '<input type="checkbox" name="img-talking" id="talking">';
                        break;
                    case 2:
                        echo
                        '<label for="imgL">Filename left image</label>' .
                        '<input type="text" name="imgL" id="imgL">' .
                        '<label for="imgR">Filename right image</label>' .
                        '<input type="text" name="imgR" id="imgR">';
                        break;
                    default:
                        echo '<p class="warning">Incorrect scene settings! Please select a correct scene type</p>';
                        break;
                };
            ?>
            <!-- <?php
                $test =
                [
                    [
                        "img" =>
                        [
                            "img" => "k_kit02_egao",
                            "talking" => 1
                        ],
                        "dialogue" => "Hello, World!",
                        "item" => "k_kit02_eago"
                    ],
                    [
                        "img" =>
                        [
                            "img" => "k_kit02_egao",
                            "rotate" => 1
                        ],
                        "dialogue" => "Test World!"
                    ],
                    [
                        "img" =>
                        [
                            "img" => "k_kit02_egao",
                        ],
                        "dialogue" => "Goodbye, World!"
                    ]
                ];
                var_dump($test);
                json_encode($test, JSON_PRETTY_PRINT);
                var_dump($test);
            ?> -->
        </form>
        <p></p>
    </main>
    <?php
        include "components/footer.php"
    ?>
</body>
</html>