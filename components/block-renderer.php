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
        if(isset($projects['img']))
        {
            $img = '<img src="img/' . $projects['img'] . '" alt="' . $projects['img'] . '">';
        }
        else
        {
            $img = '';
        };
        $title = '<h2>' . $projects['name'] . '</h2>';
        $id = str_replace(' ', '-', $projects['name']);
        if(isset($projects['link']))
        {
            $title = '<a href="' . $projects['link'] . '" target="' . $projects['external'] . '">' . $title . '</a>';
        };
        echo
        '<div class="block" id=' . $id . '>' . 
            '' . $title . '' .
            '<div class="inner-block">' .
                '<p>' . $projects['text'] . '</p>' .
                '' . $img . '' .
            '</div>' .
        '</div>';
    };
?>