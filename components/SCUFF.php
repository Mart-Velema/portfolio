<?php
/*
* Filename      : game-renderen.php
* Created       : 22-11-2023
* Description   : "Rendering engine" for personal game project
* Programmer    : Mart Velema
*/
    $dir = "img/assets/GR-Portrait/";  //directory of the images
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
            echo count($portraits);
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
//             $data = json_decode(file_get_contents("data/games/" . $level . ".json"), true); //import .json file and decode it into an array
//             if(empty($data[$page]))                                         //checks if .json entry exists
//             {
//                 $data[$page] = array(
//                     "imgL"     => array (
//                         "img"       => "dev/missing_textures",
//                         "rotate"    => 0,
//                         "talking"   => 0
//                     ),
//                     "imgR"     => array (
//                         "img"       => "dev/missing_textures",
//                         "rotate"    => 0,
//                         "talking"   => 0
//                     ),
//                     "dialogue"      => "End of JSON file. No valid data entries to be loaded",
//                     "item"          => "dev/missing_textures"
//                 );
//             };
//             foreach($data[$page] as $name => $contents)                 //puts all the data of the .json entry corresponding with the page number into the $contents variable,
//             {                                                           //import the entry name of the .json file as $name
//                 ${$name} = $contents;                                   //make new variable with the same name as the $name variable
//             };
//             $page++;                        //increment page variable to value of next page
//             if(empty($data[$page]))
//             {
//                 $pageRef = "games.php";      //if next page is empty, redirect to game's homepage
//             }
//             else
//             {   
//                 $pageData = array (
//                     "page"  => "$page",
//                     "level" => "$level"
//                 );
//                 $pageRef = "?" . http_build_query($pageData) . "";  //set the $pageRef vairaible to include all the data generated by this page
//             };
//             if(isset($imgR) && array_key_exists('talking', $imgR) && $imgR['talking'] == 1) //temporrary hotfix that has become permanent.                                                                                  
//             {                                                                               //checks if ImgR exists with an entry for rotate
//                 $inverse = "rotate-1";                                                      //And if it does exists, set $inverse to CSS class that rotates speech bubble arrow
//             }
//             else
//             {
//                 $inverse = "";
//             };
//             //going from variables to actual display
//             echo "<div class='game'>";
//             $imgCount = 0;                //empty string that needs to be here to work properly
//             if(isset($imgL) && array_key_exists('img', $imgL) && $imgL['img'] != 0)     //check if left image is present
//             {
//                 echo"
//                 <img src='" .$dir, $imgL['img'] . ".png' alt='" . $imgL['img'] . "' class='game-image game-talking-" . $imgL['talking'] ." rotate-" . $imgL['rotate'] . "'>";
//                 $imgCount++;
//             };
//             if(isset($imgR) && array_key_exists('img', $imgR) && $imgR['img'] != 0)     //check if right image is present
//             {
//                 echo"
//                 <img src='" .$dir, $imgR['img'] . ".png' alt='" . $imgR['img'] . "' class='game-image game-talking-" . $imgR['talking'] ." rotate-" . $imgR['rotate'] . "'>";
//                 $imgCount++;
//             };
//             if(isset($img) && array_key_exists('img', $img) && $img['img'] != 0)        //check if image is present
//             {
//                 echo"
//                 <img src='" .$dir, $img['img'] . ".png' alt='" . $img['img'] . "' class='game-image game-talking-" . $img['talking'] ." rotate-" . $img['rotate'] . "'>";
//                 $imgCount++;
//             };
//             echo "
//             </div>
//             <div class='game-talking " . $inverse . "'>";
//             if($imgCount == 2)          //check if there are two images availabe, if not, don't render a specch bubble arrow
//             {
//                 echo"
//                 <img src='" . $dir . "speech_bubble.png' alt='speech bubble'>";
//             };
//             if(isset($item))            //check if the item variable is set
//             {
//                 echo"
//                 <img src='" . $dir, $item . ".png' alt='$item' class='item'>";
//             };
//             echo"
//             </div>
//             <div class='game'>
//                 <div class='game-center'>";
//             if(isset($dialogue))
//             {
//                 echo"
//                     <p>" . $dialogue . "</p>";
//             };
//             echo"
//                     <div class='game-button'>
//                         <a href='" . $pageRef . "'>Next&rarr;</a>
//                    </div>
//                 </div>
//             </div>
// ";
            //decoding .json into something useable
            $data = json_decode(file_get_contents("data/games/" . $level . ".json"), true); //import .json file and decode it into an array
            $images = "";
            //decoding array into something that can be used in HTML
            foreach($data[$page] as $name => $contents)
            {
                ${$name} = $contents;
                switch($name)
                {
                    case "imgL":
                    case "imgR":
                    case "img":
                        $style = 'style="';
                        if(array_key_exists('rotate', ${$name}) && ${$name}['rotate'] == 1)
                        {
                            $style .= "transform: scaleX(-1); ";
                        };
                        if(array_key_exists('talking', ${$name}) && ${$name}['talking'] == 1)
                        {
                            $style .= "scale: 1.1; box-shadow: 0px 0px 5px whitesmoke;";
                            $talking = $name;
                        };
                        if(!array_key_exists('img', ${$name}) || empty(${$name}['img']))
                        {
                            ${$name}['img'] = "dev/missing_textures";
                        };
                        $images .= '<img src="' . $dir . '' . ${$name}['img'] . '.png" alt="' . ${$name}['img'] . '" class="game-image" ' . $style . '"> ';
                        break;
                };
            };
            if(isset($item))
            {
                $item = '<img src="' . $dir . '' . $item . '.png" alt="' . $item . '" class="item">';
            }
            else
            {
                $item = "";
            };
            if(empty($dialogue))
            {
                $dialogue = "";
            };
            if(isset($talking))
            {
                switch($talking)
                {
                    case "imgL":
                    case "img":
                        $arrow = '';
                        $talking = '"';
                        break;
                    case "imgR":
                        $arrow = '';
                        $talking = 'style="transform: scaleX(-1);"';
                        break;
                    default:
                        $arrow = 'style="display: none;"';
                        $talking = 'style="transform: scaleX(-1);"';
                        break;
                };
            }
            else
            {
                $talking = "";
                $arrow = 'style="display: none;"';
            };
            //setting the button for the next page
            $page++;                        //increment page variable to value of next page
            if(empty($data[$page]))
            {
                $pageRef = "games.php";      //if next page is empty, redirect to game's homepage
            }
            else
            {   
                $pageData = array (
                    "page"  => "$page",
                    "level" => "$level"
                );
                $pageRef = "?" . http_build_query($pageData) . "";  //set the $pageRef vairaible to include all the data generated by this page
                $pageData['page'] = $pageData['page'] - 2;
                $pageRefBack = "?" . http_build_query($pageData) . ""; 
            };
            //going from arrays and variables to actual HTML
            echo
            '<div class="game">' .
                '' . $images . ' ' .
            '</div>' .
            '<div class="game-talking" ' . $talking . '>' .
                '<img src="' . $dir . 'speech_bubble.png" alt="speech bubble"' . $arrow . '>' .
                '' . $item . ' ' .
            '</div>' .
            '<div class="game-center">' .
                '' . $dialogue . ' ' .
                '<div class="game-button">' .
                    '<a href="' . $pageRefBack . '">&larr;Previous</a>' .
                    '<a href="' . $pageRef . '">Next&rarr;</a>' .
                '</div>' .
            '</div>';
            break;
    };
    
?>