<?php
/*
* Filename      : user.php
* Assignment    : login pagina
* Created       : 22-12-2023
* Description   : user page for portfolio
* Programmer    : Mart Velema
*/
include "components/sql-login.php";
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
//either fetch one user, or all users depending on if a user is specified in the url
if(array_key_exists('user', $_GET))
{
    try
    {
        if(filter_var($user = (int)$_GET['user'], FILTER_VALIDATE_INT))
        {
            $stmt = $dbHandler->prepare("SELECT * FROM account WHERE id=:id");
            $stmt->bindParam(':id', $user, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $log .= 'succesfully fetched user data.';
            $list = FALSE;
        };
    }
    catch(Exception $Ex)
    {
        echo $Ex;
        $log .= 'Unable to find username.';
    };
    if(!empty($user))
    {
        $user = $user[0];
        $user['pfp'] = str_replace(' ', '_', $user['accountname']);
    };
}
else
{
    $limit = isset($_GET['limit']) && $_GET['limit'] != 0 ? $_GET['limit'] : 30;
    try
    {
        if(filter_var($limit = (int)$limit, FILTER_VALIDATE_INT))
        {
            $stmt = $dbHandler->prepare("SELECT * FROM account ORDER BY RAND() LIMIT :limit");
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $log .= 'succesfully fetched users data.';
            $list = TRUE;
        };
    }
    catch(Exception $Ex)
    {
        echo $Ex;
        $log .= 'Unable to find users.';
    };
};
//go to default page when the user does not exists
if(empty($user))
{
    //There must be a smarter way, but if the user does not exists, then just go to the 'list' page.. when that is done...
    sleep(10);
    header('location:user.php');
};
//update profile
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $user['color']      = filter_input(INPUT_POST, 'primary');
    $user['secondary']  = filter_input(INPUT_POST, 'secondary');
    $user['text']       = filter_input(INPUT_POST, 'text');
    $user['bio']        = htmlspecialchars(filter_input(INPUT_POST, 'bio'));
    $passwd             = filter_input(INPUT_POST, 'password');
    if($_POST['submit'] == 'done')
    {
        if(!empty($passwd))
        {
            if(password_verify($passwd, $_SESSION['user']['password']))
            {
                try
                {
                    $stmt = $dbHandler->prepare(
                        "UPDATE account 
                        SET level=:level, bio=:bio, color=:color, secondary=:secondary, text=:text 
                        WHERE accountname=:name
                    ");
                    $stmt->bindParam(':name', $_SESSION['user']['accountname']);
                    $stmt->bindParam(':bio', $user['bio']);
                    $stmt->bindParam(':color', $user['color']);
                    $stmt->bindParam(':secondary', $user['secondary']);
                    $stmt->bindParam(':text', $user['text']);
                    $stmt->bindParam(':level', $user['level']);
                    $stmt->execute();
                    $log .= 'sucesfully updated entry';
                    $warning = 'Succesfully saved profile!';
                    header('refresh:3 url=user.php?user=' . $user['accountname']);
                }
                catch(Exception $Ex)
                {
                    echo $Ex;
                    $log .= 'Unable to update entry';
                };
            }
            else
            {
                $warning = 'Invalid password';
            };
        }
        else
        {
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
            if(!$list)
            {
                echo
                '--account-primary: ' . $user['color'] . ';' .
                '--account-secondary:' . $user['secondary'] . ';' .
                '--account-text: ' . $user['text'] . ';';
            }
            else
            {
                echo
                '--account-primary: var(--primary-colour);';
            };
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
        <?php if(array_key_exists('user', $_GET)): ?>
        <div id="single">
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
                            echo 
                            '<a href="user.php?user=' . $user['accountname'] . '&edit=1"><button>Edit profile</button></a>' .
                            '<a href="logout.php"><button>Logout</button></a>';
                        };
                    ?>
                </div>
            </div>
            <div class="list">

            </div>
        </div>
        <?php else: ?>
        <div id="list">
            <?php
                foreach($user as $data)
                {
                    $data['pfp'] = str_replace(' ', '_', $data['accountname']);
                    echo
                    '<div class="user" style="background-color:' . $data['color'] . ';">' .
                        '<a href="?user=' . $data['id'] . '" style="background-color:' . $data['secondary'] . '; color:' . $data['text'] . '">' .
                            '<img src="upload/pfp/' . $data['pfp'] . '" alt="' . $data['pfp'] . '">' .
                            '<h2>' . $data['accountname'] . '</h2>' .
                        '</a>' .
                    '</div>';
                };
            ?>
        </div>
        <?php endif; ?>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>