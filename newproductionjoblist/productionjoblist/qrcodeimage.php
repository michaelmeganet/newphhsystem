<?php
include_once("../include/phpqrcode-2010100721_1.1.4/phpqrcode/qrlib.php");

if(isset($_GET['code'])){
  $code = $_GET['code'];
  $code = urldecode($code);

  QRcode::png($code, '', '', 2, 0); //jobcode, output filename, error correction, each code square pixel, outside border range
}
?>