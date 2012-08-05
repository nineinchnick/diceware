<?php
$chars = '[["&","+"],["$","^"]]';
$data = json_decode($chars);
echo $data[1][0]."\n";
?>
