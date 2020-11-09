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
                        <h1>QUOTATION MENU</h1>
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
                    <p class="lead">Issue Quotation</p>
                    <div class='row'>
                        <div class='container' id='indexQuotation'>
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active"   id="nav-period-tab" data-toggle="tab" href="#nav-period"   role="tab" aria-controls="nav-period"   aria-selected="true"></a>
                                </div>
                            </nav>

                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-period" role="tabpanel" aria-labelledby="nav-period-tab">

                                    <div class="form-group">
                                        <div class="col-md text-right">
                                            <div class="form-group text-right">
                                                <form action="" method="post">
                                                    <input class="btn btn-outline-danger" type = "submit" name="reset_click" id="reset_click" onclick="sessionStorage.removeItem('customerList')" value = "reset form">
                                                </form>
                                            </div>
                                        </div>
                                        <form action='' method='POST'>
                                            <div class='row'>
                                                <div class='col-md-4'>
                                                    <label class="control-label">Period :</label>
                                                    <select class="custom-select" v-model='period' name='period' id="period">
                                                        <option v-for='data in periodList' v-bind:value='data'>{{data}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='row' v-show='showCustomer'>
                                                <div class='col-md-4'>
                                                    <label class="control-label">Customer :</label>
                                                </div>
                                            </div>
                                            <div class='row' v-show='showCustomer'>
                                                <div class='col-md-4'>
                                                    <select class="custom-select" v-model='post_cid' name='cid' id="cid">
                                                        <option v-for='data in customerList' v-bind:value='data.cid'>{{data.co_name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 align-bottom">
                                                    <input type='submit' class='btn btn-primary btn-block' id='submitCustomer' name='submitCustomer' value='Get Customer' />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <span>&nbsp;</span>
                                    <br />
                                    <span>&nbsp;</span>
                                    <?php
                                    if (isset($period) && isset($cid)) {
                                        ?>
                                        <div class='form-group'>
                                            <form action="create-quotation-info.php" method="post" target="CreateQuotationWindow" id='create_quotation_form'>
                                                <div class='row'>
                                                    <div class='col-sm-6'>
                                                        <table>
                                                            <tr>
                                                                <td>Operation User (This is Logged in user, later change this)</td>
                                                                <td style=''>
                                                                    <select v-model='aid'class="custom-select" name="aid" id="aid" >
                                                                        <option value="100" selected >Administrator</option>
                                                                        <option value="101" >Usera</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Operation Branch</td>
                                                                <td>
                                                                    <select v-model='bid'class='custom-select' name="bid" id="bid" >
                                                                        <option value="1" selected >Cheras Jaya</option>
                                                                        <option value="2" >Puchong</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Company</td>
                                                                <td>
                                                                    <select v-model="com" class='custom-select' name="com" id="com" >
                                                                        <option value="PST" selected >PHH METAL 1 S/B</option>
                                                                        <option value="PSVPMB" >MOULDBASE</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-6 text-right">

                                                        <div class='form-group'>
                                                            <?php
                                                            if (isset($cid)) {
                                                                ?>
                                                                <button type='button' class="btn btn-info" name='create_quotation' id='create_quotation' onclick='createQuotationbtn()'>(Next) Create Quotation</button>

                                                                <?php
                                                            } else {
                                                                ?>
                                                                <p align="right"><strong> Select one customer at the customer combo box </strong> </P>
                                                                <p align="right">then click the <strong>get customer quotation log button</strong></P>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="post_cid" name="post_cid" value=<?php
                                                if (isset($post_cid)) {
                                                    echo $post_cid;
                                                } else {
                                                    echo "";
                                                }
                                                ?>

                                                       />
                                                <input type="hidden" id="post_period" name="post_period" value=<?php
                                                if (isset($period)) {
                                                    echo $period;
                                                } else {
                                                    echo "";
                                                }
                                                ?>

                                                       />
                                                <input type="hidden" id="quotab" name="quotab" value=<?php
                                                if (isset($quotab)) {
                                                    echo $quotab;
                                                } else {
                                                    echo "";
                                                }
                                                ?>

                                                       />


                                            </form>
                                        </div>
                                        <div class="form-group">
                                            <div class='row'>
                                                <!--        <a  href="create-quotation-info.php"  class="button button-purple mt-12 pull-right">Create Quotation</a> -->
                                                <h5>Quotation List

                                                    <?php
                                                    if (isset($period)) {

                                                        echo "  of Period $period";
                                                    }
                                                    ?>

                                                </h5>
                                            </div>
                                            <div class='row'>
                                                <?php
                                                if (isset($_SESSION['message'])) {
                                                    echo "<p class='custom-alert'>" . $_SESSION['message'] . "</p>";
                                                    unset($_SESSION['message']);
                                                }
                                                ?>
                                                <div class="col-md">
                                                    <h3>
                                                        <?php
                                                        if (isset($_POST['cid'])) {
                                                            $post_cid = $_POST['cid'];
                                                            echo $customername;
                                                        } else {
                                                            echo "Not yet select customer";
                                                        }
                                                        ?>
                                                    </h3>
                                                </div>
                                                <div class="col-md text-right">
                                                    <button class="btn btn-warning" type="button" onclick="window.location.reload()">Refresh Table</button>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <table class="table table-responsive-sm">
                                                    <thead style='text-align:center'>
                                                        <tr>

                                                            <th>Customer id</th>
                                                            <th>Quotation No</th>
                                                            <th>Date</th>
                                                            <th>Issued By</th>
                                                            <th>Revised From:</th>
                                                            <th style='width:10%'>Issued To Quotation</th>
                                                            <th style='width:10%'>Orderlist Issued</th>
                                                            <th style='width:15%'>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style='text-align:center'>
                                                        <?php
                                                        if (isset($_POST['cid']) && $quotation_list_numrows > 0) {
                                                            $rows = $quotation_list;
                                                            $cnt = 0;
                                                            foreach ($rows as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $row["cid"]; ?></td>
                                                                    <td><?php echo $row["quono"]; ?></td>
                                                                    <td><?php echo $row["date"]; ?></td>
                                                                    <td><?php echo $row["name"]; ?></td>
                                                                    <td><?php echo $row["rev_parent"]; ?></td>
                                                                    <td><?php echo $row["issued_to_quotation"]; ?></td>
                                                                    <td><?php echo $row['od_issue']; ?> </td>

                                                                    <?php
                                                                    $issued_to_quotation = $row['issued_to_quotation'];
                                                                    if ($issued_to_quotation == 'yes') {
                                                                        ?>
                                                                        <td style='width:20%' class="text-right">
                                                                            <!--<a  target="_blank" href="<?php echo 'delete-quotation.php?cid=' . $row['cid'] . '&quono=' . $row["quono"] ?>" class="btn btn-danger btn-sm">Delete</a>-->
                                                                            <button type='button' class="btn btn-danger btn-sm" name='del_quotation' id='del_quotation' @click='deleteQuotation("<?php echo $row['quono']; ?>")' onclick=''>Delete</button>
                                                                            <form action='revise-quotation.php' method="get" target="ReviseQuotationWindow" id='reviseQuotationForm<?php echo $cnt; ?>' style='display: inline'>
                                                                                <input type='hidden' name='quono' id='quono' value='<?php echo $row['quono']; ?>' />
                                                                                <input type='hidden' name='post_cid' id='post_cid' value='<?php echo $post_cid; ?>' />
                                                                                <input type='hidden' name='post_period' id='post_period' value='<?php echo $post_period; ?>' />
                                                                                <input type='hidden' name='quotab' id='quotab' value='<?php echo $quotab; ?>' />
                                                                                <input type='hidden' name='bid' id='bid' v-model='bid'/>
                                                                                <input type='hidden' name='com' id='com' v-model='com' />
                                                                                <input type='hidden' name='print' id='print' value='quotation' />
                                                                                <button type='button' class="btn btn-info btn-sm" name='rev_quotation' id='rev_quotation' onclick='reviseQuotationBtn("<?php echo $cnt; ?>")'>Revise</button>
                                                                                <!--<input type='submit' class="btn btn-info btn-sm" value='Revise'/>
                                                                                <!--<a href="<?php //echo 'pdf-viewer.php?print=quotation&quono=' . $row['quono'] . '&post_cid=' . $post_cid . '&post_period=' . $post_period                     ?>" class="btn btn-success btn-sm">Print</a>-->
                                                                            </form>
                                                                            <a  target="_blank" href="<?php echo 'detail-quotation.php?cid=' . urlencode($row['cid']) . '&quono=' . urlencode($row["quono"]) ?>" class="btn btn-success btn-sm">View</a>
                                                                            <form action='calculation/testprintquotation.php' method="get" target="_blank">
                                                                                <input type='hidden' name='quono' id='quono' value='<?php echo $row['quono']; ?>' />
                                                                                <input type='hidden' name='post_cid' id='post_cid' value='<?php echo $post_cid; ?>' />
                                                                                <input type='hidden' name='post_period' id='post_period' value='<?php echo $post_period; ?>' />
                                                                                <input type='hidden' name='quotab' id='quotab' value='<?php echo $quotab; ?>' />
                                                                                <input type='hidden' name='bid' id='bid' v-model='bid'/>
                                                                                <input type='hidden' name='com' id='com' v-model='com' />
                                                                                <input type='hidden' name='print' id='print' value='quotation' />
                                                                                <input type='submit' class="btn btn-outline-light btn-sm" value='PrintQuotation'/>
                                                                                <!--<a href="<?php //echo 'pdf-viewer.php?print=quotation&quono=' . $row['quono'] . '&post_cid=' . $post_cid . '&post_period=' . $post_period                     ?>" class="btn btn-success btn-sm">Print</a>-->
                                                                            </form>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td class='text-right'>
                                                                            <form action="create-quotation-info.php" method="post" target="CreateQuotationWindow" id='continue_quotation_form<?php echo $cnt; ?>' >
                                                                                <input type='hidden' name='quono' id='quono' value='<?php echo $row['quono']; ?>' />
                                                                                <input type='hidden' name='continueQuotation' id='continueQuotation' value='true' />
                                                                                <input type='hidden' name='post_cid' id='post_cid' value='<?php echo $post_cid; ?>' />
                                                                                <input type='hidden' name='post_period' id='post_period' value='<?php echo $post_period; ?>' />
                                                                                <input type='hidden' name='quotab' id='quotab' value='<?php echo $quotab; ?>' />
                                                                                <input type='hidden' name='aid' id='aid' v-model='aid'/>
                                                                                <input type='hidden' name='bid' id='bid' v-model='bid'/>
                                                                                <input type='hidden' name='com' id='com' v-model='com' />
                                                                                <button type='button' class="btn btn-info btn-sm" name='cont_quotation' id='cont_quotation' onclick='continueQuotationbtn("<?php echo $cnt; ?>")'>Continue Process</button>
                                                                            </form>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tr>
                                                                <?php
                                                                $cnt++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                        } else {
                                            echo "<h1> Not yet select customer and / or period </h1>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>


            <?php include"footer.php" ?>
            <script src="./assets/jquery-2.1.1.min.js"></script>
            <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
                    <script src="./includes/select2/dist/js/select2.full.min.js"></script>
            -->
            <script>
                                                                    var w;
                                                                    var x;
                                                                    function createQuotationbtn() {

                                                                        console.log('button is pressed');
                                                                        if (!w || w.closed) {
                                                                            w = window.open('', 'CreateQuotationWindow');
                                                                            document.getElementById('create_quotation_form').submit();
                                                                        } else {
                                                                            window.alert("There's already an open Quotation Creation process. \n Please close the opened form first.");
                                                                        }
                                                                    }
                                                                    ;
                                                                    function continueQuotationbtn(id) {
                                                                        console.log('button is pressed');
                                                                        if (!w || w.closed) {
                                                                            w = window.open('', 'CreateQuotationWindow');
                                                                            document.getElementById('continue_quotation_form' + id).submit();
                                                                        } else {
                                                                            window.alert("There's already an open Quotation Creation process. \n Please close the opened form first.");
                                                                        }
                                                                    }
                                                                    ;
                                                                    function reviseQuotationBtn(id) {
                                                                        console.log('button is pressed');
                                                                        if (!x || x.closed) {
                                                                            x = window.open('', 'ReviseQuotationWindow');
                                                                            document.getElementById('reviseQuotationForm' + id).submit();
                                                                        } else {
                                                                            window.alert("There's already an open Revise Quotation process. \n Please close the opened form first.");
                                                                        }
                                                                    }
                                                                    ;
                                                                    var inVueData = {
                                                                        phpajaxresponsefile: './quotation.axios.php',
                                                                        showCustomer: false,
                                                                        period: '',
                                                                        post_cid: '',
                                                                        periodList: '',
                                                                        customerList: '',
                                                                        bid: 1,
                                                                        aid: 100,
                                                                        com: 'PST'

                                                                    },
                                                                            quotationindexapp = new Vue({
                                                                                el: '#indexQuotation',
                                                                                data: inVueData,
                                                                                watch: {
                                                                                    period: function () {
                                                                                        inVueData.showCustomer = true;
                                                                                    }
                                                                                },
                                                                                methods: {
                                                                                    getPeriod: function () {
                                                                                        axios.post(inVueData.phpajaxresponsefile, {
                                                                                            action: 'getPeriod'
                                                                                        }).then(function (response) {
                                                                                            console.log('On getPeriod function...');
                                                                                            console.log(response.data);
                                                                                            inVueData.periodList = response.data;
                                                                                        });
                                                                                    },
                                                                                    getCustomer: function () {
                                                                                        if (sessionStorage.getItem('customerList') == null) {
                                                                                            axios.post(inVueData.phpajaxresponsefile, {
                                                                                                action: 'getCustomer'
                                                                                            }).then(function (response) {
                                                                                                console.log('On getCustomer function...');
                                                                                                console.log(response.data);
                                                                                                sessionStorage.setItem('customerList', JSON.stringify(response.data));
                                                                                                console.log('Inserted data into Session Storage:');
                                                                                                console.log(JSON.parse(sessionStorage.getItem('customerList')));
                                                                                                console.log('transfering data into inVueData');
                                                                                                inVueData.customerList = JSON.parse(sessionStorage.getItem('customerList'));
                                                                                            });
                                                                                        }
                                                                                        if (sessionStorage.getItem('customerList') != null) {
                                                                                            console.log('transfering data into inVueData');
                                                                                            inVueData.customerList = JSON.parse(sessionStorage.getItem('customerList'));
                                                                                        }
                                                                                    },
                                                                                    deleteQuotation: function (quono) {
                                                                                        let delVal = confirm('Are you sure to delete this quotation [' + quono + '] ?\nThis cannot be undone!');
                                                                                        if (delVal) {
                                                                                            let cid = inVueData.post_cid;
                                                                                            let aid = inVueData.aid;
                                                                                            axios.post(inVueData.phpajaxresponsefile, {
                                                                                                action: 'deleteQuotation',
                                                                                                quono: quono,
                                                                                                cid: cid,
                                                                                                aid: aid
                                                                                            }).then(function (response) {
                                                                                                console.log(response.data);
                                                                                                alert(response.data);
                                                                                                window.location.reload();
                                                                                            });
                                                                                        }
                                                                                    }
                                                                                },
                                                                                mounted: function () {
                                                                                    this.getPeriod();
                                                                                    this.getCustomer();
                                                                                    if (document.getElementById('post_cid')) {
                                                                                        console.log('found cid already posted...');
                                                                                        inVueData.post_cid = document.getElementById('post_cid').value;
                                                                                    }
                                                                                    if (document.getElementById('post_period')) {
                                                                                        console.log('found period already posted...');
                                                                                        inVueData.period = document.getElementById('post_period').value;
                                                                                        inVueData.showCustomer = true;
                                                                                    }
                                                                                }
                                                                            });
            </script>
    </body>
</html>


