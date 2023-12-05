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
        </form>
        <?php
            var_dump($_FILES);
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if ($_FILES["bestand"]["error"] == 0)
                {
                    if($_FILES["bestand"]["size"] <= 3*1024*1024)
                    {
                        $fileInfo = finfo_file(FILEINFO_MIME_TYPE);
                        $acceptedFileTypes = ["image/png", "image/jpeg", "image/jpg", "image/gif"];
                        $uploadedFileType = finfo_file($fileInfo, $_FILES["bestand"]["tmp_name"]);
                        if(in_array($uploadedFileType, $acceptedFileTypes))
                        {
                            echo "werkt hier nog :)";
                        }
                        else
                        {
                            echo "File isn't a png, jpeg, jpg or gif";
                        };
                    }
                    else
                    {
                        echo "file too large";
                    }
                }
                else
                {
                    echo "Something went wrong...";
                };
            }
        ?>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>