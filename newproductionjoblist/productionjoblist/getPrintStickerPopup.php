<?php
include_once("../include/mysql_connect.php");
//require_once("../include/session.php");
//include_once("../include/admin_check.php");
include_once '../../includes/dbh.inc.php';
include_once '../../includes/variables.inc.php';
session_start();

//cProductionJoblist('printsticker');

if ($_POST['year'] && $_POST['month'] && $_POST['day'] && $_POST['bid'] && $_POST['sid']) {

    $year = $_POST['year']; //year
    $month = $_POST['month']; //month
    $day = $_POST['day']; //date
    $bid = $_POST['bid']; //branch id

    $dat = $year . "-" . sprintf("%02d", $month) . "-" . sprintf("%02d", $day);
    $datdat = sprintf("%02d", substr($year, 2, 2)) . sprintf("%02d", $month);

    $protab = "production_scheduling" . $com . "_" . $datdat;

    if ($month == 12) {
        $yearnext = $year + 1;
        $monthnext = 1;
    } else {
        $yearnext = $year;
        $monthnext = $month + 1;
    }

    $datdatnext = sprintf("%02d", substr($yearnext, 2, 2)) . sprintf("%02d", $monthnext);
    $protabnext = "production_scheduling" . $com . "_" . $datdatnext;

    if ($month == 1) {
        $yearlast = $year - 1;
        $monthlast = 12;
    } else {
        $yearlast = $year;
        $monthlast = $month - 1;
    }

    $datdatlast = sprintf("%02d", substr($yearlast, 2, 2)) . sprintf("%02d", $monthlast);
    $protablast = "production_scheduling" . $com . "_" . $datdatlast;

    //$sqlbra = "SELECT * FROM branch_location WHERE bid = $bid";
    $sqlbra = "SELECT * FROM branch WHERE bid = $bid";
    $resultbra = $rundb->Query($sqlbra);
    $rowbra = $rundb->FetchArray($resultbra);

    foreach ($_POST['sid'] as $key => $value) {
        $sid[] = $value;
    }

    if ($sid[0] == "all") {
        $sqlpro = "SELECT * FROM $protab WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'
			   UNION ALL
			   SELECT * FROM $protablast WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'
			   UNION ALL
			   SELECT * FROM $protabnext WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'";
        $sqlpro .= " ORDER BY ABS(runningno), ABS(noposition)";

        $resultpro = $rundb->Query($sqlpro);

        if (!$resultpro) {
            $sqlpro = "SELECT * FROM $protab WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'
			     UNION ALL
			     SELECT * FROM $protablast WHERE date_issue = '$dat' AND (bid = $bid OR (operation = 1 OR operation = 3)) AND status = 'active'";
            $sqlpro .= " ORDER BY ABS(runningno), ABS(noposition)";

            $resultpro = $rundb->Query($sqlpro);
        }

        $no = 0;

        while ($rowpro = $rundb->FetchArray($resultpro)) {
            $sid[$no] = $rowpro['sid'];
            $no++;
        }
    }
    ?>

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
                    function printing() {
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

        <body onLoad="ClearPage();
                    printing();" onUnload="ResetPage();">

            <center>

                <?php
                for ($x = 0; $x < sizeof($sid); $x++) {
                    $found = 0;

                    $sqlpro = "SELECT * FROM $protab WHERE sid = $sid[$x]";
                    $resultpro = $rundb->Query($sqlpro);
                    $rowpro = $rundb->FetchArray($resultpro);
//                    echo "List Down \$rowpro array <br>";
//                    print_r($rowpro);
//                    echo "<br>";
                    $grade = $rowpro['grade'];
                    $sqlmat = "SELECT material from material WHERE materialcode = '$grade'";
                    $objSqlmat = new SQL($sqlmat);
                    $result = $objSqlmat->getResultOneRowArray();
                    $material = $result['material'];
                    // echo "\$material = $material <br>";
                    $fdt = $rowpo['fdt'];
                    $fdw = $rowpo['fdw'];
                    $fdl = $rowpo['fdl'];
                    $dimension = "$fdt X $fdw X $fdl";
                    // echo "\$dimension = $dimension <br>";
                    $process = $rowpo['process'];

                    if ($rowpro['date_issue'] != $dat) {
                        $sqlpro = "SELECT * FROM $protabnext WHERE sid = $sid[$x]";
                        $resultpro = $rundb->Query($sqlpro);
                        $rowpro = $rundb->FetchArray($resultpro);

                        if ($rowpro['date_issue'] != $dat) {
                            $sqlpro = "SELECT * FROM $protablast WHERE sid = $sid[$x]";
                            $resultpro = $rundb->Query($sqlpro);
                            $rowpro = $rundb->FetchArray($resultpro);

                            if ($rowpro['date_issue'] != $dat) {
                                $found = 0;
                            } else {
                                $found = 1;
                            }
                        } else {
                            $found = 1;
                        }
                    } else {
                        $found = 1;
                    }

                    if ($found == 1) {
                        $comyear = substr($rowpro['completion_date'], 2, 2);
                        $commonth = substr($rowpro['completion_date'], 5, 2);

                        $runningno = sprintf("%04d", $rowpro['runningno']);

                        if ($rowpro['noposition'] != "" && $rowpro['noposition'] != 0) {
                            $jobno = sprintf("%02d", $rowpro['noposition']);
                        } else {
                            $jobno = sprintf("%02d", $rowpro['jobno']);
                        }

                        $branchjoblist = $rowpro['jlfor'];

                        $quono = substr($rowpro['quono'], 0, 3);

                        //manual orderlist use quotation number to get date due to date of issue can be on october 2011 and replacement of the joblist can be on june 2011
                        if ($rowpro['omid'] != NULL && $rowpro['omid'] != "") {
                            $dateissue = substr($rowpro['quono'], 4, 4);
                        } else {
                            $yedat = substr($rowpro['date_issue'], 2, 2);
                            $modat = substr($rowpro['date_issue'], 5, 2);
                            $dateissue = $yedat . $modat;
                        }

                        if ($rowpro['additional'] == "Replacement") {
                            $additional = " (R)";
                            //$dateissue = substr($rowpro['quono'], 4, 4);
                        } else if ($rowpro['additional'] == "Amendment") {
                            $additional = " (A)";
                            //$dateissue = substr($rowpro['quono'], 4, 4);
                        } else {
                            $additional = "";
                        }

                        $sqlmat = "SELECT * FROM material WHERE materialcode = '{$rowpro[grade]}'";
                        $resultmat = $rundb->Query($sqlmat);
                        $rowmat = $rundb->FetchArray($resultmat);

                        if ($rowmat['shaft'] == "yes") { //begin if shaft item
                            if ($rowpro['process'] != "") {
                                if ($rowpro['fdt'] != "") {
                                    $fdt = $rowpro['fdt'];
                                } else {
                                    $fdt = $rowpro['mdt'];
                                }

                                if ($rowpro['fdl'] != "") {
                                    $fdl = $rowpro['fdl'];
                                } else {
                                    $fdl = $rowpro['mdl'];
                                }

                                $matdim = "{$rowmat['shaftindicator']} $fdt x $fdl";
                            } else {
                                $matdim = "{$rowmat['shaftindicator']} {$rowpro['mdt']} x {$rowpro['mdl']}";
                            }
                        } else {
                            if ($rowpro['process'] != "" && $rowpro['process'] != 1) {
                                if ($rowpro['fdt'] != "") {
                                    $fdt = $rowpro['fdt'];
                                } else {
                                    $fdt = $rowpro['mdt'];
                                }

                                if ($rowpro['fdw'] != "") {
                                    $fdw = $rowpro['fdw'];
                                } else {
                                    $fdw = $rowpro['mdw'];
                                }

                                if ($rowpro['fdl'] != "") {
                                    $fdl = $rowpro['fdl'];
                                } else {
                                    $fdl = $rowpro['mdl'];
                                }

                                $matdim = "$fdt x $fdw x $fdl";
                            } else {
                                $matdim = "{$rowpro['mdt']} x {$rowpro['mdw']} x {$rowpro['mdl']}";
                            }
                        }//end if shaft item
                    }//end if found
                    else {
                        $branchjoblist = "List not found.";
                    }

                    $combineCode = "[$branchjoblist" . " " . $quono . " " . $dateissue . " " . $runningno . " " . $jobno . " " . $additional . " " . $comyear . $commonth . "] ";
//                    $combineCode .= "| $matdim ";
//                    $combineCode .= "| $material ";
//                    $combineCode .= "| $process ";
                    //echo $combineCode . "<br>";
                    ?>
                    <table border="0" cellspacing="0" cellpadding="5" id="sticker">
                        <tr>
                            <td>
                                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" id="sticker2">
                                    <tr>
                                        <td width="5%" align="center" valign="bottom"><img src="qrcodeimage.php?code=<?php echo urlencode($combineCode) ?>"></td>
                                        <td width="100%" align="right" valign="top"><br />
                                            <?php echo date('d-m-Y', strtotime($rowpro['date_issue'])); ?><br />
                                            <?php echo "$branchjoblist $quono $dateissue $runningno $jobno $additional"; ?><br />
                                            <?php echo $matdim; ?><br />
                                            <?php echo $rowmat['material']; ?><br />
                                            <?php echo $rowpro['quantity']; ?><br />

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
                    <?php
                }
            }
            ?>
        </center>
    </body>
</html>
