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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="gagal_input_tenda.php";
  $loginUsername = $_POST['kode_tenda'];
  $LoginRS__query = sprintf("SELECT kode_tenda FROM tbltenda WHERE kode_tenda=%s", GetSQLValueString($loginUsername, "text"));
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
  $insertSQL = sprintf("INSERT INTO tbltenda (kode_tenda, merk_tenda, stok, harga, gambar) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_tenda'], "text"),
                       GetSQLValueString($_POST['merk_tenda'], "text"),
                       GetSQLValueString($_POST['stok'], "int"),
                       GetSQLValueString($_POST['harga'], "double"),
                       GetSQLValueString($_FILES['gambar'] ['name'], "text"));
  						move_uploaded_file($_FILES['gambar']['tmp_name'],"img/".$_FILES['gambar']['name']);

  mysql_select_db($database_koneksitenda, $koneksitenda);
  $Result1 = mysql_query($insertSQL, $koneksitenda) or die(mysql_error());
}

mysql_select_db($database_koneksitenda, $koneksitenda);
$query_tampil_tenda = "SELECT * FROM tbltenda";
$tampil_tenda = mysql_query($query_tampil_tenda, $koneksitenda) or die(mysql_error());
$row_tampil_tenda = mysql_fetch_assoc($tampil_tenda);
$totalRows_tampil_tenda = mysql_num_rows($tampil_tenda);
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
<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' harus di isi angka.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' harus di isi angka between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' Harus di isi.\n'; }
    } if (errors) alert('Terjadi kesalahan input data:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>
<link rel="stylesheet" type="text/css" href="css.css"><style type="text/css">
<!--
body {
	background-image: url(gambar/coba.gif);
}
.isi {
	color: #060;
}
.isi {
	color: #060;
}
.coba {
	color: #060;
}
-->
</style></head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="MM_validateForm('kode_tenda','','R','merk_tenda','','R','stok','','RisNum','harga','','RisNum');return document.MM_returnValue">
  <div align="center">
    <table width="1000" height="246" border="1">
      <tr>
        <td width="140" bgcolor="#363735"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="844" bgcolor="#009999"><div align="center" class="header">SELAMAT DATANG DI HALAMAN INPUT TENDA</div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666"><ul id="MenuBar1" class="MenuBarHorizontal">
          <li><a class="MenuBarItemSubmenu" href="#">Input data</a>
            <ul>
              <li><a href="input_pemesan.php">pemesan</a></li>
              <li><a href="inputl_pemesanan.php">pemesanan</a></li>
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
          <table width="411" height="226" border="1">
            <tr>
              <td class="isi"><table align="center" class="coba">
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" class="header"><span class="header"><span class="header">Kode_tenda:</span></span></td>
                  <td><span class="header"><span class="header">
                    <input name="kode_tenda" type="text" id="kode_tenda" value="" size="32" />
                    </span></span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" class="header"><span class="header"><span class="header">Merk_tenda:</span></span></td>
                  <td><span class="header"><span class="header">
                    <input name="merk_tenda" type="text" id="merk_tenda" value="" size="32" />
                    </span></span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" class="header"><span class="header"><span class="header">Stok:</span></span></td>
                  <td><span class="header"><span class="header">
                    <input name="stok" type="text" id="stok" value="" size="32" />
                    </span></span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" class="header"><span class="header"><span class="header">Harga:</span></span></td>
                  <td><span class="header"><span class="header">
                    <input name="harga" type="text" id="harga" value="" size="32" />
                    </span></span></td>
                  </tr>
                <tr valign="baseline">
                  <td align="right" nowrap="nowrap" class="header"><span class="header"><span class="header">Gambar:</span></span></td>
                  <td><span class="header"><span class="header">
                    <input name="gambar" type="file" size="32" />
                    </span></span></td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td class="isi"><span class="header"><span class="header">
                    <input type="submit" value="Insert record" />
                    </span></span></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1" /></td>
              </tr>
            </table>
          <p>&nbsp;</p>
        </div>
          <div align="center">
            <table width="200" border="1">
              <tr>
                <td>&nbsp;
                  <table border="1">
                    <tr class="header">
                      <td bgcolor="#006666"><div align="center">kode_tenda</div></td>
                      <td bgcolor="#006666"><div align="center">merk_tenda</div></td>
                      <td bgcolor="#006666"><div align="center">stok</div></td>
                      <td bgcolor="#006666"><div align="center">harga</div></td>
                      <td bgcolor="#006666"><div align="center">gambar</div></td>
                      <td colspan="2" bgcolor="#006666"><div align="center">Opsi</div></td>
                    </tr>
                    <?php do { ?>
                      <tr class="header">
                        <td><?php echo $row_tampil_tenda['kode_tenda']; ?></td>
                        <td><?php echo $row_tampil_tenda['merk_tenda']; ?></td>
                        <td><?php echo $row_tampil_tenda['stok']; ?></td>
                        <td><?php echo $row_tampil_tenda['harga']; ?></td>
                        <td><img src="img/<?php echo $row_tampil_tenda['gambar']; ?>" alt="" width="100" height="100" /></td>
                        <td><a href="edit_tenda.php?kode_tenda=<?php echo $row_tampil_tenda['kode_tenda']; ?>">Edit</a></td>
                        <td><a href="hapus_tenda.php?kode_tenda=<?php echo $row_tampil_tenda['kode_tenda']; ?>">Hapus</a></td>
                      </tr>
                      <?php } while ($row_tampil_tenda = mysql_fetch_assoc($tampil_tenda)); ?>
                </table></td>
              </tr>
            </table>
          </div>
          <p>&nbsp;</p>
        <div align="center"></div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#006666" class="header">created by bt66</td>
      </tr>
    </table>
  </div>
</form>
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
mysql_free_result($tampil_tenda);
?>
