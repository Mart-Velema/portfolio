<?php
/*
* Filename      : footer.php
* Created       : 21-11-2023
* Description   : Footer for portfolio website
* Programmer    : Mart Velema
*/
?>
<footer>
    <?php
        echo "&copy; 1970 - " . date('Y') . "  Mart Velema"
    ?>
    <form action="succes.php" method="post">
        <label for="niewsbrief">Nieuwsbrief</label>
        <input type="text" name="niewsbrief" id="niewsbrief" required>
        <button type="submit">Submit</button>
    </form>
</footer>