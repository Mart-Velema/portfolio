<?php
/*
* Filename      : index.php
* Assignment    : homepage for portfolio
* Created       : 21-11-2023
* Description   : homepage/ indexpage for portfolio website
* Programmer    : Mart Velema
*/
if(!isset($_GET['newaccount']))
{
    $_GET['newaccount'] = FALSE;
};
include 'components/sql-login.php';
$dbname = 'accounts';

$warning = '';
try
{
    $dbHandler = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $log = 'connection succesful';
}
catch(Exception $ex)
{
    echo $ex;
    $warning = "Unable to connect to database";
};
try
{
    $stmt = $_GET['newaccount'] ? 
    $dbHandler->prepare('INSERT INTO account (accountname, email, `password`, pfp) VALUES(:name, :email, :passwd, :pfp)') : 
    $dbHandler->prepare('SELECT * FROM account WHERE accountname = :name');
}
catch (PDOException $e)
{
    echo $e->getMessage();
};
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if($_GET['newaccount'])
    { 
        $name   = filter_input(INPUT_POST, 'name');
        $email  = filter_input(INPUT_POST, 'email');
        $pfp    = $_FILES['pfp']['name'];
        $passwd = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_BCRYPT); //encrypt password
        //check if account name is already in use
        $check = $dbHandler->prepare("SELECT COUNT(*) FROM account WHERE accountname=:name");
        $check->bindParam(':name', $name);
        $check->execute();
        $check = $check->fetchColumn();
        //set pfp to default pfp if unset
        empty($pfp) ? $pfp = 'dev/missing_textures.png' : TRUE;
        //check if everything is filled in
        if(isset($name, $email, $passwd, $pfp))
        {
            if($check == 0)
            {
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':passwd', $passwd);
                $stmt->bindParam(':pfp', $pfp);
                $stmt->execute();
                //upload pfp
                $warning = 'Succesfully made account!';
                if($pfp !== 'dev/missing_textures.png')
                {
                    if($_FILES["pfp"]["error"] == 0)
                    {
                        if($_FILES["pfp"]["size"] <= 10*1024*1024)
                        {
                            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                            $acceptedFileTypes = ["image/png", "image/jpeg", "image/jpg"];
                            $uploadedFileType = finfo_file($fileInfo, $_FILES["pfp"]["tmp_name"]);
                            if(in_array($uploadedFileType, $acceptedFileTypes))
                            {
                                if(!file_exists('upload/' . $_FILES['pfp']['name'] . ''))
                                {
                                    if(move_uploaded_file($_FILES['pfp']['tmp_name'], 'upload/pfp/' . $_FILES['pfp']['name'] . ''))
                                    {
                                        $warning .= "<br>Succesfully uploaded profile picture!";
                                    }
                                    else
                                    {
                                        $warning = "Failed to upload file, please try again or contact administrator";
                                    };
                                }
                                else
                                {
                                    $warning = "Filename is already in use";
                                };
                            }
                            else
                            {
                                $warning = "File isn't a png, jpeg, jpg or gif";
                            };
                        }
                        else
                        {
                            $warning = "File needs to be below 10mb";
                        };
                    }
                    else
                    {
                        $warning = "Something went wrong...";
                    };
                };
            }
            else
            {
                $warning = 'Username is already in use';
            };
        }
        else
        {
            $warning = 'One or more fields is not filled in correctly';
        };
    }
    else
    {
        $name   = filter_input(INPUT_POST, "name");
        $passwd = filter_input(INPUT_POST, "password");
        if(isset($name, $passwd))
        {
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $user = $user[0];
            if(password_verify($passwd, $user['password']))
            {
                unset($user['password']);
                $_SESSION['user'] = $user;
                $warning = 'Logged in succesfully! Redirecting in 3 seconds...';
                header('refresh:3 url=index.php');
            }
            else
            {
                $warning = 'Invalid password!';
            };
        }
        else
        {
            $warning = 'One or more fields is not filled in correctly';
        };
    };
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=TRUE.0">
    <title>Portfolio Mart - login</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <form action="#" method="post" enctype="multipart/form-data">
            <?php
            if($_GET['newaccount'])
            {
                echo
                '<label for="name">Name</label>' .
                '<input type="text" name="name" id="name" placeholder="name">' .
                '<label for="email">Email</label>' .
                '<input type="email" name="email" id="email" placeholder="example@email.com">' .
                '<label for="password">Password</label>' .
                '<input type="password" name="password" id="password">' .
                '<label for="pfp">Profile-picture</label>' .
                '<input type="file" name="pfp" id="pfp">';
                $_GET['newaccount'] = FALSE;
                $button = 'create new account';
                $message = 'Login instead';
            }
            else
            {
                echo
                '<label for="name">Name</label>' .
                '<input type="text" name="name" id="name" placeholder="name">' .
                '<label for="password">password</label>' .
                '<input type="password" name="password" id="password">';
                $_GET['newaccount'] = TRUE;
                $button = 'login';
                $message = 'Create new account';
            };
            echo
            '<div>' .
            '<button type="submit">' . $button . '</button> ' .
            '<a href="?' . http_build_query($_GET) . '">' . $message . '</a>' .
            '<p class="warning">' . $warning . '</p>' .
            '</div>';
            ?>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>