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
                $id = "php";
                include "components/block-renderer.php";
            ?>
        </div>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>