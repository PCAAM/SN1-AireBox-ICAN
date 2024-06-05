<?php
$excel=$_POST['export']; 

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=listadoAireBox.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");

print $excel; 
exit;
 ?>