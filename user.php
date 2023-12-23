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
$warning = '';
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
        'color'         => 'var(--primary-colour)',
        'secondary'     => 'var(--secondary-colour)',
        'text'          => 'var(--text-colour)'
    ];
}
else
{
    $user = $user[0];
    if($user['level'] == 0)
    {
        $user['bio']        = 'Hello, World!';
        $user['color']      = 'red';
        $user['secondary']  = 'green';
        $user['text']       = 'blue';
        $note = 'Legacy account will soon no longer be supported, make sure to set up your account before 1-2-2024';
    };
};
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $user['color']      = filter_input(INPUT_POST, 'primary');
    $user['secondary']  = filter_input(INPUT_POST, 'secondary');
    $user['text']       = filter_input(INPUT_POST, 'text');
    $user['bio']        = filter_input(INPUT_POST, 'bio');
    $passwd             = filter_input(INPUT_POST, 'password');
    if($_POST['submit'] == 'done')
    {
        if(!empty($passwd))
        {
            if(password_verify($passwd, $_SESSION['user']['password']))
            {
                try
                {
                    $stmt = $dbHandler->prepare("UPDATE account SET bio=:bio, color=:color, secondary=:secondary, text=:text WHERE accountname=:name");
                    $stmt->bindParam(':name', $_SESSION['user']['accountname']);
                    $stmt->bindParam(':bio', $user['bio']);
                    $stmt->bindParam(':color', $user['color']);
                    $stmt->bindParam(':secondary', $user['secondary']);
                    $stmt->bindParam(':text', $user['text']);
                    $stmt->execute();
                    $log .= 'sucesfully updated entry';
                    $warning = 'Succesfully saved profile!';
                }
                catch(Exception $Ex)
                {
                    echo $Ex;
                    $log .= 'Unable to update entry';
                };
            }
            else
            {
                $log .='invalid password';
                $warning = 'Invalid password';
            };
        }
        else
        {
            $log .='unset password';
            $warning = 'Unset password!';
        };
    };
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
            '--account-primary: ' . $user['color'] . ';' .
            '--account-secondary:' . $user['secondary'] . ';' .
            '--account-text: ' . $user['text'] . ';';
        ?>
        }
    </style>
</head>
<body>
    <?php
        include "components/header.php";
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
                        '<input type="color" name="primary" id="primary" value="' . $user['color'] . '">' .
                        '<label for="secondary">Secondary colour</label>' .
                        '<input type="color" name="secondary" id="secondary" value="' . $user['secondary'] . '">' .
                        '<label for="text">Text colour</label>' .
                        '<input type="color" name="text" id="text" value="' . $user['text'] . '">' .
                        '<label for="bio">Biopgrahpy</label>' .
                        '<textarea name="bio" maxlenght="512">' . $user['bio'] . '</textarea>' .
                        '<button type="submit" name="submit" value="test">Check it out!</button>' .
                        '<label for="password">Enter password to update</label>' .
                        '<input type="password" name="password" id="password">' .
                        '<button type="submit" name="submit" value="done">Apply</button>'  .
                        '<p class="warning">' . $warning . '</p>' .
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
                        '<p class="level">This is where your bages will be displayed</p>';
                        if(($_SESSION['user']['accountname'] ?? NULL) == $user['accountname'])
                        {
                            echo '<a href="user.php?user=' . $user['accountname'] . '&edit=1" class="level" style="opacity: 0.9;">Edit profile</a>';
                        };
                        if(!empty($note))
                        {
                            echo '<p class="warning">' . $note . '</p>';
                        };
                    ?>
                </div>
            </div>
            <div class="list">

            </div>
        </div>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>