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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tblpemesanan SET kode_tenda=%s, id_pemesan=%s, id_petugas=%s, tgl_pinjam=%s, tgl_kembali=%s, total_biaya=%s, jml_pinjam=%s WHERE nomor=%s",
                       GetSQLValueString($_POST['kode_tenda'], "text"),
                       GetSQLValueString($_POST['id_pemesan'], "text"),
                       GetSQLValueString($_POST['id_petugas'], "text"),
                       GetSQLValueString($_POST['tgl_pinjam'], "text"),
                       GetSQLValueString($_POST['tgl_kembali'], "text"),
                       GetSQLValueString($_POST['total_biaya'], "double"),
                       GetSQLValueString($_POST['jml_pinjam'], "int"),
                       GetSQLValueString($_POST['nomor'], "int"));

  mysql_select_db($database_koneksitenda, $koneksitenda);
  $Result1 = mysql_query($updateSQL, $koneksitenda) or die(mysql_error());

  $updateGoTo = "input_pemesanan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_pemesan = "SELECT * FROM tblpemesan";
$pemesan = mysql_query($query_pemesan, $koneksitenda) or die(mysql_error());
$row_pemesan = mysql_fetch_assoc($pemesan);
$totalRows_pemesan = mysql_num_rows($pemesan);

$colname_pemesanan = "-1";
if (isset($_GET['nomor'])) {
  $colname_pemesanan = $_GET['nomor'];
}
mysql_select_db($database_koneksitenda, $koneksitenda);
$query_pemesanan = sprintf("SELECT * FROM tblpemesanan WHERE nomor = %s", GetSQLValueString($colname_pemesanan, "int"));
$pemesanan = mysql_query($query_pemesanan, $koneksitenda) or die(mysql_error());
$row_pemesanan = mysql_fetch_assoc($pemesanan);
$totalRows_pemesanan = mysql_num_rows($pemesanan);

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_petugas = "SELECT * FROM tblpetugas";
$petugas = mysql_query($query_petugas, $koneksitenda) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);
$totalRows_petugas = mysql_num_rows($petugas);

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_tenda = "SELECT * FROM tbltenda";
$tenda = mysql_query($query_tenda, $koneksitenda) or die(mysql_error());
$row_tenda = mysql_fetch_assoc($tenda);
$totalRows_tenda = mysql_num_rows($tenda);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body,td,th {
	color: #FFF;
}
.isi {
	color: #000;
}
body {
	background-image: url(gambar/background%20edit.gif);
}
-->
</style>
<link rel="stylesheet" type="text/css" href="css.css">
<style type="text/css">
<!--
.header {	color: #FFF;
}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="post">
  <div align="center">
    <table width="800" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="644" bgcolor="#009999"><div align="center"><span class="header">SELAMAT DATANG DI</span> HALAMAN UTAMA</div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666"><ul id="MenuBar1" class="MenuBarHorizontal">
          <li><a class="MenuBarItemSubmenu" href="#">Input data</a>
            <ul>
              <li><a href="input_pemesan.php">pemesan</a></li>
              <li><a href="input_pemesanan.php">pemesanan</a></li>
              <li><a href="input_petugas.php">petugas</a></li>
              <li><a href="input_tenda.php">tenda</a></li>
              </ul>
            </li>
          <li><a href="#" class="MenuBarItemSubmenu">Cari data</a>
            <ul>
              <li><a href="cari_pemesan.php">pemesan</a></li>
              <li><a href="cari_pemesanan.php">pemesanan</a></li>
              <li><a href="cari_petugas.php">petugas</a></li>
              <li><a href="cari_tenda.php">tenda</a></li>
              </ul>
            </li>
          <li><a class="MenuBarItemSubmenu" href="#">Cetak data</a>
            <ul>
              <li><a href="cetak_pemesan.php">pemesan</a>                </li>
              <li><a href="cetak_pemesanan.php">pemesanan</a></li>
              <li><a href="cetak_petugas.php">petugas</a></li>
              <li><a href="cetak_tenda.php">tenda</a></li>
              </ul>
            </li>
          <li><a href="index.php">Log out</a></li>
        </ul></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#339966"><div align="center">
          <table width="200" border="1">
            <tr>
              <td><table align="center">
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Kode_tenda:</td>
                  <td><select name="kode_tenda">
                    <?php 
do {  
?>
                    <option value="<?php echo $row_tenda['kode_tenda']?>" <?php if (!(strcmp($row_tenda['kode_tenda'], htmlentities($row_pemesanan['kode_tenda'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_tenda['kode_tenda']?></option>
                    <?php
} while ($row_tenda = mysql_fetch_assoc($tenda));
?>
                    </select></td>
                  </tr>
                <tr> </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Id_pemesan:</td>
                  <td><select name="id_pemesan">
                    <?php 
do {  
?>
                    <option value="<?php echo $row_pemesan['id_pemesan']?>" <?php if (!(strcmp($row_pemesan['id_pemesan'], htmlentities($row_pemesanan['id_pemesan'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_pemesan['id_pemesan']?></option>
                    <?php
} while ($row_pemesan = mysql_fetch_assoc($pemesan));
?>
                    </select></td>
                  </tr>
                <tr> </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Id_petugas:</td>
                  <td><select name="id_petugas">
                    <?php 
do {  
?>
                    <option value="<?php echo $row_petugas['id_petugas']?>" <?php if (!(strcmp($row_petugas['id_petugas'], htmlentities($row_pemesanan['id_petugas'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_petugas['id_petugas']?></option>
                    <?php
} while ($row_petugas = mysql_fetch_assoc($petugas));
?>
                    </select></td>
                  </tr>
                <tr> </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Tgl_pinjam:</td>
                  <td><input type="text" name="tgl_pinjam" value="<?php echo htmlentities($row_pemesanan['tgl_pinjam'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Tgl_kembali:</td>
                  <td><input type="text" name="tgl_kembali" value="<?php echo htmlentities($row_pemesanan['tgl_kembali'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Total_biaya:</td>
                  <td><input type="text" name="total_biaya" value="<?php echo htmlentities($row_pemesanan['total_biaya'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Jml_pinjam:</td>
                  <td><input type="text" name="jml_pinjam" value="<?php echo htmlentities($row_pemesanan['jml_pinjam'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td><input type="submit" value="Update record" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1" />
                <input type="hidden" name="nomor" value="<?php echo $row_pemesanan['nomor']; ?>" /></td>
              </tr>
            </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#339966">created by bt66</td>
      </tr>
    </table>
  </div>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($pemesan);

mysql_free_result($pemesanan);

mysql_free_result($pemesanan);

mysql_free_result($petugas);

mysql_free_result($tenda);

mysql_free_result($petugas);

mysql_free_result($petugas);

mysql_free_result($pemesanan);

mysql_free_result($edit_pemesanan);
?>
