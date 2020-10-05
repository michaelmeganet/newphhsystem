<?php
include_once 'class/dbh.inc.php';
include_once 'class/variables.inc.php';
include_once 'class/quotation.inc.php';
include_once 'class/customers.inc.php';
//to check debug $_POST
if (isset($_POST)) {
    foreach ($_POST as $key => $val) {
        debug_to_console($key . ' = ' . $val);
    }
}

if (isset($_POST['period'])) {
    debug_to_console('period posted');
    $period = $_POST['period'];
    $post_period = $period;
    #$quotab = "quotation_pst_" . $period;
    $quotab = "quotationnew_pst_" . $period;
}

if (isset($_POST['cid']) /* && isset($_POST['get_company']) */) {
    $cid = $_POST['cid'];
    $post_cid = $cid;
}
if (isset($post_cid)) {
    $quotation_obj = new QID($period, $post_cid);
    $quotation_list = $quotation_obj->quotation_list();
    $quotation_list_numrows = $quotation_obj->quotation_list_numrows();
    $com = 'PST';
    $objCus = new CustomerName($post_cid, $com);
    $customername = $objCus->getCustomerName();
    $qid = $quotation_obj->qid;
    #echo "qid = $qid<br>";
}
?>
<!DOCTYPE html>
<html lang="en">

    <?php include "header.php"; ?>

    <body>

        <?php include"navmenu.php"; ?>

        <div class="container">

            <div class="page-header" id="banner">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-6">
                        <h1>NEW PHHSYSTEM MAIN PAGE</h1>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-6">
                        <div class="sponsor">
                          <!-- <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYIE23N&placement=bootswatchcom" id="_carbonads_js"></script> -->
                        </div>
                    </div>
                </div>
            </div>
            <section id='tabs'>
                <div class='container'>
                    <p class="lead">Select menu from top to continue.</p>

                </div>
            </section>


        </div>
            <?php include"footer.php" ?>
    </body>
</html>


