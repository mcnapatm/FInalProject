<?php
/* Database config */
$db_host = 'localhost';
$db_user = 'patric14_admin';
$db_pass = 'o@KZj?Q6';
$db_database = 'patric14_taskmaster';

/* End Config */

$db= new PDO('mysql:host='.$db_host.';
					dbname='.$db_database, $db_user, $db_pass);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>