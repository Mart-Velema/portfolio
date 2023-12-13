<?php
/*
* Filename      : block-renderer.php
* Created       : 21-11-2023
* Description   : Block "rendering engine" 
* Programmer    : Mart Velema
*/
    $json = json_decode(file_get_contents('data/' . $id . '.json') , true);
    foreach($json as $name => $projects)
    {
        if(empty($projects['external']))
        {
            $projects['external'] = 'self';
        };
        $img = array_key_exists('img', $projects) ? '<img src="img/' . $projects['img'] . '.png" alt="' . $projects['img'] . '">' : '';
        $id = str_replace(' ', '-', $projects['name']);
        $title = isset($projects['link']) ? '<a href="' . $projects['link'] . '" target="_' . $projects['external'] . '"><h2>' . $projects['name']. '</h2></a>' : '<h2>' . $projects['name'] . '</h2>';
        echo
        '<div class="block" id=' . $id . '>' . 
            '' . $title . '' .
            '<div class="inner-block">' .
                '<p>' . $projects['content'] . '</p>' .
                '' . $img . '' .
            '</div>' .
        '</div>';
    };
?>