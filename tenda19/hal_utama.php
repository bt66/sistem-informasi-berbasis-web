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
body {
	background-image: url(gambar/background%20hal%20utama.jpeg);
}
.isi {
	font-family: "Arial Black", Gadget, sans-serif;
	color: #000;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="801" height="228" border="1">
      <tr>
        <td width="140" height="116" bgcolor="#009966"><img src="gambar/Capture.PNG" width="140" height="140" /></td>
        <td width="645" bgcolor="#009999"><div align="center"><MARQUEE align="center" direction="left" height="90" scrollamount="5" width="90%">SELAMAT DATANG DI HALAMAN UTAMA SISTEM INFORMASI SEWA TENDA BERBASIS WEB</div></td>
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
        <td colspan="2" bgcolor="#FFFFFF" class="isi"><p align="center">Selamat datang di sistem informasi sewa tenda berbasis web</p>
        <p align="center">Silahkan lakukan input data,cari data ataupun cetak menggunakan menu yang telah di sediakan di atas.</p></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#009966">created by bt66</td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>