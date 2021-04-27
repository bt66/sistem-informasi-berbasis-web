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
  $updateSQL = sprintf("UPDATE tblpetugas SET nama_petugas=%s, jenis_kel=%s, no_hp=%s, alamat_petugas=%s WHERE id_petugas=%s",
                       GetSQLValueString($_POST['nama_petugas'], "text"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['no_hp'], "text"),
                       GetSQLValueString($_POST['alamat_petugas'], "text"),
                       GetSQLValueString($_POST['id_petugas'], "text"));

  mysql_select_db($database_koneksitenda, $koneksitenda);
  $Result1 = mysql_query($updateSQL, $koneksitenda) or die(mysql_error());

  $updateGoTo = "input_petugas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_petugas = "-1";
if (isset($_GET['id_petugas'])) {
  $colname_edit_petugas = $_GET['id_petugas'];
}
mysql_select_db($database_koneksitenda, $koneksitenda);
$query_edit_petugas = sprintf("SELECT * FROM tblpetugas WHERE id_petugas = %s", GetSQLValueString($colname_edit_petugas, "text"));
$edit_petugas = mysql_query($query_edit_petugas, $koneksitenda) or die(mysql_error());
$row_edit_petugas = mysql_fetch_assoc($edit_petugas);
$totalRows_edit_petugas = mysql_num_rows($edit_petugas);
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
    <table width="674" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="518" bgcolor="#009999"><div align="center" class="header">SELAMAT DATANG DI HALAMAN EDIT PETUGAS</div></td>
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
                  <td nowrap="nowrap" align="right">Id_petugas:</td>
                  <td><?php echo $row_edit_petugas['id_petugas']; ?></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Nama_petugas:</td>
                  <td><input type="text" name="nama_petugas" value="<?php echo htmlentities($row_edit_petugas['nama_petugas'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Jenis_kel:</td>
                  <td><input type="text" name="jenis_kel" value="<?php echo htmlentities($row_edit_petugas['jenis_kel'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">No_hp:</td>
                  <td><input type="text" name="no_hp" value="<?php echo htmlentities($row_edit_petugas['no_hp'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Alamat_petugas:</td>
                  <td><input type="text" name="alamat_petugas" value="<?php echo htmlentities($row_edit_petugas['alamat_petugas'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td><input type="submit" value="Update record" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form2" />
                <input type="hidden" name="id_petugas" value="<?php echo $row_edit_petugas['id_petugas']; ?>" /></td>
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
mysql_free_result($edit_petugas);
?>
