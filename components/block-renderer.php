<?php
    $json = file_get_contents("data/" . $id . ".json");
    $json = json_decode($json, true);
    foreach($json as $data => $projects)
    {
        $projects['name'] = str_replace(' ', '-', $projects['name']);
        if(empty($projects['external']))
        {
            $projects['external'] = "target='_self'";
        };
        echo    "<div id='" . $projects['name'] ."' class='block'>
                    <a href='" . $projects['link'] . "'" . $projects['external'] . "><h2>" . $projects['name'] . "</h2></a>
                    <div class='inner-block'>
                        <p>" . $projects['text'] . "</p>";
        if(isset($projects['img']))
        {
           echo "<img src='img/" . $projects['img'] . "' alt='" . $projects['img'] . "'>"; 
        }
        echo        "</div>
                </div>";
    };
    // var_dump($id, $json, $projects);
?>