<?php 

$file = dirname(__FILE__).'/fake_image.gif';
$size = @getimagesize($file);

if (
    (isset($size[0]) === true && $size[0] > 0)
    && (isset($size[1]) === true && $size[1] > 0)
    && (isset($size[2]) === true && $size[2] === IMAGETYPE_GIF)
) {
    //GIFファイルなら、画像の情報を表示
    var_export($size);
}
?>
