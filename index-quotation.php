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
$periodactive = 'active';
$periodtrue = 'true';


if (isset($_POST['period'])) {
    $period = $_POST['period'];
    $post_period = $period;
    $quotab = "quotation_pst_" . $period;
}
if (isset($period)) {
    $periodactive = '';
    $periodtrue = 'false';
    $customeractive = 'active';
    $customertrue = 'true';
}

if (isset($_POST['cid']) && isset($_POST['get_company'])) {
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
    echo "qid = $qid<br>";

    $customeractive = '';
    $customertrue = 'false';
    $createquoactive = 'active';
    $createquotrue = 'true';
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
                        <div class='container'>
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link <?php echo $periodactive; ?>"   id="nav-period-tab" data-toggle="tab" href="#nav-period"   role="tab" aria-controls="nav-period"   aria-selected="<?php echo $periodtrue; ?>">Period</a>
                                    <a class="nav-item nav-link  <?php echo $customeractive; ?>" id="nav-customer-tab"  data-toggle="tab" href="#nav-customer" role="tab" aria-controls="nav-customer" aria-selected="<?php echo $customertrue; ?>">Customer</a>
                                    <a class="nav-item nav-link <?php echo $createquoactive; ?>"    id="nav-createquo-tab"  data-toggle="tab" href="#nav-createquo" role="tab" aria-controls="nav-createquo" aria-selected="<?php echo $createquotrue; ?>">Create Quotation</a>
                                </div>
                            </nav>

                            <!--tab contents-->
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <!--Period Tab-->
                                <div class="tab-pane fade show <?php echo $periodactive; ?>" id="nav-period" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">Period</li>
                                    </ol>
                                    <div class='container text-left' > <!--Show Period Combo Box, this will return variable $period when submit-->
                                        <form action='' method='POST'>
                                            <?php include_once 'period-div.php'; ?>
                                        </form>
                                    </div>

                                </div>
                                <!--Customer tab-->
                                <div class="tab-pane fade show <?php echo $customeractive; ?>" id="nav-customer" role="tabpanel" aria-labelledby="nav-customer-tab">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" >Period</a></li>
                                        <li class="breadcrumb-item active">Customer</li>
                                    </ol>
                                    <div class="form-group text-right">
                                        <form action="" method="post">
                                            <input class="btn btn-outline-danger" type = "submit" name="reset_click" id="reset_click" value = "reset form">
                                        </form>
                                    </div>
                                    <div class='container text-left'>
                                        <?php
                                        if (isset($period)) {
                                            ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="period" id="period" value="<?php echo $period; ?>" />
                                                <?php
                                                include_once 'customer-div.php';
                                                ?>
                                            </form>
                                            <?php
                                        }else{
                                            echo "<h1>Not yet select period</h1>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!--create quotation tab-->
                                <div class="tab-pane fade show <?php echo $createquoactive; ?>" id="nav-createquo" role="tabpanel" aria-labelledby="nav-createquo-tab">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" >Period</a></li>
                                        <li class="breadcrumb-item"><a href="#" >Customer</a></li>
                                        <li class="breadcrumb-item active">Create Quotation</li>
                                    </ol>
                                    <div class="form-group text-right">
                                        <form action="" method="post">
                                            <input class="btn btn-outline-danger" type = "submit" name="reset_click" id="reset_click" value = "reset form">
                                        </form>
                                    </div>
                                    <?php
                                    if (isset($period) && isset($cid)){
                                    ?>
                                    <div class='form-group'>
                                        <form action="create-quotation-info.php" method="post" target="_blank">  
                                            <div class='row'>
                                                <div class='col-6'>
                                                    <table>
                                                        <tr>
                                                            <td>Operation User</td>
                                                            <td style=''>
                                                                <select class="custom-select" name="aid" id="aid" >
                                                                    <option value="100" selected >Administrator</option>
                                                                    <option value="101" >Usera</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Operation Branch</td>
                                                            <td>
                                                                <select class='custom-select' name="bid" id="bid" >
                                                                    <option value="1" selected >Cheras Jaya</option>
                                                                    <option value="2" >Puchong</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Company</td>
                                                            <td>
                                                                <select class='custom-select' name="com" id="com" >
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
                                                            <input class=" btn btn-info" type = "submit" name="create_quotation" id="create_quotation" value = "Create Quotation form">
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
                                        <!--        <a  href="create-quotation-info.php"  class="button button-purple mt-12 pull-right">Create Quotation</a> -->
                                        <h3>Quotation List

                                            <?php
                                            if (isset($period)) {

                                                echo "  of Period $period";
                                            }
                                            ?>

                                        </h3>
                                        <?php
                                        if (isset($_SESSION['message'])) {
                                            echo "<p class='custom-alert'>" . $_SESSION['message'] . "</p>";
                                            unset($_SESSION['message']);
                                        }
                                        ?>
                                        <h1>
                                            <?php
                                            if (isset($_POST['cid'])) {
                                                $post_cid = $_POST['cid'];
                                                echo $customername;
                                            } else {
                                                echo "Not yet select customer";
                                            }
                                            ?>
                                        </h1>
                                        <table class="table">
                                            <thead>
                                                <tr>

                                                    <th>Customer id</th>
                                                    <th>Quotation No</th>
                                                    <th>Date</th>
                                                    <th>Issued By</th>
                                                    <th class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST['cid']) && $quotation_list_numrows > 0) {
                                                    $rows = $quotation_list;
                                                    foreach ($rows as $row) {


//  while ($row = $student_list->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row["cid"] ?></td>
                                                            <td><?php echo $row["quono"] ?></td>
                                                            <td><?php echo $row["date"] ?></td>
                                                            <td><?php echo $row["pagetype"] ?></td>
                                                            <td class="text-right">
                                                                <a  href="<?php echo 'delete-quotation-info.php?id=' . $row["qid"] ?>" class="btn btn-danger btn-sm">Delete</a>
                                                                <a  href="<?php echo 'update-quotation-info.php?id=' . $row["qid"] ?>" class="btn btn-info btn-sm">Edit</a>
                                                                <a href="<?php echo 'read-quotation-info.php?id=' . $row["mqid"] ?>" class="btn btn-success btn-sm">View</a>
                                                            </td>
                                                        </tr>
                                                        <?php
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

    </body>
</html>

