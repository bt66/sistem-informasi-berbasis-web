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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['txtuser'])) {
  $loginUsername=$_POST['txtuser'];
  $password=$_POST['txtpassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "hal_utama.php";
  $MM_redirectLoginFailed = "gagallogin.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_koneksitenda, $koneksitenda);
  
  $LoginRS__query=sprintf("SELECT username, password FROM tbladmin WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksitenda) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
	background-image: url(gambar/hal%20login.jpeg);
}
.putih {
	color: #666;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <div align="center">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="200" border="1">
      <tr>
        <td colspan="3" bgcolor="#00FF99"><div align="center">
          <p class="putih">HALAMAN LOGIN</p>
          <p><img src="gambar/login icon.jpeg" width="200" height="200" /> </p>
        </div></td>
      </tr>
      <tr bgcolor="#99FF99">
        <td width="59">Username</td>
        <td width="10">=</td>
        <td width="109"><label>
          <input name="txtuser" type="text" id="txtuser" size="25" maxlength="25" />
        </label></td>
      </tr>
      <tr bgcolor="#99FF99">
        <td>Password</td>
        <td>=</td>
        <td><label>
          <input name="txtpassword" type="password" id="txtpassword" size="25" maxlength="25" />
        </label></td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#009966"><label>
          <div align="center">
            <input type="submit" name="login" id="login" value="login" />
          </div>
        </label></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>