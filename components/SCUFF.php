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
        $_GET['scene'] = 'default';
    };
    $images     = '';
    $item       = '';
    $dialogue   = '';
    $background = 'background-color:darkslategray';
    $options    = '';
    $next       = 'Next';
    if(isset($_GET['level']))
    {
        if(file_exists('data/games/' . $_GET['level'] . '.json'))
        {
            //decoding .json into something useable
            $json = json_decode(file_get_contents("data/games/" . $_GET['level'] . ".json"), true); //import .json file and decode it into an array
            $dir = $json[0]['dir'];  
            switch ($_GET['scene'])
            {
                // case 'battle'
                //     break;
                default:                                                               //setting the directory to the same directory found in the first .json entry
                    //decoding array into something that can be used in HTML
                    if(isset($json[$_GET['page']])) 
                    {
                        $data = $json[$_GET['page']];
                        foreach($data as $name => $contents)
                        {
                            ${$name} = $contents;
                            switch($name)   
                            {                   //decodes the data from the decoded .json into something that can be used in HTML
                                case "imgL":
                                case "imgR":
                                case "img":
                                    $style = '';
                                    if(array_key_exists('rotate', ${$name}) && ${$name}['rotate'] == 1)
                                    {
                                        $style .= "transform: scaleX(-1); ";                            //Set the rotate CSS when rotate is set
                                    };
                                    if(array_key_exists('talking', ${$name}) && ${$name}['talking'] == 1)
                                    {
                                        $style .= "scale: 1.1; box-shadow: 0px 0px 5px whitesmoke;";    //Set the talking CSS when talking is set
                                        $talking = $name;
                                    };
                                    $images .= '<img src="img/assets/' . $dir . '/' . ${$name}['img'] . '.png" alt="' . ${$name}['img'] . '" class="game-image" style="' . $style . '"> '; //Sets the images in series to allow loading into HTML
                                    break;
                                case "item":                                                            //Set the image for item
                                    $item = '<img src="img/assets/' . $dir . '/' . $item . '.png" alt="' . $item . '" class="item">';
                                    break;
                                case "background":
                                    if(isset($background))
                                    {
                                        $pattern = '/^#?([a-f0-9]{6}|[a-f0-9]{3})$/i';      //check if value is hex
                                        $background = str_replace('#', '', $background);    //remove # from string
                                        $background = str_replace('.png', '', $background); //remove .png from string
                                        $background = preg_match($pattern, $background) ? 'background-color:#' . $background . ';"' : 'background-image: url(img/assets/' . $dir . '/' . $background .'.png);'; 
                                        //Set the backgrond to either image or fixed colour depending on if value is hex
                                    };
                                    break;
                                case "action":
                                    foreach(${$name} as $option => $action)
                                    {
                                        ${$option} = $action;
                                        $option = str_replace(range(0, 9), '', $option);
                                        switch($option)
                                        {
                                            case "redirect":
                                                if(isset($action))
                                                {
                                                    $options .= '<a href="' . $action . '">' . str_replace('.php', '', $action) . '</a>';    //make redirect button
                                                };
                                                break;
                                            case "setMarker":
                                                if(isset($action))
                                                {
                                                    $_GET['marker'] = $action;                                      //sets a marker to jump back to later
                                                    if(${$option} == 0)
                                                    {
                                                        $_GET['marker'] = $_GET['page'];                            //if the marker is 0, use current page
                                                    };
                                                };
                                                break;
                                            case "option":
                                                if(isset($action))
                                                {
                                                    $actionSubstring = substr($action, 0, 5);
                                                    $action = str_replace($actionSubstring, '', $action);           //filtering action type
                                                    switch($actionSubstring)
                                                    {                                                               //decoding action type
                                                        case "give_":
                                                            $options .= '<button type="submit" value="' . $action . '" name="give">take: ' . $action . ' </button>';
                                                            break;
                                                        case "take_":
                                                            $options .= '<button type="submit" value="' . $action . '" name="take">give: ' . $action . ' </button>';
                                                            break;
                                                        case "jump_":
                                                            $action == 0 ? $action = $_GET['marker'] : '';      //if jump has no page number, go to marker
                                                            $jump = $_GET;
                                                            $jump['page'] = $action;
                                                            $next = 'jump';
                                                            break;
                                                    };
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
                        $background = 'background-image: url(img/assets/dev/missing_textures.png)';
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
                                $arrow = 'display: none;';
                                $talking = '';
                                break;
                            case "imgR":
                                $arrow = '';
                                $talking = 'transform: scaleX(-1);';
                                break;
                            default:
                                $arrow = 'display: none;';
                                $talking = 'transform: scaleX(-1);';
                                break;
                        };
                    }
                    else                    //if empty, set to empty in a way HTML understands
                    {
                        $talking = '';
                        $arrow = 'display: none;';
                    };
                    //setting the button for the next page
                    $_GET['page']++;
                    if(empty($json[$_GET['page']]))
                    {
                        $_GET['page'] = $_GET['page'] - 2;
                        $pageRefBack = '<a href="?' . http_build_query($_GET) . '">&larr;Previous</a>';
                        $pageRef = isset($jump) ? '<a href="?' . http_build_query($jump) . '">' . $next . '</a>' : '<a href="games.php">Homepage</a>';
                    }
                    else
                    {   
                        //Make both the previous and next page button if next json entry is not empty
                        $pageRef = isset($jump) ? '<a href="?' . http_build_query($jump) . '">' . $next . '</a>' : '<a href="?' . http_build_query($_GET) . '">' . $next . '&rarr;</a>';   //If jump is set, make button to go to jump page, if not, use default next button
                        empty($options) ? '' : $pageRef = '';
                        $_GET['page'] = $_GET['page'] - 2;
                        $pageRefBack = isset($json[$_GET['page']]) ? '<a href="?' . http_build_query($_GET) . '">&larr;Previous</a>' : '<a href="games.php">Main menu</a>';  //Setting back button if previous page exists
                    };
                    //going from arrays and variables to actual HTML
                    $_GET['page'] = $_GET['page'] + 2;
                    echo
                    '<div id="default-game" style="' . $background . '">' . 
                        '<div class="game">' .
                            $images .
                        '</div>' .
                        '<div class="game-talking" style="' . $talking . '">' .
                            '<img src="img/assets/dev/speech_bubble.png" alt="speech bubble" style="' . $arrow . '">' .
                            $item .
                        '</div>' .
                        '<div class="game-center">' .
                            '<p>' . $dialogue . '</p>' .
                            '<form method="post" action="?' . http_build_query($_GET) . '" class="game-button">' .
                                '<button>' . $pageRefBack . '</button>' .
                                $options .
                                '<button>' . $pageRef . '</button>' .
                            '</form>' .
                        '</div>' .
                    '</div>';
                    break;
            };
        }
        else
        {
            echo '<a href="games.php" class="warning"><br><br><br><br><br>Json level file does not exist! Click to go back</a>';
        };
    }
    else
    {
        echo '<a href="games.php" class="warning"><br><br><br><br><br>Level not set, click to go back</a>';
    };
?>