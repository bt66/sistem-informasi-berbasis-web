<?php require_once('Connections/koneksitenda.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "logout.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
}if (!function_exists("GetSQLValueString")) {
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

$colname_cari_tenda = "-1";
if (isset($_GET['kode_tenda'])) {
  $colname_cari_tenda = $_GET['kode_tenda'];
}
mysql_select_db($database_koneksitenda, $koneksitenda);
$query_cari_tenda = sprintf("SELECT * FROM tbltenda WHERE kode_tenda = %s", GetSQLValueString($colname_cari_tenda, "text"));
$cari_tenda = mysql_query($query_cari_tenda, $koneksitenda) or die(mysql_error());
$row_cari_tenda = mysql_fetch_assoc($cari_tenda);
$totalRows_cari_tenda = mysql_num_rows($cari_tenda);$colname_cari_tenda = "-1";
if (isset($_GET['merk_tenda'])) {
  $colname_cari_tenda = $_GET['merk_tenda'];
}
mysql_select_db($database_koneksitenda, $koneksitenda);
$query_cari_tenda = sprintf("SELECT * FROM tbltenda WHERE merk_tenda = %s", GetSQLValueString($colname_cari_tenda, "text"));
$cari_tenda = mysql_query($query_cari_tenda, $koneksitenda) or die(mysql_error());
$row_cari_tenda = mysql_fetch_assoc($cari_tenda);
$totalRows_cari_tenda = mysql_num_rows($cari_tenda);
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
-->
</style>
<link rel="stylesheet" type="text/css" href="css.css">
<style type="text/css">
<!--
body {
	background-image: url(gambar/background%20cr.gif);
}
.tabel {
}
.cari {
	text-align: left;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="get" action="">
  <div align="center">
    <table width="800" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="644" bgcolor="#009999"><div align="center">SELAMAT DATANG DI HALAMAN CARI TENDA</div></td>
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
        <td colspan="2" bgcolor="#339966"><p>&nbsp;</p>
          <div align="center">
            <table width="361" height="32" border="1">
              <tr>
                <td width="273" class="cari">Cari tenda 
                    <label>
                      <input type="text" name="merk_tenda" id="merk_tenda" />
                    </label>                
                  <label></label>
                </td>
                <td width="33"><label>
                  <input type="submit" name="button" id="button" value="cari" />
                </label></td>
              </tr>
            </table>
            <p>&nbsp;</p>
          </div>
          <div align="center"></div>
          <div align="center">
            <?php if ($totalRows_cari_tenda > 0) { // Show if recordset not empty ?>
              <table border="1">
                <MM_REPEATEDREGION SOURCE="@@rs@@"><MM:DECORATION OUTLINE="Repeat" OUTLINEID=2>
                  <tr></tr>
                </MM:DECORATION></MM_REPEATEDREGION>
                <tr>
                  <td><div align="center">kode_tenda</div></td>
                  <td><div align="center">merk_tenda</div></td>
                  <td><div align="center">stok</div></td>
                  <td><div align="center">harga</div></td>
                  <td><div align="center">gambar</div></td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td><div align="center"><?php echo $row_cari_tenda['kode_tenda']; ?></div></td>
                    <td><div align="center"><?php echo $row_cari_tenda['merk_tenda']; ?></div></td>
                    <td><div align="center"><?php echo $row_cari_tenda['stok']; ?></div></td>
                    <td><div align="center"><?php echo $row_cari_tenda['harga']; ?></div></td>
                    <td><div align="center"><img src="img/<?php echo $row_cari_tenda['gambar']; ?>" alt="" width="100" height="100" /></div></td>
                  </tr>
                  <?php } while ($row_cari_tenda = mysql_fetch_assoc($cari_tenda)); ?>
              </table>
              <?php } // Show if recordset not empty ?>
          </div>
        <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666">created by bt66</td>
      </tr>
    </table>
    <p class="tabel">&nbsp;</p>
  </div>
</form>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($cari_tenda);
?>
