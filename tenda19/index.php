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
$query_listbarang = "SELECT * FROM tbltenda";
$listbarang = mysql_query($query_listbarang, $koneksitenda) or die(mysql_error());
$row_listbarang = mysql_fetch_assoc($listbarang);
$totalRows_listbarang = mysql_num_rows($listbarang);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.spray {
	text-align: center;
}
body {
	background-image: url(gambar/background%20index.png);
}
.header {
	font-family: Verdana, Geneva, sans-serif;
	color: #000;
	font-size: 18px;
}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <table width="800" height="501" border="1">
      <tr>
        <td width="140" height="64"><img src="gambar/Capture.PNG" width="140" height="112" /></td>
        <td colspan="2" bgcolor="#FFFF00" class="header"><MARQUEE align="center" direction="left" height="90" scrollamount="5" width="90%">SELAMAT DATANG DI SISTEM INFORMASI SEWA TENDA BERBASIS WEB </td>
      </tr>
      <tr>
        <td height="116"><img src="gambar/tenda.jpg" width="140" height="112" /></td>
        <td width="565" bgcolor="#009999"><div align="center">
          <p><a href="hal_login.php"><img src="gambar/login.PNG" width="192" height="56" /></a> <a href="hal_utama.php"><img src="gambar/Home.PNG" width="192" height="56" /></a></p>
        </div></td>
        <td width="73"><img src="gambar/T_ MERAH_REMPEL.JPG" width="140" height="112" /></td>
      </tr>
      <tr>
        <td bgcolor="#5C7F3F"><img src="gambar/ridge1.jpeg" width="140" height="112" /></td>
        <td rowspan="2" bgcolor="#00CC66"><p align="center">Selamat datang di sistem informasi sewa tenda berbasis web milik </p>
          <p align="center">Muhammad Bastian Hanafi </p>
          <p align="center">Untuk sewa tenda bisa menghubungi :</p>
          <p align="center">email : bastian.bt66@gmail.com</p>
        <p align="center">whatsapp : 0888888881234</p>
        <p align="center">daftar barang yang kami sewakan bisa anda lihat di bawah ini :</p>
        <p align="center">&nbsp;</p>
        <div align="center">
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
                <td><?php echo $row_listbarang['kode_tenda']; ?></td>
                <td><?php echo $row_listbarang['merk_tenda']; ?></td>
                <td><?php echo $row_listbarang['stok']; ?></td>
                <td><?php echo $row_listbarang['harga']; ?></td>
                <td><img src="img/<?php echo $row_listbarang['gambar']; ?>" alt="" width="100" height="100" /></td>
              </tr>
              <?php } while ($row_listbarang = mysql_fetch_assoc($listbarang)); ?>
          </table>
        </div></td>
        <td bgcolor="#D1CDAA"><img src="gambar/ridge.jpeg" width="140" height="112" /></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><img src="gambar/tendajamur.jpeg" width="140" height="112" /></td>
        <td bgcolor="#FFFFFF"><img src="gambar/tendajamur1.jpeg" width="140" height="112" /></td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#00CC99">Created by bt66</td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($listbarang);
?>
