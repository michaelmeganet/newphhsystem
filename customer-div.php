
<div class ='form-group row'>
    <div class="col-sm-4">

<!--        <select class="form-control input-lg select2" name="cid" id="cid" >-->
<!--        <select class="js-example-basic-single" name="cid" id="cid">-->
        <select class="custom-select" name="cid" id="cid">


            <?php
            $sqlcc = "SELECT * FROM customer_pst WHERE company='PST'"
                    . " AND status NOT LIKE 'deleted' ORDER BY co_name";
            $objSQL = new SQL($sqlcc);
            $resultm = $objSQL->getResultRowArray();
            foreach ($resultm as $rowm) {

//                                        echo "<a>{$rowm['co_name']}</a>";
                if (isset($cid)) {
                    if ($rowm['cid'] == $cid) {
                        echo "<option value='{$rowm['cid']}' selected>{$rowm['co_name']}</option>";
                    } else {
                        echo "<option value={$rowm['cid']}>{$rowm['co_name']}</option>";
                    }
                } else {
                    echo "<option value={$rowm['cid']}>{$rowm['co_name']}</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class='col-sm-1 text-right'>
        <input class='btn btn-primary' type = "submit" name="get_company" id="get_company" value = "(Next) Get Quotation Log">
    </div>
</div>