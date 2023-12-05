<?php
/*
* Filename      : SCUFF.php
* Created       : 22-11-2023
* Description   : SCUFF Engine for personal game project
* Programmer    : Mart Velema
*/
//NOTE: SCUFF asssumes ALL images are in the .png format. Using any other format WILL NOT function.
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
            //to access the dev interface, set the page= in the URL to dev and level= to the directory you want to see
            $dir = $level;
            echo "<a href=games.php style='background-color: white; padding: 10px;'>go back</a>
            <div class='dev'>";
            $portraits = glob('img/assets/' . $dir . '/*.png');     //make array out of all the images inside of the directory
            foreach($portraits as $portrait)                        //display each image
            {
                echo "
                <div class='image'>
                    <img src='".$portrait."' alt='".$portrait."'>
                    <p>".$portrait."<br></p>";
                $portrait = str_replace("img/assets/" . $dir . "/", "", $portrait);     //strip out directory out of portrait name
                $portrait = str_replace(".png", "", $portrait);                         //strip out .png out of portrait name
                echo "
                    <p>". $portrait ."<br><br></p>
                </div>";
            };
            echo "
            </div>
";  
            break;
        default:
            //decoding .json into something useable
            $data = json_decode(file_get_contents("data/games/" . $level . ".json"), true); //import .json file and decode it into an array
            $images = "";
            $buttons = "";
            $dir = $data[0];
            $dir = $dir['dir']; //setting the directory to the same directory found in the first .json entry
            //decoding array into something that can be used in HTML
            foreach($data[$page] as $name => $contents)
            {
                ${$name} = $contents;
                switch($name)   
                {                   //decodes the data from the decoded .json into something that can be used in HTML
                    case "imgL":
                    case "imgR":
                    case "img":
                        $style = 'style="';
                        if(array_key_exists('rotate', ${$name}) && ${$name}['rotate'] == 1)
                        {
                            $style .= "transform: scaleX(-1); ";                            //Set the rotate CSS when rotate is set
                        };
                        if(array_key_exists('talking', ${$name}) && ${$name}['talking'] == 1)
                        {
                            $style .= "scale: 1.1; box-shadow: 0px 0px 5px whitesmoke;";    //Set the talking CSS when talking is set
                            $talking = $name;
                        };
                        if(!array_key_exists('img', ${$name}) || empty(${$name}['img']))
                        {
                            ${$name}['img'] = "dev/missing_textures";                       //Set the image to default missing textures when images is not set correctly
                        };
                        $images .= '<img src="img/assets/' . $dir . '/' . ${$name}['img'] . '.png" alt="' . ${$name}['img'] . '" class="game-image" ' . $style . '"> '; //Sets the images in series to allow loading into HTML
                        break;
                    case "item":                                                            //Set the image for item
                        $item = '<img src="img/assets/' . $dir . '/' . $item . '.png" alt="' . $item . '" class="item">';
                        break;
                    case "dialogue":                                                        //set the dialogue paragraph
                        $dialogue = "<p>" . $dialogue . "</p>";
                        break;
                    case "background":
                        $background = 'style="background-color:' . $background . '"';
                        break;
                    case "backgroundImg":
                        $background = 'style="background-image: url(/portfolio2/img/assets/' . $dir . '/' . $backgroundImg .'.png)"';
                        break;
                    case "action":
                        $buttons = '';
                        break;
                };
            };
            if(empty($item))        //checks if item is empty, if so, set to empty so HTML doens't cause an error
            {
                $item = '';
            };
            if(empty($dialogue))    //checks if dialogue is empty, if so, set to empty HTML doesn't cause an error
            {
                $dialogue = '';
            };
            if(empty($background))  //checks if background is empty. if so, set to emtty HTML doesn't cause an error
            {
                $background = 'style="background-color:darkslategray"';
            };
            if(empty($buttons))     //checks if buttons are empty, if so, set to empty HTML doesn't cause an error
            {
                $buttons = '';
            };
            if(isset($talking))     //if the talking tag exists, run this
            {
                switch($talking)
                {                   //set the display and scale property of specific variables, depending on what's in the talking variable
                    case "imgL":
                        $arrow = '';
                        $talking = '';
                        break;
                    case "img":
                        $arrow = 'style="display: none;"';
                        $talking = '';
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
            else                    //if empty, set to empty in a way HTML understands
            {
                $talking = "";
                $arrow = 'style="display: none;"';
            };
            //setting the button for the next page
            $page++; //increment page variable to value of next page
            if(empty($data[$page]))
            {
                //Make only the previous page button if next entry in json is empty
                $pageRef = '<a href="games.php">Next&rarr;</a>';
                $pageData['page']  = $page;
                $pageData['level'] = $level;
                $pageData['nonav'] = $nonav;
                $pageData['page'] = $pageData['page'] - 2;
                $pageRefBack = '<a href="?' . http_build_query($pageData) . '">&larr;Previous</a>';
            }
            else
            {   
                //Make both the previous and next page button if next json entry is not empty
                $pageData['page']  = $page;
                $pageData['level'] = $level;
                $pageData['nonav'] = $nonav;
                $pageRef = '<a href="?' . http_build_query($pageData) . '">Next&rarr;</a>';
                $pageData['page'] = $pageData['page'] - 2;
                //if the previous page is 0 or below, don't make previous page button
                if($pageData['page'] >= 0)
                {
                    $pageRefBack = '<a href="?' . http_build_query($pageData) . '">&larr;Previous</a>';
                }
                else
                {
                    $pageRefBack = '';
                };
            };
            //going from arrays and variables to actual HTML
            echo
            '<div id="main-game" class="main-game" ' . $background . '>' . 
                '<div class="game">' .
                    '' . $images . ' ' .
                '</div>' .
                '<div class="game-talking" ' . $talking . '>' .
                    '<img src="img/assets/' . $dir . '/speech_bubble.png" alt="speech bubble" ' . $arrow . '>' .
                    '' . $item . ' ' .
                '</div>' .
                '<div class="game-center">' .
                    '' . $dialogue . ' ' .
                    '<div class="game-button">' .
                        '' . $pageRefBack . '' .
                        '' . $buttons . '' .
                        '' . $pageRef . '' .
                    '</div>' .
                '</div>' .
            '</div>';
            break;
    };
?>