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
}

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="gagal_input_pemesan.php";
  $loginUsername = $_POST['id_pemesan'];
  $LoginRS__query = sprintf("SELECT id_pemesan FROM tblpemesan WHERE id_pemesan=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_koneksitenda, $koneksitenda);
  $LoginRS=mysql_query($LoginRS__query, $koneksitenda) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tblpemesan (id_pemesan, nama_pemesan, jenis_kel, no_hp, alamat_pemesan) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pemesan'], "text"),
                       GetSQLValueString($_POST['nama_pemesan'], "text"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['no_hp'], "text"),
                       GetSQLValueString($_POST['alamat_pemesan'], "text"));

  mysql_select_db($database_koneksitenda, $koneksitenda);
  $Result1 = mysql_query($insertSQL, $koneksitenda) or die(mysql_error());

  $insertGoTo = "input_pemesan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_tampil = "SELECT * FROM tblpemesan";
$tampil = mysql_query($query_tampil, $koneksitenda) or die(mysql_error());
$row_tampil = mysql_fetch_assoc($tampil);
$totalRows_tampil = mysql_num_rows($tampil);
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
	background-image: url(gambar/coba.gif);
}
.putih {
	color: #FFF;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' harus di isi.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' harus di isi angka.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' harus di isi angka between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' harus di isi.\n'; }
    } if (errors) alert('Terjadi kesalahan input data:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
<link rel="stylesheet" type="text/css" href="css.css">
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="MM_validateForm('id_pemesan','','R','nama_pemesan','','R','jenis_kel','','R','no_hp','','RisNum','alamat_pemesan','','R');return document.MM_returnValue">
  <div align="center" onfocus="MM_validateForm('id_pemesan','','R','nama_pemesan','','R','jenis_kel','','R','no_hp','','RisNum','alamat_pemesan','','R');return document.MM_returnValue">
    <table width="800" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="678" bgcolor="#009999"><div align="center" class="header">SELAMAT DATANG DI HALAMAN INPUT PEMESAN</div></td>
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
        <td colspan="2" bgcolor="#339966"><div align="center" onfocus="MM_validateForm('id_pemesan','','RisNum','nama_pemesan','','RisNum','jenis_kel','','RisNum','no_hp','','RisNum','alamat_pemesan','','RisNum');return document.MM_returnValue">
          <table width="200" border="1">
            <tr>
              <td><table align="center">
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap"><span class="putih">Id_pemesan:</span></td>
                  <td><span class="putih">
                    <input name="id_pemesan" type="text" id="id_pemesan" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap"><span class="putih">Nama_pemesan:</span></td>
                  <td><span class="putih">
                    <input name="nama_pemesan" type="text" id="nama_pemesan" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap"><span class="putih">Jenis_kel:</span></td>
                  <td><span class="putih">
                    <input name="jenis_kel" type="text" id="jenis_kel" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap"><span class="putih">No_hp:</span></td>
                  <td><span class="putih">
                    <input name="no_hp" type="text" id="no_hp" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap"><span class="putih">Alamat_pemesan:</span></td>
                  <td><span class="putih">
                    <input name="alamat_pemesan" type="text" id="alamat_pemesan" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap">&nbsp;</td>
                  <td><span class="putih">
                    <input type="submit" value="Insert record" />
                  </span></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1" /></td>
              </tr>
            </table>
        </div>
          <p>&nbsp;</p>
          <div align="center">
            <table border="1">
              <tr>
                <td bgcolor="#006666"><span class="putih">id_pemesan</span></td>
                <td bgcolor="#006666"><span class="putih">nama_pemesan</span></td>
                <td bgcolor="#006666"><span class="putih">jenis_kel</span></td>
                <td bgcolor="#006666"><span class="putih">no_hp</span></td>
                <td bgcolor="#006666"><span class="putih">alamat_pemesan</span></td>
                <td colspan="2" bgcolor="#006666"><span class="putih">Option</span></td>
              </tr>
              <?php do { ?>
                <tr>
                  <td><span class="putih"><?php echo $row_tampil['id_pemesan']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil['nama_pemesan']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil['jenis_kel']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil['no_hp']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil['alamat_pemesan']; ?></span></td>
                  <td><span class="putih"><a href="edit_pemesan.php?id_pemesan=<?php echo $row_tampil['id_pemesan']; ?>">Edit</a></span></td>
                  <td><a href="hapus_pemesan.php?id_pemesan=<?php echo $row_tampil['id_pemesan']; ?>">Hapus</a></td>
                </tr>
                <?php } while ($row_tampil = mysql_fetch_assoc($tampil)); ?>
            </table>
        </div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666" class="header">created by bt66</td>
      </tr>
    </table>
  </div>
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
mysql_free_result($tampil);
?>
