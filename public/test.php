<?php
$conn = oci_connect('KULPROD', 'kulWasTheLast111', '192.168.63.82:1521/KULPRD01', 'AL32UTF8');
if (!$conn) {
$m = oci_error();
echo $m['message']. PHP_EOL;
exit;
}
else {
print "Oracle database connection online". PHP_EOL;
}
?>