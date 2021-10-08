<?php
$file='myfile.html';
  
if (($file != "") && (file_exists("php/files/" . basename($file))))
{
$size = filesize("php/files/" . basename($file));
header("Content-Type: application/force-download; name=\"" . basename($file) . "\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $size");
header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
header("Expires: 0");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
readfile("php/files/" . basename($file));
exit();
}
?>