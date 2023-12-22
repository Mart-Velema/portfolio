<?php
/*
* Filename      : header.php
* Created       : 21-11-2023
* Description   : Header for portfolio website
* Programmer    : Mart Velema
*/
?>
<header>
    <a href="index.php"><img src="img/fedora.png" alt="Fedora Logo"></a>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="php-opdrachten.php">PHP Opdrachten</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="projects.php">Projecten</a></li>
    </ul>
    <div class="login">
        <?php
            if(isset($_SESSION['user']))
            {
                echo 
                '<a href="user.php"><img src="upload/pfp/' . $_SESSION['user']['pfp'] . '" alt="' . $_SESSION['user']['pfp'] . '"></a>' . 
                '<a href="user.php">' . $_SESSION['user']['accountname'] . '</a>';
            }
            else
            {
                echo '<a href="login.php">login</a>';
            };
        ?>
    </div>
</header>