<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_koneksitenda = "localhost";
$database_koneksitenda = "dbtenda";
$username_koneksitenda = "root";
$password_koneksitenda = "";
$koneksitenda = mysql_pconnect($hostname_koneksitenda, $username_koneksitenda, $password_koneksitenda) or trigger_error(mysql_error(),E_USER_ERROR); 
?>