<?php
error_reporting(0);
header("Content-type: image/png");
$figure = $_GET['figure'];
$direction = $_GET['direction'];
$head = $_GET['head_direction'];
$gesture = $_GET['gesture'];
$action = $_GET['action'];
$size = $_GET['size'];
$look = imagecreatefrompng("http://www.habbohotel.es/habbo-imaging/avatarimage?figure=".$figure."&direction=".$direction."&head_direction=".$head."&gesture=".$gesture."&action=".$action."&size=".$size);
imagealphablending($look, false);
$white = imagecolorallocatealpha($look, 255, 255, 255, 127);
imagefilltoborder($look, 0, 0, $white, $white);
imagealphablending($look, true);
imagesavealpha($look, true);
imagepng($look);
imagedestroy($look);
?>