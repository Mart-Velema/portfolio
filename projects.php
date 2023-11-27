<?php
/*
* Filename      : projects.php
* Created       : 21-11-2023
* Description   : homepage for all NHL Stenden projects
* Programmer    : Mart Velema
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - Homepage</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <div class="content">
            <?php
                $id = "projects";
                include "components/block-renderer.php";
            ?>
        </div>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>