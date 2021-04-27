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
$query_cetak_tenda = "SELECT * FROM tbltenda";
$cetak_tenda = mysql_query($query_cetak_tenda, $koneksitenda) or die(mysql_error());
$row_cetak_tenda = mysql_fetch_assoc($cetak_tenda);
$totalRows_cetak_tenda = mysql_num_rows($cetak_tenda);
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
  <div align="center">
    <table width="298" height="103" border="1">
      <tr>
        <td bgcolor="#009966"><div align="center" class="header">CETAK LAPORAN TENDA</div></td>
      </tr>
      <tr>
        <td bgcolor="#99FF99">&nbsp;
          <div align="center">
            <table width="200" border="1">
              <tr>
                <td>&nbsp;
                  <table border="1">
                    <tr>
                      <td>kode_tenda</td>
                      <td>merk_tenda</td>
                      <td>stok</td>
                      <td>harga</td>
                      <td>gambar</td>
                    </tr>
                    <?php do { ?>
                      <tr>
                        <td><?php echo $row_cetak_tenda['kode_tenda']; ?></td>
                        <td><?php echo $row_cetak_tenda['merk_tenda']; ?></td>
                        <td><?php echo $row_cetak_tenda['stok']; ?></td>
                        <td><?php echo $row_cetak_tenda['harga']; ?></td>
                        <td><img src="img/<?php echo $row_cetak_tenda['gambar']; ?>" alt="" width="100" height="100" /></td>
                      </tr>
                      <?php } while ($row_cetak_tenda = mysql_fetch_assoc($cetak_tenda)); ?>
                </table></td>
              </tr>
            </table>
        </div></td>
<script>
		  		window.print();
		</script>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($cetak_tenda);
?>
