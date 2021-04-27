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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE tblpemesan SET nama_pemesan=%s, jenis_kel=%s, no_hp=%s, alamat_pemesan=%s WHERE id_pemesan=%s",
                       GetSQLValueString($_POST['nama_pemesan'], "text"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['no_hp'], "text"),
                       GetSQLValueString($_POST['alamat_pemesan'], "text"),
                       GetSQLValueString($_POST['id_pemesan'], "text"));

  mysql_select_db($database_koneksitenda, $koneksitenda);
  $Result1 = mysql_query($updateSQL, $koneksitenda) or die(mysql_error());

  $updateGoTo = "input_pemesan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_edit_pemesan = "SELECT * FROM tblpemesan";
$edit_pemesan = mysql_query($query_edit_pemesan, $koneksitenda) or die(mysql_error());
$row_edit_pemesan = mysql_fetch_assoc($edit_pemesan);
$totalRows_edit_pemesan = mysql_num_rows($edit_pemesan);$colname_edit_pemesan = "-1";
if (isset($_GET['id_pemesan'])) {
  $colname_edit_pemesan = $_GET['id_pemesan'];
}
mysql_select_db($database_koneksitenda, $koneksitenda);
$query_edit_pemesan = sprintf("SELECT * FROM tblpemesan WHERE id_pemesan = %s", GetSQLValueString($colname_edit_pemesan, "text"));
$edit_pemesan = mysql_query($query_edit_pemesan, $koneksitenda) or die(mysql_error());
$row_edit_pemesan = mysql_fetch_assoc($edit_pemesan);
$totalRows_edit_pemesan = mysql_num_rows($edit_pemesan);
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
.header {
	color: #FFF;
}
-->
</style>
<link rel="stylesheet" type="text/css" href="css.css">
<style type="text/css">
<!--
body {
	background-image: url(gambar/background%20edit.gif);
}
-->
</style>
<link rel="stylesheet" type="text/css" href="css.css">
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <table width="800" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="644" bgcolor="#009999"><div align="center" class="header">SELAMAT DATANG DI EDIT PEMESANAN</div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666"><ul id="MenuBar1" class="MenuBarHorizontal">
          <li><a class="MenuBarItemSubmenu" href="#">Input data</a>
            <ul>
              <li><a href="inputl_pemesan.php">pemesan</a></li>
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
              <li><a class="MenuBarItemSubmenu" href="cetak_pemesan.php">pemesan</a>
                <ul>
                  <li><a href="#">Item 3.1.1</a></li>
                  <li><a href="#">Item 3.1.2</a></li>
                  </ul>
                </li>
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
                  <td nowrap="nowrap" align="right">Id_pemesan:</td>
                  <td><?php echo $row_edit_pemesan['id_pemesan']; ?></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Nama_pemesan:</td>
                  <td><input type="text" name="nama_pemesan" value="<?php echo htmlentities($row_edit_pemesan['nama_pemesan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Jenis_kel:</td>
                  <td><input type="text" name="jenis_kel" value="<?php echo htmlentities($row_edit_pemesan['jenis_kel'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">No_hp:</td>
                  <td><input type="text" name="no_hp" value="<?php echo htmlentities($row_edit_pemesan['no_hp'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Alamat_pemesan:</td>
                  <td><input type="text" name="alamat_pemesan" value="<?php echo htmlentities($row_edit_pemesan['alamat_pemesan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td><input type="submit" value="Update" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form2" />
                <input type="hidden" name="id_pemesan" value="<?php echo $row_edit_pemesan['id_pemesan']; ?>" /></td>
              </tr>
            </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666" class="header">created by bt66</td>
      </tr>
    </table>
  </div>
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($edit_pemesan);
?>
