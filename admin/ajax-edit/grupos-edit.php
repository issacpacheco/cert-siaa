<?php
include('../class/allClass.php');

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
?>

<div>
    <h1>Hola mundo con ID <?php echo $id ?></h1>
</div>