<div class="navbar navbar-expand-md fixed-top navbar-dark bg-primary">
    <div class="container">
        <!-- <a href="../test.html" class="navbar-brand">Bootswatch</a> -->
        <img src="phhlogo2.png" alt="logo"> 
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item" active>
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle='dropdown' href="#" id="download">Administration<span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="admin">
                        <li class='dropdown-submenu'>
                            <a class='dropdown-item dropdown-toggle' href='#'>QR Code List <span class='caret'></span></a>
                            <ul class='dropdown-menu submenu'>
                                <li><a class="dropdown-item" href="index-administration.php?dataType=staff">Staff Menu</a></li>
                                <li><a class="dropdown-item" href="index-administration.php?dataType=machine">Machine Menu</a></li>
                            </ul>
                        </li>
                        <div class='dropdown-divider'></div>
                        <li class='dropdown-submenu'>
                            <a class='dropdown-item dropdown-toggle' href='#'>KPI Menu <span class="caret"></span></a>
                            <ul class='dropdown-menu submenu'>
                                <li><a class='dropdown-item' href='index-kpi.php?view=sop'>Job Scheduling and Output Details </a></li>
                                <li class="dropdown-submenu">
                                    <a class='dropdown-item dropdown-toggle' href='#'>Summary KPI</a>
                                    <ul class="dropdown-menu submenu">
                                        <li><a class="dropdown-item" href='index-kpi.php?view=mss'>Monthly Summary (Simple)</a></li>
                                        <div class='dropdown-divider'></div>
                                        <li><a class="dropdown-item" href='index-kpi.php?view=ssd'>Detail Summary by Staff</a></li>
                                        <li><a class="dropdown-item" href='index-kpi.php?view=sid'>Detail Summary by Staff (Interval)</a></li>
                                        <li><a class="dropdown-item" href='index-kpi.php?view=msd'>Detail Summary by Machine</a></li>
                                        <li><a class="dropdown-item" href='index-kpi.php?view=usd'>Detail Estimated Summary by Unfinished Jobs</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Quotation Menu <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="download">
                        <li><a class="dropdown-item" href="issuequotation.php">Issue Quotation</a></li>
                        <li><div class="dropdown-divider"></div></li>
                        <li><a class="dropdown-item" href="#" >View Quotation</a></li>
                        <li><a class="dropdown-item" href="#" >Quoation log</a></li>
                        <li><a class="dropdown-item" href="#" >Quoation Report</a></li>
                        <li><div class="dropdown-divider"></div></li>
                        <li><a class="dropdown-item" href="#" >Revise Quotation</a></li>
                        <li><a class="dropdown-item" href="#" >Search Quotation by quono </a></li>
                        <li><a class="dropdown-item" href="#" >Search Quotation by runningno</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Job Orders <span class="caret"></span></a>
                    <div class="dropdown-menu" aria-labelledby="Job">
                        <a class="dropdown-item" href="#">Issue Orderlsit</a>
                        <a class="dropdown-item" href="#">Revise Orderlsit</a>
                        <a class="dropdown-item" href="#">Orderlsit CRUD page</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Issue Joblist</a>
                        <a class="dropdown-item" href="#">Re-issue Joblist</a>
                        <a class="dropdown-item" href="#">View Joblist</a>
                        <a class="dropdown-item" href="#">Search Joblist by Job no</a>
                        <a class="dropdown-item" href="#">Search Joblist by running no</a>
                        <div class="dropdown-divider"></div>
                        <!-- <a class="dropdown-item" href="#">Production Schedule</a>
                        <a class="dropdown-item" href="#">Enquiry system</a> -->

                    </div>
                </li>            
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Production Control<span class="caret"></span></a>
                    <div class="dropdown-menu" aria-labelledby="download">
                        <div class="dropdown-menu" aria-labelledby="download">

                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" >Enter/Update Schedule</a>
                        <a class="dropdown-item" href="#" >View Schedule</a>
                        <a class="dropdown-item" href="#" >View Schedule Summary</a>                        
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" >View Outstanding Report </a>
                        <a class="dropdown-item" href="#" >View Pre-Machining summary Report </a>
                        <a class="dropdown-item" href="#" >View Daily Output </a>
                        <a class="dropdown-item" href="#" >Enter Tool Steel Joblist </a>
                        <a class="dropdown-item" href="#" >View Tool Steel Joblist</a>
                        <a class="dropdown-item" href="#" >Daily Production Target</a>
                        <a class="dropdown-item" href="#" >Daily Tool Steel Report</a>    

                    </div>
                </li>            
            </ul>

        </div>
    </div>
</div>