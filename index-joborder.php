<?php
if (isset($_GET['view'])) {
    $view = $_GET['view'];
} else {
    header('location: index.php');
}

switch ($view) {
    case 'bjc'://Batch Joblist Check
        $title = "Job Orders - Batch Check Joblist Scan";
        $url = "./joblistcheck/joblist-batchcheck.php";
        break;
}
?>


<?php include "header.php"; ?>

<body style='padding-bottom:10px'>

    <?php include"navmenu.php"; ?>

    <div class="container" id='mainContainer'>
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-6">
                    <h1>ADMINISTRATION MENU</h1>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-6">
                    <div class="sponsor">
                      <!-- <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?serve=CKYIE23N&placement=bootswatchcom" id="_carbonads_js"></script> -->
                    </div>
                </div>
            </div>
        </div>
        <p class='lead'><?php echo $title; ?></p>
        <div class='container'>
            <?php include_once $url; ?>
        </div>
    </div>
    <?php include"footer.php" ?> 
</body>