<?php
include_once("./class/phhdate.inc.php");

$objDate = new DateNow();

$currentPeriod_int = $objDate->intPeriod();
$currentPeriod_str = $objDate->strPeriod();
//for($i = $currentPeriod_int; $i >= $currentPeriod_int - 10 ; $i--){
//    
//    echo "          $i<br>";
//}
$EndYYYYmm = 2001;
$objPeriod = new generatePeriod($currentPeriod_int, $EndYYYYmm);
$setofPeriod = $objPeriod->generatePeriod3();
//print_r($setofPeriod);
//foreach($setofPeriod as $key=>$value) { 
//    
//    ${$key} = $value; 
//    echo "$key : $value\n"."<br>";
//
//            }
?>
<div class = 'form-group row'>
    <div class='col-sm-3'>
        <select class='custom-select' name="period" id="period" >
            <option value= "no"  selected> Select Period...</option>
            <?php
            foreach ($setofPeriod as $key => $value) {
                if (isset($period)) {
                    if ($value == $period) {
                        echo "<option value = \"$value\" selected>$value</option>";
                    } else {
                        echo"<option value = \"$value\">$value</option>";
                    }
                } else {
                    echo"<option value = \"$value\">$value</option>";
                }
            }
            ?>
            <!--                        <option value = "2002">2002</option>
                                    <option value = "2001">2001</option>
                                    <option value = "1912">1912</option>
                                    <option value = "1911">1911</option>-->
        </select>
    </div>
    <div class='col-sm-1 text-right'>

        <input class='btn btn-primary' type = "submit" value = "Next"/>
<!--                      <input type = "submit" name=  "get_period" id="get_period" value = "get period">-->
    </div>
</div>