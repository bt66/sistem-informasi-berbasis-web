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
$query_cetak_pemesanan = "SELECT * FROM tblpemesanan";
$cetak_pemesanan = mysql_query($query_cetak_pemesanan, $koneksitenda) or die(mysql_error());
$row_cetak_pemesanan = mysql_fetch_assoc($cetak_pemesanan);
$totalRows_cetak_pemesanan = mysql_num_rows($cetak_pemesanan);
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
        <td bgcolor="#009966"><div align="center" class="header">CETAK LAPORAN PEMESANAN</div></td>
      </tr>
      <tr>
        <td bgcolor="#99FF99">&nbsp;
          <table border="1">
            <tr>
              <td>kode_tenda</td>
              <td>id_pemesan</td>
              <td>id_petugas</td>
              <td>tgl_pinjam</td>
              <td>tgl_kembali</td>
              <td>total_biaya</td>
              <td>jml_pinjam</td>
            </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_cetak_pemesanan['kode_tenda']; ?></td>
                <td><?php echo $row_cetak_pemesanan['id_pemesan']; ?></td>
                <td><?php echo $row_cetak_pemesanan['id_petugas']; ?></td>
                <td><?php echo $row_cetak_pemesanan['tgl_pinjam']; ?></td>
                <td><?php echo $row_cetak_pemesanan['tgl_kembali']; ?></td>
                <td><?php echo $row_cetak_pemesanan['total_biaya']; ?></td>
                <td><?php echo $row_cetak_pemesanan['jml_pinjam']; ?></td>
              </tr>
              <?php } while ($row_cetak_pemesanan = mysql_fetch_assoc($cetak_pemesanan)); ?>
        </table><div align="center"></div></td>
<script>
		  		window.print();
		</script>
      </tr>
    </table>
  </div>
  <script>
		  		window.print();
		</script>
</form>
</body>
</html>
<?php
mysql_free_result($cetak_pemesanan);
?>
