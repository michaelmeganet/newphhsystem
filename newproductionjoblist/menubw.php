<?php

#include_once("include/mysql_connect.php");
include_once("includes/dbh.inc.php");
include_once("includes/variables.inc.php");
#session_start();
?>
<script type="text/JavaScript">
var timeout;
var seconds = 300;

//window.onload = resetTimer; //when windows loaded, start timer (use this only if it is put on HTML header)
resetTimer(); //when windows loaded, start timer (use this only if it is not used inside HTML header)

document.onkeypress = resetTimer; //when any key press, the time is reset and the functions reload again
document.onmousemove = resetTimer; //when mouse is moved, the time is reset and the functions reload again
 
function onUserInactivity(){
  location.href = 'index.php?view=vdp&jt=bw';
}

function resetTimer(){
  clearTimeout(timeout); //this clear the time each time the function is called
  timeout = setTimeout(onUserInactivity, 1000 * seconds); //redirect page in 60 seconds
}
</script>
<table width="100%" cellspacing="0" cellpadding="5" border="0" align="center" class="noprint">
  <?php  
  //begin of Production Joblist
  ?>
  <tr>
    <td id="tdtitle">Production Joblist</td>
  </tr>
    <tr>
      <td id="tdsubtitle"><a href="index.php?view=bws&page=scan" class="noline">Bandsaw Cut Start</a></td>
    </tr>
    <tr>
      <td id="tdsubtitle"><a href="index.php?view=bwe&page=scan" class="noline">Bandsaw Cut End</a></td>
    </tr>
     <tr>
      <td id="tdsubtitle"><a href="index.php" class="noline">Back to HOME</a></td>
    </tr>
    <tr>
      <td id="tdsubtitle">&nbsp;</td>
    </tr>
  <?php
  //end of Production Joblist
  ?>
</table>

<br />
