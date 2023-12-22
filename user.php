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
            $accountPrimary     = 'red';
            $accountSecondary   = 'green';
            $accountText        = 'blue';
            echo
            '--account-primary: ' . $accountPrimary . ';' .
            '--account-secondary:' . $accountSecondary . ';' .
            '--account-text: ' . $accountText . ';';
        ?>
        }
    </style>
</head>
<body>
    <?php
        include "components/header.php"
    ?>
    <main>
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
                        '<p class="level">Level: #' . $user['level'] . '</p>';
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