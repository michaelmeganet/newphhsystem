

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle; ?></title>

<link type="text/css" rel="stylesheet" href="../include/printstyle.css">

<!-- MeadCo ScriptX -->
<object viewastext id="factory" style="display:none"
  classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814"
  codebase="../redist/smsx.cab#Version=6,5,439,50">
</object>

<script language="javascript">
function printing(){
  // -- basic features
  factory.printing.header = "";
  factory.printing.footer = "";
  factory.printing.portrait = true;
  //factory.printing.leftMargin = 0.0;
  //factory.printing.topMargin = 0.0;
  //factory.printing.rightMargin = 0.0;
  //factory.printing.bottomMargin = 0.0;
}
</script>

<script Language="vbscript">
  <!--
  Dim WSHShell
  //Dim myHeader
  //Dim myFooter
  Dim myMargintop
  Dim myMarginbottom
  Dim myMarginleft
  Dim myMarginright
  Dim Print_Background
  Dim Shrink_To_Fit
  Set WSHShell = CreateObject("WScript.Shell")
  //myHeader = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\header")
  //myFooter = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\footer")
  myMargintop = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_top")
  myMarginbottom = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_bottom")
  myMarginleft = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_left")
  myMarginright = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_right")
  Print_Background = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\Print_Background")
  Shrink_To_Fit = WSHShell.RegRead("HKCU\Software\Microsoft\Internet Explorer\PageSetup\Shrink_To_Fit")

  Sub ClearPage()
    //WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\header", ""
    //WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\footer", ""
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_top", "0.00000"
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_bottom", "0.00000"
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_left", "0.00000"
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_right", "0.00000"
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\Print_Background", "yes"
	WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\Shrink_To_Fit", "no"
  End Sub

  Sub ResetPage()
    //WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\header", myHeader
    //WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\footer", myFooter
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_top", myMargintop
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_bottom", myMarginbottom
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_left", myMarginleft
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\margin_right", myMarginright
    WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\Print_Background", Print_Background
	WSHShell.RegWrite "HKCU\Software\Microsoft\Internet Explorer\PageSetup\Shrink_To_Fit", Shrink_To_Fit
  End Sub
//-->
</script>

</head>

<body onLoad="ClearPage(); printing();" onUnload="ResetPage();">

<center>


<table border="0" cellspacing="0" cellpadding="5" id="sticker">
  <tr>
    <td>
      <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" id="sticker2">
        <tr>
          <td width="10%" align="center" valign="top">
          <td width="90%" align="right" valign="top"><br>
          <h3 align="left">PHHSYSTEM<br>Windows id:user <br>password: xyz1234</h3>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!--
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<table border="0" cellspacing="0" cellpadding="0" id="stickerspacing">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
-->

</center>
</body>
</html>
