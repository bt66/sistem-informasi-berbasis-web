<?php require_once('Connections/koneksitenda.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_cetak_pemesan = "SELECT * FROM tblpemesan";
$cetak_pemesan = mysql_query($query_cetak_pemesan, $koneksitenda) or die(mysql_error());
$row_cetak_pemesan = mysql_fetch_assoc($cetak_pemesan);
$totalRows_cetak_pemesan = mysql_num_rows($cetak_pemesan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.header {
	color: #FFF;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="499" height="197" border="1">
    <tr>
      <td bgcolor="#009966"><div align="center" class="header">LAPORAN DATA PEMESAN</div></td>
    </tr>
    <tr>
      <td bgcolor="#99FF99">&nbsp;
        <div align="center">
          <table border="1">
            <tr>
              <td><div align="center">id_pemesan</div></td>
              <td><div align="center">nama_pemesan</div></td>
              <td><div align="center">jenis_kel</div></td>
              <td><div align="center">no_hp</div></td>
              <td><div align="center">alamat_pemesan</div></td>
            </tr>
            <?php do { ?>
              <tr>
                <td><div align="center"><?php echo $row_cetak_pemesan['id_pemesan']; ?></div></td>
                <td><div align="center"><?php echo $row_cetak_pemesan['nama_pemesan']; ?></div></td>
                <td><div align="center"><?php echo $row_cetak_pemesan['jenis_kel']; ?></div></td>
                <td><div align="center"><?php echo $row_cetak_pemesan['no_hp']; ?></div></td>
                <td><div align="center"><?php echo $row_cetak_pemesan['alamat_pemesan']; ?></div></td>
              </tr>
            <?php } while ($row_cetak_pemesan = mysql_fetch_assoc($cetak_pemesan)); ?>
              </table>
              <script>
		  		     window.print();
			  </script>
		  
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($cetak_pemesan);
?>
