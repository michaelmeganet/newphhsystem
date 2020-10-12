<?php
if (isset($_GET['view'])) {
    $view = $_GET['view'];
} else {
    header('location: index.php');
}

switch ($view) {
    case 'sop'://scheduling and output page
        $title = "KPI Menu - Job Scheduling and Output";
        $url = "./kpi-index/schedule_output.php";
        break;
    case 'mss'://Simplified Monthly Summary
        $title = "KPI Menu - Monthly Summary (Simple)";
        $url = "./kpi-index/summary-kpi-simple.php";
        break;
    case 'ssd'://Detailed Summary by Staff
        $title = "KPI Menu - Detail Summary by Staff";
        $url = "./kpi-index/summary-kpi.php";
        break;
    case 'msd'://Detailed Summary by Machine
        $title = "KPI Menu - Detail Summary by Machine";
        $url = "./kpi-index/summary-kpi-machine.php";
        break;
    case 'usd'://Detailed Estimated Summary by Unfinished jobs
        $title = "KPI Menu - Detail Estimated Summary by Unfinished Jobs";
        $url = "./kpi-index/summary-kpi-unfin.php";
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