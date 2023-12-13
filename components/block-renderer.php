<?php
/*
* Filename      : block-renderer.php
* Created       : 21-11-2023
* Description   : Block "rendering engine" 
* Programmer    : Mart Velema
*/
    //ID needs to be set on the page block is used on. Else, return an error
    if(isset($id))
    {
        if(file_exists('data/' . $id . '.json'))
        {
            $json = json_decode(file_get_contents('data/' . $id . '.json') , true);
            foreach($json as $name => $projects)
            {
                //setting varibables from the .json file
                $target = array_key_exists('external', $projects) ? $projects['external'] : 'self';
                $title = array_key_exists('link', $projects) ? '<a href="' . $projects['link'] . '" target="_' . $target . '"><h2>' . $projects['name']. '</h2></a>' : '<h2>' . $projects['name'] . '</h2>';
                $img = array_key_exists('img', $projects) ? '<img src="img/' . $projects['img'] . '.png" alt="' . $projects['img'] . '">' : '';
                $id = str_replace(' ', '-', $projects['name']);
                echo
                '<div class="block" id=' . $id . '>' . 
                    '' . $title . '' .
                    '<div class="inner-block">' .
                        '<p>' . $projects['content'] . '</p>' .
                        '' . $img . '' .
                    '</div>' .
                '</div>';
            };
        }
        else
        {
            echo '<p class="warning">Json file does not exist!</p>';
        };
    }
    else
    {
        echo '<p class="warning">ID not set up correctly</p>';
    };
?>