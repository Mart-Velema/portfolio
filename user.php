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
try
{
    $dbHandler = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $log = 'succesfully connected to database';
}
catch(Exception $Ex)
{
    echo $Ex;
    $log = 'unable to connect to database';
};
$stmt = $dbHandler->prepare("SELECT * FROM account WHERE accountname=:name");
$stmt->bindParam(':name', $_GET['user']);
$stmt->execute();
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user = $user[0];
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
            $accountBackground  = 'black';
            $accountPfp         = 'purple';
            echo
            '--account-background: black;' .
            '--account-pfp: purple;';
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
                    echo '<img src="upload/pfp/' . $user['pfp'] . '" alt="' . $user['pfp'] . '">'
                ?>
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