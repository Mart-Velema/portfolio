<?php
    $dir = "img/GR-Portrait/";  //directory of the images
    if(empty($_GET['page']))    //check if the $page tab exists inside of the URL
    {
        $page = 0;              //If empty, set to 0
    }
    else
    {
        $page = $_GET['page'];  //import the $page variable from the URL
    };
    switch ($page) {
        case 'dev':  
            //dev-interface
            echo "<a href=?page=1>go back</a>
            <div class='dev'>";
            $portraits = glob($dir . '*.png');  //make array out of all the images inside of the directory
            foreach($portraits as $portrait)    //display each image
            {
                echo "
                <div class='image'>
                    <img src='".$portrait."' alt='".$portrait."'>
                    <p>".$portrait."<br></p>";
                $portrait = str_replace($dir, "", $portrait);   //strip out directory out of portrait name
                $portrait = str_replace(".png", "", $portrait); //strip out .png out of portrait name
                echo "
                    <p>". $portrait ."<br><br></p>
                </div>";
            };
            echo "
            </div>
";  
            break;
        default:
            $data = json_decode(file_get_contents("data/game.json"), true); //import .json file and decode it into an array
            if(empty($data[$page]))                                         //checks if .json entry exists
            {
                $error = array( /*Some funny error messages*/
                    "Something went wrong! Now what?",
                    "I don't think that was supposed to happen...",
                    "Jupp that definetly wasn't supposed to happen",
                    "That's it? You're not fighting back?",
                    "Whoops, accidentally spilled my beer over the page",
                    "Something something .json something php something went threeways sideways right into a ditch",
                    "What? Are you gonna blame me? (Well I guess it is my fault)",
                    "I'm sorry, I'll try better next time",
                    "Please don't look at me like that, it makes me nervous",
                    "This is what happens when a guinea pig makes a website",
                    "ffs...",
                    "Hey HEY HEY! Don't do that again, please, I'm begging you",
                    "<a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ'>I've got something to cheer you up</a>",
                    "I did say I warned ya... O wait no I forgot to warn you, whoops",
                    "This is rather, unsatisfactory",
                    "This is sad. Alexa, play Despacito",
                    "<img src='https://wiki.teamfortress.com/w/images/7/76/Buffed_red_engineer.jpg' alt='TF2 Red engineer'>Spah Sappi'n my website!",
                    "<img src='https://wiki.teamfortress.com/w/images/a/a5/Buffed_blu_engineer.jpg' alt='TF2 blu engineer'>Spah sappi'n my website! (but in blue)",
                    "Q: Did you think this would happen?<br><br>A: yes, I did",
                    "Thats it, bailing out! you're on your own now"
                );
                $errorNumber = rand(0,(count($error)-1));       //variable for a random error message
                $data[$page] = array(
                    "imgL"     => array (
                        "img"       => "",
                        "rotate"    => "",
                        "talking"   => "",
                    ),
                    "imgR"     => array (
                        "img"       => "",
                        "rotate"    => "",
                        "talking"   => "",
                    ),
                    "dialogue"      => "$error[$errorNumber]<br><br> End of JSON file. No valid data entries to be loaded",      /*put a random error message into the "text" key*/
                );
            };
            foreach($data[$page] as $name => $contents)                 //puts all the data of the .json entry corresponding with the page number into the $contents variable,
            {                                                           //import the entry name of the .json file as $name
                ${$name} = $contents;                                   //make new variable with the same name as the $name variable
            };
            $page++;
            if(empty($data[$page]))
            {
                $pageRef = "game.php";
            }
            else
            {
                $pageRef = "?page=$page";
            };
            echo "<div class='game'>
                <img src='" .$dir, $imgL['img'] . ".png' alt='" . $imgL['img'] . "' class='game-left game-talking-" . $imgL['talking'] ." game-rotate-" . $imgL['rotate'] . "'>
                <img src='" .$dir, $imgR['img'] . ".png' alt='" . $imgR['img'] . "' class='game-right game-talking" . $imgR['talking'] ." game-rotate-" . $imgR['rotate'] . "'>
            </div>
            <div class='game'>
                <div class='game-center'>
                    <p>" . $dialogue . "</p>
                    <div class='game-button'>
                        <a href='?page=" . $page - 1 ."'>&larr;Previous</a>
                        <a href='" . $pageRef . "'>Next&rarr;</a>
                   </div>
                </div>
            </div>
";
            break;
    };
?>