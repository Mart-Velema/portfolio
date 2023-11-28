<?php
/*
* Filename      : block-renderer.php
* Created       : 21-11-2023
* Description   : Block "rendering engine" 
* Programmer    : Mart Velema
*/
    $json = file_get_contents("data/" . $id . ".json");
    $json = json_decode($json, true);
    foreach($json as $data => $projects)
    {
        $projects['id'] = str_replace(' ', '-', $projects['name']);
        if(isset($projects['img']))
        {
            $projects['img'] = "<img src='img/" . $projects['img'] . "' alt='" . $projects['img'] . "'>"; 
        }
        else
        {
            $projects['img'] = "";
        };
        if(empty($projects['external']))
        {
            $projects['external'] = "target=_self'";
        };
        echo
        '<div class="block" id=' . $projects['id'] . '>' . 
            '<a href=' . $projects['link'] . ' ' . $projects['external'] . '><h2>' . $projects['name'] . '</h2></a>' .
            '<div class="inner-block">' .
                '<p>' . $projects['text'] . '</p>' .
                '' . $projects['img'] . '' .
            '</div>' .
        '</div>';
    };
?>