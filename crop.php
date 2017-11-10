<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_FILES) || !isset($_POST)) {
    header("Location: index.php");
}

include __DIR__ . '/vendor/autoload.php';

use Gregwar\Image\Image;

$tmp_name = $_FILES['img']['tmp_name'];
$extensao = $_FILES['img']['type'];
$y = $_POST['y'];
$x = $_POST['x'];
$w = $_POST['w'];
$h = $_POST['h'];



switch ($extensao) {
    case "image/jpg":
        $newName = md5(microtime()) . ".jpg";
        $ext = "jpg";
        break;
    case "image/png":
        $newName = md5(microtime()) . ".png";
        $ext = "png";
        break;
    case "image/jpeg":
        $newName = md5(microtime()) . ".jpeg";
        $ext = "jpeg";
        break;
    default:
        echo "erro";
}


$filename = sprintf('%s/croped/%s', __DIR__, $newName);

$imgCortada = Image::open($tmp_name)->crop($x, $y, $w, $h);
$imgCortada->save($filename, $ext);

$_SESSION['imagemTemp'] = $newName;

echo $newName;
