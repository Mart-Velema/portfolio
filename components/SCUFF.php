<?php
/*
* Filename      : SCUFF.php
* Created       : 22-11-2023
* Description   : SCUFF Engine for personal game project
* Programmer    : Mart Velema
*/
//NOTE: SCUFF asssumes ALL images are in the .png format. Using any other format WILL NOT function.
    if(empty($_GET['page']))
    {
        $_GET['page'] = 0;
    };
    $images = '';
    $item = '';
    $dialogue = '';
    $background = 'style="background-color:darkslategray"';
    $options = '';
    $next = 'Next';
    switch ($_GET['page']) {
        case 'dev':  
            //dev-interface
            //to access the dev interface, set the page= in the URL to dev and level= to the directory you want to see
            echo "<a href=games.php style='background-color: white; padding: 10px;'>go back</a>
            <div class='dev'>";
            $portraits = glob('img/assets/' . $_GET['level'] . '/*.png');     //make array out of all the images inside of the directory
            foreach($portraits as $portrait)                        //display each image
            {
                echo "
                <div class='image'>
                    <img src='".$portrait."' alt='".$portrait."'>
                    <p>".$portrait."<br></p>";
                $portrait = str_replace("img/assets/" . $_GET['level'] . "/", "", $portrait);     //strip out directory out of portrait name
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
            if(isset($_GET['level']))
            {
                if(file_exists('data/games/' . $_GET['level'] . '.json'))
                {
                    //decoding .json into something useable
                    $data = json_decode(file_get_contents("data/games/" . $_GET['level'] . ".json"), true); //import .json file and decode it into an array
                    $dir = $data[0]['dir'];                                                                 //setting the directory to the same directory found in the first .json entry
                    //decoding array into something that can be used in HTML
                    if(isset($data[$_GET['page']])) 
                    {
                        foreach($data[$_GET['page']] as $name => $contents)
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
                                case "background":
                                    $background = 'style="background-color:' . $background . '"';       //set the backgorund colour
                                    break;
                                case "backgroundImg":
                                    $background = 'style="background-image: url(/portfolio2/img/assets/' . $dir . '/' . $backgroundImg .'.png)"';   //set the background image
                                    break;
                                case "action":
                                    $options = '';
                                    foreach(${$name} as $option => $action)
                                    {
                                        ${$option} = $action;
                                        $option = str_replace(range(0, 9), '', $option);
                                        switch($option)
                                        {
                                            case "redirect":
                                                $options .= '<a href="' . $action . '">' . str_replace('.php', '', $action) . '</a>';    //make redirect button
                                                break;
                                            case "setMarker":
                                                $_GET['marker'] = $action;                                      //sets a marker to jump back to later
                                                if(${$option} == 0)
                                                {
                                                    $_GET['marker'] = $_GET['page'];                            //if the marker is 0, use current page
                                                };
                                                break;
                                            case "option":
                                                $actionSubstring = substr($action, 0, 5);
                                                $action = str_replace($actionSubstring, '', $action);           //filtering action type
                                                switch($actionSubstring)
                                                {                                                               //decoding action type
                                                    case "give_":
                                                        $options .= '<button type="submit" value="' . $action . '" name="give">take: ' . $action . '</button> ';
                                                        break;
                                                    case "take_":
                                                        $options .= '<button type="submit" value="' . $action . '" name="take">give: ' . $action . '</button> ';
                                                        break;
                                                    case "jump_":
                                                        empty($action) ? $action = $_GET['marker'] : '';      //if jump has no page number, go to marker
                                                        $jump = $_GET;
                                                        $jump['page'] = $action;
                                                        break;
                                                };
                                                break;
                                        };
                                    };
                                    break;
                            };
                        };
                    }
                    else
                    {   //error handling in case empty 
                        $images = '<img src="img/assets/dev/missing_textures.png">';
                        $dialogue = 'ERROR: Missing JSON entry, redirecting to fallback page';
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
                    $_GET['page']++;
                    if(empty($data[$_GET['page']]))
                    {
                        $_GET['page'] = $_GET['page'] - 2;
                        $pageRefBack = '<a href="?' . http_build_query($_GET) . '">&larr;Previous</a>';
                        $pageRef = '<a href="games.php">Homepage</a>';
                    }
                    else
                    {   
                        //Make both the previous and next page button if next json entry is not empty
                        $pageRef = isset($jump) ? '<a href="?' . http_build_query($jump) . '">' . $next . '</a>' : '<a href="?' . http_build_query($_GET) . '">' . $next . '&rarr;</a>';   //If jump is set, make button to go to jump page, if not, use default next button
                        empty($options) ? '' : $pageRef = '';
                        $_GET['page'] = $_GET['page'] - 2;
                        $pageRefBack = isset($data[$_GET['page']]) ? '<a href="?' . http_build_query($_GET) . '">&larr;Previous</a>' : '';  //Setting back button if previous page exists
                    };
                    //going from arrays and variables to actual HTML
                    $_GET['page'] = $_GET['page'] + 2;
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
                            '<p>' . $dialogue . '</p>' .
                            '<form method="post" action="?' . http_build_query($_GET) . '" class="game-button">' .
                                '' . $pageRefBack . '' .
                                '' . $options . '' .
                                '' . $pageRef . '' .
                            '</form>' .
                        '</div>' .
                    '</div>';
                }
                else
                {
                    echo '<p class="warning">Level json file does not exist!</p>';
                };
            }
            else
            {
                echo '<p class="warning">Level not set</p>';
            };
            break;
        };
?>