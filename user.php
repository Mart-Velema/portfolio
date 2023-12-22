<?php
/*
* Filename      :
* Assignment    :
* Created       :
* Description   :
* Programmer    : Mart Velema
*/
include "components/sql-login.php";
$dbname = 'accounts';
$log = '';
try
{
    $dbHandler = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $log .= 'succesfully connected to database.';
}
catch(Exception $Ex)
{
    echo $Ex;
    $log .= 'unable to connect to database.';
};
$stmt = $dbHandler->prepare("SELECT * FROM account WHERE accountname=:name");
try
{
    $stmt->bindParam(':name', $_GET['user']);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $log .= 'succesfully fetched user data.';
}
catch(Exception $Ex)
{
    echo $Ex;
    $log .= 'Unable to find username.';
};
if(empty($user))
{
    $user = [
        'accountname'   => '<p class="warning">ERROR, Invalid user!</p>',
        'pfp'           => 'dev/missing_textures.png',
        'bio'           => 'This user does not exists in the database. Would you perhaps like to <a href="login.php">create an account?</a>',
        'level'         => NAN,
        'primary'       => 'var(--primary-colour)',
        'secondary'     => 'var(--secondary-colour)',
        'text'          => 'var(--text-colour)'
    ];
}
else
{
    $user = $user[0];
    $bios = [
        'This user exists',
        'This person definetly uses the internet',
        'This is the average SCUFF enjoyer',
        'This is the average Source Enthusiast',
        'This is the average Unreal consumer'
    ];
    $user['bio'] = $bios[array_rand($bios)];
    $user['level'] = 1;
    $user['primary'] = 'red';
    $user['secondary'] = 'green';
    $user['text'] = 'blue';
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=TRUE.0">
    <title>Portfolio Mart - user</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
    <style>
        * {
        <?php
            echo
            '--account-primary: ' . $user['primary'] . ';' .
            '--account-secondary:' . $user['secondary'] . ';' .
            '--account-text: ' . $user['text'] . ';';
        ?>
        }
    </style>
</head>
<body>
    <?php
        include "components/header.php"
    ?>
    <main>
        <?php
            if(($_GET['edit'] ?? FALSE))
            {
                if(($_SESSION['user']['accountname'] ?? NULL) == $user['accountname'])
                {
                    echo
                    '<form action="?' . http_build_query($_GET) . '" method="post" class="settings">' .
                        '<label for="primary">Primary colour</label>' .
                        '<input type="color" name="primary" id="primary">' .
                        '<label for="secondary">Secondary colour</label>' .
                        '<input type="color" name="secondary" id="secondary">' .
                        '<label for="text">Text colour</label>' .
                        '<input type="color" name="text" id="text">' .
                        '<button type="submit">Check it out!</button>' .
                    '</form>';
                }
                else
                {
                    echo '<p class="warning">Error! You do not have permission to edit this account!</p>';
                };
            };
        ?>
        <div class="account">
            <div class="banner">
                <?php
                    echo '<img src="upload/pfp/' . $user['pfp'] . '" alt="' . $user['pfp'] . '">';
                ?>
                <div class="bio">
                    <?php
                        echo
                        '<h2>' . $user['accountname'] . '</h2>' .
                        '<p>' . $user['bio'] . '</p>';
                    ?>
                </div>
                <div class="about">
                    <?php
                        echo 
                        '<p class="level">Level: #' . $user['level'] . '</p>' . 
                        '<p class="level">This is where your bages will be displayed for everyone to envy about</p>';
                        if(($_SESSION['user']['accountname'] ?? NULL) == $user['accountname'])
                        {
                            echo '<a href="user.php?user=' . $user['accountname'] . '&edit=1" class="level" style="opacity: 0.9;">Edit profile</a>';
                        };
                    ?>
                </div>
            </div>
            <div class="list">

            </div>
        </div>
    </main>
    <?php
        include "components/footer.php"
    ?>
</body>
</html>