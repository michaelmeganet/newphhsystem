<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class='container'>
        <b-navbar toggleable="lg" type="light" variant="info">
            <b-navbar-brand href="#">NavBar</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item href="#">Link</b-nav-item>
                    <b-nav-item href="#" disabled>Disabled</b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-form>
                        <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                        <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                    </b-nav-form>

                    <b-nav-item-dropdown text="Lang" right>
                        <b-dropdown-item href="#">EN</b-dropdown-item>
                        <b-dropdown-item href="#">ES</b-dropdown-item>
                        <b-dropdown-item href="#">RU</b-dropdown-item>
                        <b-dropdown-item href="#">FA</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>User</em>
                        </template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</div>
<!--
<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">
<!-- <a href="../test.html" class="navbar-brand">Bootswatch</a> -
<img src="phhlogo2.png" alt="logo"> 
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarResponsive">
  <ul class="navbar-nav">
    
    <li class="nav-item" active>
      <a class="nav-link" href="#">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Administration</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Quotation Menu <span class="caret"></span></a>
      <div class="dropdown-menu" aria-labelledby="download">
        <a class="dropdown-item" href="issuequotation.php">Issue Quotation</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" >View Quotation</a>
        <a class="dropdown-item" href="#" >Quoation log</a>
        <a class="dropdown-item" href="#" >Quoation Report</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" >Revise Quotation</a>
        <a class="dropdown-item" href="#" >Search Quotation by quono </a>
        <a class="dropdown-item" href="#" >Search Quotation by runningno</a>
      </div>
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
<a class="dropdown-item" href="#">Enquiry system</a> -

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