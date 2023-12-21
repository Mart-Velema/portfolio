<?php
/*
* Filename      : bug-report.php
* Assignment    : Bug reporter
* Created       : 13-12-2023
* comment       : Bug reporter
* Programmer    : Mart Velema
*/
//set data for database
include 'components/sql-login.php';
$dbname = 'bugReporter';
$submit='';
try
{
    //setting up DB Handler with PDO
    $dbHandler = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $log = 'connection succesful';
}
catch(Exception $ex)
{
    //error handling
    echo $ex;
    echo '<br>failed to connect, please contact system administrator';
};
//Setting up stmt with the data of the DB Handler with the querry to add something to the database
$stmt = isset($_GET['bug']) ? 
$dbHandler->prepare('UPDATE bugReports SET product=:product, `version`=:version, browser=:browser, OS=:OS, frequency=:frequency, comment=:comment WHERE id=' . $_GET['bug'] . ''):
$dbHandler->prepare('INSERT INTO bugReports (product, `version`, browser, OS, frequency, comment) VALUES(:product, :version, :browser, :OS, :frequency, :comment)');
//Form handling
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $product        = filter_input(INPUT_POST, 'product');
    $version        = strval(filter_input(INPUT_POST, 'version'));
    $browser        = filter_input(INPUT_POST, 'browser');
    $OS             = filter_input(INPUT_POST, 'OS');
    $frequency      = filter_input(INPUT_POST, 'frequency');
    $comment        = filter_input(INPUT_POST, 'comment');
    if(isset($product, $version, $browser, $OS, $frequency, $comment))
    {
        //Convert variables to SQL values
        $stmt->bindParam(':product', $product);
        $stmt->bindParam(':version', $version);
        $stmt->bindParam(':browser', $browser);
        $stmt->bindParam(':OS', $OS);
        $stmt->bindParam(':frequency', $frequency);
        $stmt->bindParam(':comment', $comment);
        //run the SQL querry
        $stmt->execute();
        $submit = TRUE;
    }
    else
    {
        $submit = FALSE;
    }
};
//select all the entries from the table bugReports and put it into the stmt variable
$stmt = $dbHandler->query('SELECT * FROM bugReports');
//convert the stmt variable into an associative array into the bugs variable
$bugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(isset($_GET['bug']))
{
    $stmt = $dbHandler->query('SELECT * FROM bugReports WHERE id=' . $_GET['bug'] . '');
    $currentBugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $content = $currentBugs[0];
}
else
{
    $content = [
        "version"   => "Version",
        "browser"   => "Browser",
        "OS"        => "OS",
        "comment"   => "Comment"
    ];
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Mart - bug reporter</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="img/fedora.png" rel="icon">
</head>
<body>
    <?php
        include "components/header.php";
    ?>
    <main>
        <form action="#" method="post">
            <h3>
                <?php
                    $title = isset($_GET['bug']) ? 'Update bug with id #' . $_GET['bug'] . '' : 'Submit new bug';
                    echo $title;
                ?>
            </h3>
            <?php
                echo
                '<label for="product">Product</label>' .
                '<select name="product" id="product" >' .
                    '<option value="SCUFF">SCUFF</option>' .
                    '<option value="FLOOR">FLOOR</option>' .
                    '<option value="other" selected>OTHER</option>' .
                '</select>' .
                '<label for="version">Version</label>' .
                '<input type="text" name="version" id="version" placeholder="' . $content['version'] . '">' .
                '<label for="browser">Browser</label>' .
                '<input type="text" name="browser" id="browser" placeholder="' . $content['browser'] . '">' .
                '<label for="OS">Operating system/ OS</label>' .
                '<input type="text" name="OS" id="OS" placeholder=' . $content['OS'] . '>' .
                '<label for="frequency">Frequency</label>' .
                '<select name="frequency" id="frequency">' .
                    '<option value="once" selected>Once/ Random</option>' .
                    '<option value="consistent">Consistent</option>' .
                '</select>' .
                '<label for="comment">comment</label>' .
                '<textarea name="comment" id="comment" maxlength="2048" placeholder="Describe issue in more detail">' . $content['comment'] . '</textarea>' .
                '<button type="submit">Submit bug</button>';
                //error handling in case submitting failed
                if($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    if($submit)
                    {
                        if(isset($stmt))
                        {
                            if($stmt->execute())
                            {
                                echo 'Succesfully submitted bugreport';
                            }
                            else
                            {
                                echo '<p class="warning">Failed to submit bug, please try again</p>';
                            };
                        }
                        else
                        {
                            echo '<p class="warning">Failed to connect to bugeport database, try again later</p>';
                        };
                    }
                    else
                    {
                        echo '<p class="warning">Error: One or more field was not filled in correctly!</p>';
                    };
                }
                else
                {
                    echo 'All fields are required to succefully submit a bug';
                };
            ?>
        </form>
        <div class="content">
            <table>
                <tr>
                    <th>id</th>
                    <th>product</th>
                    <th>version</th>
                    <th>browser</th>
                    <th>OS</th>
                    <th>frequency</th>
                    <th>comment</th>
                    <th>edit</th>
                </tr>
                <?php
                    //creating table out of the bugs associative array
                    foreach ($bugs as $id => $bug) 
                    {
                        ${$id} = $bug;
                        echo
                        '<tr>' .
                        '<td>' .$bug['id'] . '</td>'.
                        '<td>' .$bug['product'] . '</td>'.
                        '<td>' .$bug['version'] . '</td>'.
                        '<td>' .$bug['browser'] . '</td>'.
                        '<td>' .$bug['OS'] . '</td>'.
                        '<td>' .$bug['frequency'] . '</td>'.
                        '<td>' .$bug['comment'] . '</td>'.
                        '<td><a href="?bug=' . $bug['id'] . '">Edit</a></td>' .
                        '</tr>';
                    };
                ?>
            </table>
        </div>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>