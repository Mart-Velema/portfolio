<?php
/*
* Filename      : file-upload.php
* Assignment    : File upload
* Created       : 6-12-2023
* Description   : File upload page
* Programmer    : Mart Velema
*/
include 'components/sql-login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - File-upload</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
<?php
        include "components/header.php";
    ?>
    <main>
        <form action="file-upload.php" method="post" enctype="multipart/form-data">
            <label for="bestand">selecteer bestand</label>
            <input type="file" name="bestand" id="bestand">
            <button type="submit">Upload!</button>
        <?php
            // var_dump($_FILES);
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if ($_FILES["bestand"]["error"] == 0)
                {
                    if(preg_match("/[A-Z]/", $_FILES['bestand']['name']))
                    {
                        if($_FILES["bestand"]["size"] <= 3*1024*1024)
                        {
                            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                            $acceptedFileTypes = ["image/png", "image/jpeg", "image/jpg", "image/gif"];
                            $uploadedFileType = finfo_file($fileInfo, $_FILES["bestand"]["tmp_name"]);
                            if(in_array($uploadedFileType, $acceptedFileTypes))
                            {
                                if(!file_exists('upload/' . $_FILES['bestand']['name'] . ''))
                                {
                                    if(move_uploaded_file($_FILES['bestand']['tmp_name'], 'upload/' . $_FILES['bestand']['name'] . ''))
                                    {
                                        echo "Succesfully uploaded file!";
                                    }
                                    else
                                    {
                                        echo "Failed to upload file, please try again or contact administrator";
                                    };
                                }
                                else
                                {
                                    echo "Filename is already in use";
                                };
                            }
                            else
                            {
                                echo "File isn't a png, jpeg, jpg or gif";
                            };
                        }
                        else
                        {
                            echo "File too large";
                        }
                    }
                    else
                    {
                        echo "Filename needs to contain at least one capital letter";
                    };
                }
                else
                {
                    echo "Something went wrong...";
                };
            };
            $dir = 'upload';
            $dirOpen = opendir($dir);
            while ($curFile = readdir($dirOpen))
            {
                if($curFile != "." && $curFile != ".." && $curFile != 'pfp')
                {
                    // var_dump($curFile);
                    echo $curFile . "<br>";
                    echo "<img src='". $dir . "/" .$curFile . "' alt='" . $curFile . "'><br><br>";
                };
            };
            closedir($dirOpen);
        ?>
        </form>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>