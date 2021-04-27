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
  $MM_dupKeyRedirect="gagal_input_petugas.php";
  $loginUsername = $_POST['id_petugas'];
  $LoginRS__query = sprintf("SELECT id_petugas FROM tblpetugas WHERE id_petugas=%s", GetSQLValueString($loginUsername, "text"));
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
  $insertSQL = sprintf("INSERT INTO tblpetugas (id_petugas, nama_petugas, jenis_kel, no_hp, alamat_petugas) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_petugas'], "text"),
                       GetSQLValueString($_POST['nama_petugas'], "text"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['no_hp'], "text"),
                       GetSQLValueString($_POST['alamat_petugas'], "text"));

  mysql_select_db($database_koneksitenda, $koneksitenda);
  $Result1 = mysql_query($insertSQL, $koneksitenda) or die(mysql_error());

  $insertGoTo = "input_petugas.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_tampil_petugas = "SELECT * FROM tblpetugas";
$tampil_petugas = mysql_query($query_tampil_petugas, $koneksitenda) or die(mysql_error());
$row_tampil_petugas = mysql_fetch_assoc($tampil_petugas);
$totalRows_tampil_petugas = mysql_num_rows($tampil_petugas);
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="MM_validateForm('id_petugas','','R','nama_petugas','','R','jenis_kel','','R','no_hp','','RisNum','alamat_petugas','','R');return document.MM_returnValue">
  <div align="center">
    <table width="800" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="976" bgcolor="#009999"><div align="center" class="header">SELAMAT DATANG DI HALAMAN INPUT PETUGAS</div></td>
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
        <td colspan="2" bgcolor="#339966"><div align="center" onfocus="MM_validateForm('id_petugas','','R','nama_petugas','','R','jenis_kel','','R','no_hp','','RisNum','alamat_petugas','','R');return document.MM_returnValue">
          <table width="310" border="1">
            <tr>
              <td width="300"><table align="center">
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right"><span class="putih">Id_petugas:</span></td>
                  <td><span class="putih">
                    <input name="id_petugas" type="text" id="id_petugas" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right"><span class="putih">Nama_petugas:</span></td>
                  <td><span class="putih">
                    <input name="nama_petugas" type="text" id="nama_petugas" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right"><span class="putih">Jenis_kel:</span></td>
                  <td><span class="putih">
                    <input name="jenis_kel" type="text" id="jenis_kel" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right"><span class="putih">No_hp:</span></td>
                  <td><span class="putih">
                    <input name="no_hp" type="text" id="no_hp" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td height="55" align="right" nowrap="nowrap"><span class="putih">Alamat_petugas:</span></td>
                  <td><span class="putih">
                    <input name="alamat_petugas" type="text" id="alamat_petugas" value="" size="32" />
                  </span></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td><input type="submit" value="Insert record" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1" /></td>
              </tr>
            </table>
        </div>
          <p>&nbsp;</p>
          <div align="center">
            <table border="1">
              <tr bgcolor="#006666">
                <td><span class="putih">id_petugas</span></td>
                <td><span class="putih">nama_petugas</span></td>
                <td bgcolor="#006666"><span class="putih">jenis_kel</span></td>
                <td><span class="putih">no_hp</span></td>
                <td><span class="putih">alamat_petugas</span></td>
                <td colspan="2"><span class="putih">Option</span></td>
              </tr>
              <?php do { ?>
                <tr>
                  <td><span class="putih"><?php echo $row_tampil_petugas['id_petugas']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_petugas['nama_petugas']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_petugas['jenis_kel']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_petugas['no_hp']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_petugas['alamat_petugas']; ?></span></td>
                  <td><span class="putih"><a href="edit_petugas.php?id_petugas=<?php echo $row_tampil_petugas['id_petugas']; ?>">Edit</a></span></td>
                  <td><span class="putih"><a href="hapus_petugas.php?id_petugas=<?php echo $row_tampil_petugas['id_petugas']; ?>">Hapus</a></span></td>
                </tr>
                <?php } while ($row_tampil_petugas = mysql_fetch_assoc($tampil_petugas)); ?>
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
mysql_free_result($tampil_petugas);
?>
