<?php
/*
* Filename      : SCUFF.php
* Created       : 22-11-2023
* Description   : SCUFF Engine for personal game project
* Programmer    : Mart Velema
*/
//NOTE: SCUFF asssumes ALL images are in the .png format. Using any other format WILL NOT function.
function levelDecode($json)
{
    //init
    $dir          = $json[0]['dir'];  
    $background   = '';
    $images       = '';
    $talking      = '';
    $item         = '';
    $dialogue     = '';
    $next         = 'Next';
    $jump         = '';
    $options      = '';
    $moves        = '';
    //check if the json entry that corresponds with the page exists
    if(isset($json[$_GET['page']])) 
    {
        foreach($json[$_GET['page']] as $name => $contents)
        {   
            ${$name} = $contents;
            switch($name)   
            {   //decodes the data from the decoded .json into something that can be used in HTML
                //image decoder
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
                //item decoder
                case "item":                                                            //Set the image for item
                    $item = '<img src="img/assets/' . $dir . '/' . $item . '.png" alt="' . $item . '" class="item">';
                    break;
                //background decoder
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
                //action decoder
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
                                            if(!array_key_exists('marker', $_GET))
                                            {
                                                $_GET['marker'] = 0;
                                            };
                                            $jump = $_GET;
                                            $jump['page'] = $action == 0 ? $jump['marker'] : $action;
                                            $jump = http_build_query($jump);
                                            $next = 'jump';
                                            break;
                                    };
                                };
                                break;
                        };
                    };
                    break;
                // moves decoder, this will overwrite previously obtained move
                case "moves" :
                    /*
                    $moves = 
                    [
                        [
                            1 =>
                            [
                                'name' => 'Test',
                                'description => 'Hello, World!'
                            ]
                        ],
                    ]
                    */
                    break;
            };
        };
    }
    else
    {   //error handling in case empty json
        $images = '<img src="img/assets/dev/missing_textures.png">';
        $dialogue = 'ERROR: Missing JSON entry, redirecting to fallback page';
        $background = 'background-image: url(img/assets/dev/missing_textures.png)';
    };
    //packages all the variables into an array to be outputted by the function
    $levelDecode['background']  = $background;
    $levelDecode['images']      = $images;
    $levelDecode['talking']     = $talking;
    $levelDecode['item']        = $item;
    $levelDecode['dialogue']    = $dialogue;
    $levelDecode['next']        = $next;
    $levelDecode['jump']        = $jump;
    $levelDecode['options']     = $options;
    $levelDecode['moves']       = $moves;
    return $levelDecode;
};

    if(isset($_GET['level']))
    {
        if(file_exists('data/games/' . $_GET['level'] . '.json'))
        {
            //decoding .json into something useable
            $json = json_decode(file_get_contents("data/games/" . $_GET['level'] . ".json"), true); //import .json file and decode it into an array
            $dir = $json[0]['dir'];  
            switch ($_GET['scene'])
            {
                case 'battle' :
                    //temporary array, this will be moved sometime soon &tm;
                    $moves =
                    [
                        [
                            1 =>
                            [
                                'name' => 'LOCATE & FETCH',
                                'description' => 'Locates an object, location or subject related to the specific spellcasting class. This will tell the spellcaster where such point of interest is located, and moves the point of interest towards the spellcaster by physically moving the point of interest.'
                            ],
                            2 =>
                            [
                                'name' => 'SPAWN',
                                'description' => 'Creates an entity related to the spellcast in question. This will be a standard size entity that will fizzle out if left unattended.'
                            ]
                        ],
                        [
                            1 =>
                            [
                                'name' => 'MOVE',
                                'description' => ' moves entities spawned by the spellcaster. '
                            ],
                            2 =>
                            [
                                'name' => 'SIZE ADJUST',
                                'description' => 'SIZE-ADJUST changes the physical size of a spawned entity.'
                            ],
                            3 =>
                            [
                                'name' => 'SHAPE',
                                'description' => 'contains several sub-events that determine the physical form of a spawned entity. These shapes can be either 2D or 3D, with 3D shapes taking considerably more mental capacity to keep stable.'
                            ],
                            4 =>
                            [
                                'name' => 'ATTATCH',
                                'description' => 'ATTACH mounts a spawned entity to an object. The entity will now move with the object as if it was glued to it.'
                            ]
                
                        ]
                    ];
                    $levelDecode    = levelDecode($json);  //running the levelDecode funtion
                    $moveCards      = '';
                    $stage = count($_GET) - 4;
                    if(count($moves) > $stage)
                    {
                        foreach($_GET as $key => $value)
                        {
                            //creating hidden cards that are used to move the values along to the next page
                            $moveCards .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
                        };
                        for ($i=1; $i <= count($moves[$stage]) && $i <= 5; $i++) 
                        {
                            //creating the cards
                            $moveCards .=
                            '<button type="submit" name="move' . count($_GET) . '" value="' . $moves[$stage][$i]['name'] .'" class=game-card id="card-' . $i . '">'.
                                '<h2>' . $moves[$stage][$i]['name'] . '</h2>' . 
                                '<p>' . $moves[$stage][$i]['description'] . '</p>' .
                            '</button>';
                        };
                    }
                    else
                    {
                        //execute the instruction, currently just throws an error
                        $moveCards = '<a href="games.php" class="warning">Ecountered unrecoverable error, click to back to the main menu</a>';
                    };
                    //Going from PHP variables to HTML
                    echo
                    '<div id="combat-game" style="' . $levelDecode['background'] . '">' . 
                        '<div class="game">' .
                            $levelDecode['images'] .
                        '</div>' .
                        '<div class="game-center">' .
                            '<div class="stats">' .
                            
                            '</div>' .
                            '<form method="get">' .
                                $moveCards .
                            '</form>' .
                            '<div class="stats">' .
                                
                            '</div>' .
                        '</div>' .
                    '</div>';
                    break;
                default:
                    $levelDecode    = levelDecode($json);  //running the levelDecode funtion
                    if(isset($levelDecode['talking']))     //if the talking tag exists, run this
                    {
                        switch($levelDecode['talking'])
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
                    if(empty($json[($_GET['page'] + 1)]))
                    {
                        $_GET['page']--;
                        $pageRefBack = '<a href="?' . http_build_query($_GET) . '">&larr;Previous</a>';
                        $pageRef = isset($levelDecode['jump']) ? $levelDecode['next'] . '&rarr;' : '<a href="games.php">Homepage</a>';
                    }
                    else
                    {   
                        //Make both the previous and next page button if next json entry is not empty
                        $pageRef = !empty($levelDecode['jump']) ? '<button><a href="?' . $levelDecode['jump'] . '">' . $levelDecode['next'] . '</a></button>' : '<button>' . $levelDecode['next'] . '&rarr;</button>';   //If jump is set, make button to go to jump page, if not, use default next button
                        if(!empty($levelDecode['options']))
                        {
                            $pageRef = '';
                        };
                        $_GET['page']--;
                        $pageRefBack = isset($json[$_GET['page']]) ? '<a href="?' . http_build_query($_GET) . '">&larr;Previous</a>' : '<a href="games.php">Main menu</a>';  //Setting back button if previous page exists
                    };
                    //going from arrays and variables to actual HTML
                    $_GET['page'] = $_GET['page'] + 2;
                    echo
                    '<div id="default-game" style="' . $levelDecode['background'] . '">' . 
                        '<div class="game">' .
                            $levelDecode['images'] .
                        '</div>' .
                        '<div class="game-talking" style="' . $talking . '">' .
                            '<img src="img/assets/dev/speech_bubble.png" alt="speech bubble" style="' . $arrow . '">' .
                            $levelDecode['item'] .
                        '</div>' .
                        '<div class="game-center">' .
                            '<p>' . $levelDecode['dialogue'] . '</p>' .
                            '<form method="post" action="?' . http_build_query($_GET) . '" class="game-button">' .
                                '<button>' . $pageRefBack . '</button>' .
                                    $levelDecode['options'] .
                                $pageRef .
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