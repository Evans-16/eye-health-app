<?php
     if (isset($_POST['submit_address']))
     {
        $address = $_POST["address"];
        ?>
        <iframe width="100%" height="500" src="https://maps.google.com/maps?q=<?php echo $address; ?>&output=embed" frameborder="0"></iframe>
        <?php
     }


?>


<form method="post">
    <p>
        <input type="text" name="address" placeholder="Enter address">
    </p>

    <input type="submit" name="submit_address">
</form>