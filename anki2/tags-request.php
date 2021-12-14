<?php
require('classes/Tag.php');

$tags = new Tag();
$tag = $tags->search($_POST['id']);

echo json_encode($tag);

 ?>
