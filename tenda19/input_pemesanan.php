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
  $MM_dupKeyRedirect="gagal_input_pemesanan.php";
  $loginUsername = $_POST['id_pemesan'];
  $LoginRS__query = sprintf("SELECT id_pemesan FROM tblpemesanan WHERE id_pemesan=%s", GetSQLValueString($loginUsername, "text"));
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
  $insertSQL = sprintf("INSERT INTO tblpemesanan (kode_tenda, id_pemesan, id_petugas, tgl_pinjam, tgl_kembali, total_biaya, jml_pinjam) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_tenda'], "text"),
                       GetSQLValueString($_POST['id_pemesan'], "text"),
                       GetSQLValueString($_POST['id_petugas'], "text"),
                       GetSQLValueString($_POST['tgl_pinjam'], "text"),
                       GetSQLValueString($_POST['tgl_kembali'], "text"),
                       GetSQLValueString($_POST['total_biaya'], "double"),
                       GetSQLValueString($_POST['jml_pinjam'], "int"));

  mysql_select_db($database_koneksitenda, $koneksitenda);
  $Result1 = mysql_query($insertSQL, $koneksitenda) or die(mysql_error());

  $insertGoTo = "input_pemesanan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_pemesanan = "SELECT * FROM tblpemesan";
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

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_pemesan = "SELECT * FROM tblpemesan";
$pemesan = mysql_query($query_pemesan, $koneksitenda) or die(mysql_error());
$row_pemesan = mysql_fetch_assoc($pemesan);
$totalRows_pemesan = mysql_num_rows($pemesan);

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_tampil_pemesanan = "SELECT * FROM tblpemesanan";
$tampil_pemesanan = mysql_query($query_tampil_pemesanan, $koneksitenda) or die(mysql_error());
$row_tampil_pemesanan = mysql_fetch_assoc($tampil_pemesanan);
$totalRows_tampil_pemesanan = mysql_num_rows($tampil_pemesanan);
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
	background-image: url(gambar/coba.gif);
}
.putih {
	color: #FFF;
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
<style type="text/css">
<!--
.header {	color: #FFF;
}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="MM_validateForm('tgl_pinjam','','R','tgl_kembali','','R','total_biaya','','RisNum','jml_pinjam','','RisNum');return document.MM_returnValue">
  <div align="center">
    <table width="800" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="1760" bgcolor="#009999"><div align="center"><span class="header">SELAMAT DATANG DI HALAMAN</span> INPUT PEMESANAN</div></td>
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
        <td colspan="2" bgcolor="#339966">
          <div align="center">
            <table width="200" border="1">
              <tr>
                <td><table align="center">
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="isi"><span class="putih">Kode_tenda:</span></td>
                    <td>
                      <span class="putih">
                      <select name="kode_tenda">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_tenda['merk_tenda']?>" <?php if (!(strcmp($row_tenda['merk_tenda'], $row_tenda['kode_tenda']))) {echo "SELECTED";} ?>><?php echo $row_tenda['kode_tenda']?></option>
                        <?php
} while ($row_tenda = mysql_fetch_assoc($tenda));
?>
                      </select>
                      </span></td>
                    </tr>
                  <tr> </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="isi"><span class="putih">Id_pemesan:</span></td>
                    <td>
                      <span class="putih">
                      <select name="id_pemesan">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_pemesan['nama_pemesan']?>" <?php if (!(strcmp($row_pemesan['nama_pemesan'], $row_pemesan['id_pemesan']))) {echo "SELECTED";} ?>><?php echo $row_pemesan['id_pemesan']?></option>
                        <?php
} while ($row_pemesan = mysql_fetch_assoc($pemesan));
?>
                      </select>
                      </span></td>
                    </tr>
                  <tr> </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="isi"><span class="putih">Id_petugas:</span></td>
                    <td>
                      <span class="putih">
                      <select name="id_petugas">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_petugas['nama_petugas']?>" <?php if (!(strcmp($row_petugas['nama_petugas'], $row_petugas['id_petugas']))) {echo "SELECTED";} ?>><?php echo $row_petugas['id_petugas']?></option>
                        <?php
} while ($row_petugas = mysql_fetch_assoc($petugas));
?>
                      </select>
                      </span></td>
                    </tr>
                  <tr> </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="isi"><span class="putih">Tgl_pinjam:</span></td>
                    <td>                      <span class="putih">
                      <input name="tgl_pinjam" type="text" id="tgl_pinjam" value="" size="32" />                      
                      </span></td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="isi"><span class="putih">Tgl_kembali:</span></td>
                    <td>                      <span class="putih">
                      <input name="tgl_kembali" type="text" id="tgl_kembali" value="" size="32" />                      
                      </span></td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="isi"><span class="putih">Total_biaya:</span></td>
                    <td>                      <span class="putih">
                      <input name="total_biaya" type="text" id="total_biaya" value="" size="32" />                      
                      </span></td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="isi"><span class="putih">Jml_pinjam:</span></td>
                    <td>                      <span class="putih">
                      <input name="jml_pinjam" type="text" id="jml_pinjam" value="" size="32" />                      
                      </span></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td>                      <span class="putih">
                      <input type="submit" value="Insert record" />                    
                      </span></td>
                    </tr>
                  </table>
                <input type="hidden" name="MM_insert" value="form1" /></td>
              </tr>
            </table>
            <p>&nbsp;</p>
            <table border="1">
              <tr>
                <td bgcolor="#006666"><span class="putih">nomor</span></td>
                <td bgcolor="#006666"><span class="putih">kode_tenda</span></td>
                <td bgcolor="#006666"><span class="putih">id_pemesan</span></td>
                <td bgcolor="#006666"><span class="putih">id_petugas</span></td>
                <td bgcolor="#006666"><span class="putih">tgl_pinjam</span></td>
                <td bgcolor="#006666"><span class="putih">tgl_kembali</span></td>
                <td bgcolor="#006666"><span class="putih">total_biaya</span></td>
                <td bgcolor="#006666"><span class="putih">jml_pinjam</span></td>
                <td colspan="2" bgcolor="#006666" class="isi"><div align="center"><span class="putih">Opsi</span></div></td>
              </tr>
              <?php do { ?>
                <tr>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['nomor']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['kode_tenda']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['id_pemesan']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['id_petugas']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['tgl_pinjam']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['tgl_kembali']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['total_biaya']; ?></span></td>
                  <td><span class="putih"><?php echo $row_tampil_pemesanan['jml_pinjam']; ?></span></td>
                  <td class="isi"><div align="center"><span class="putih"><a href="edit_pemesanan.php?nomor=<?php echo $row_tampil_pemesanan['nomor']; ?>">Edit</a></span></div></td>
                  <td class="isi"><div align="center"><a href="hapus_pemesanan.php?nomor=<?php echo $row_tampil_pemesanan['nomor']; ?>">Hapus</a></div></td>
                </tr>
                <?php } while ($row_tampil_pemesanan = mysql_fetch_assoc($tampil_pemesanan)); ?>
            </table>
          </div>
        <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666">created by bt66</td>
      </tr>
    </table>
  </div>
</form>
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
mysql_free_result($pemesanan);

mysql_free_result($petugas);

mysql_free_result($tenda);

mysql_free_result($pemesan);

mysql_free_result($tampil_pemesanan);
?>
