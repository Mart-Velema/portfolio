<?php
/*
* Filename      : bug-report.php
* Assignment    : Bug reporter
* Created       : 13-12-2023
* comment   : Bug reporter
* Programmer    : Mart Velema
*/

$servername = 'mysql';
$dbname = 'bugReporter';
$username = 'root';
$password = 'qwerty';

try
{
    $dbHandler = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    echo 'Connection succesful';
}
catch(Exception $ex)
{
    echo $ex;
    echo '<br>failed to connect';
};
$stmt = $dbHandler->prepare('INSERT INTO bugReports (product, `version`, browser, OS, frequency, comment) VALUES(:product, :version, :browser, :OS, :frequency, :comment)');
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $product        = filter_input(INPUT_POST, 'product');
    $version        = strval(filter_input(INPUT_POST, 'version'));
    $browser        = filter_input(INPUT_POST, 'browser');
    $OS             = filter_input(INPUT_POST, 'OS');
    $frequency      = filter_input(INPUT_POST, 'frequency');
    $comment        = filter_input(INPUT_POST, 'comment');
    $stmt->bindParam(':product', $product);
    $stmt->bindParam(':version', $version);
    $stmt->bindParam(':browser', $browser);
    $stmt->bindParam(':OS', $OS);
    $stmt->bindParam(':frequency', $frequency);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();
};
$stmt = $dbHandler->query('SELECT * FROM bugReports');
$bugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <label for="product">Product</label>
            <select name="product" id="product">
                <option value="SCUFF">SCUFF</option>
                <option value="FLOOR">FLOOR</option>
                <option value="other" selected>OTHER</option>
            </select>
            <label for="version">Version</label>
            <input type="text" name="version" id="version">
            <label for="browser">Browser</label>
            <input type="text" name="browser" id="browser">
            <label for="OS">Operating system/ OS</label>
            <input type="text" name="OS" id="OS">
            <label for="frequency">Frequency</label>
            <select name="frequency" id="frequency">
                <option value="once" selected>Once/ Random</option>
                <option value="consistent">Consistent</option>
            </select>
            <label for="comment">comment</label>
            <textarea name="comment" id="comment" maxlength="2048" placeholder="Describe issue in more detail"></textarea>
            <button type="submit">Submit bug</button>
            <?php
                if(isset($stmt))
                {
                    if($stmt->execute())
                    {
                        echo 'Succesfully submitted bugreport';
                    }
                    else
                    {
                        echo '<p class="error">Failed to submit bug, please try again</p>';
                    };
                }
                else
                {
                    echo '<p class="error">Failed to connect to bugeport database, try again later</p>';
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
                </tr>
                <?php
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
                        '</tr>';
                    }
                ?>
            </table>
        </div>
    </main>
    <?php
        include "components/footer.php";
    ?>
</body>
</html>