<?php
//export Microsoft Excel file from PHP 
// it is all about header 
// data can be provided in simple HTML table row/columns.

header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel;charset:UTF-8");
header("Content-Disposition: attachment; filename=filename.xls"); 
print "\n"; // Add a line, unless excel error..
?>
<table border="1">
<tr>
<th>header 1</th>
<th>header 2</th>
</tr>
<tr>
<td>data 1</td>
<td>data 2 - nordic letters æ, æ, å</td>
</tr>
</table>