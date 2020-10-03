<?php
if (isset($_GET['dataType'])) {
    $dataType = $_GET['dataType'];
    #echo $dataType;
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">

    <?php include "header.php"; ?>

    <body>

        <?php include"navmenu.php"; ?>

        <div class="container" id='mainContainer'>
            <input type='hidden' id='dataType' name='dataType' value='<?php echo $dataType; ?>' />
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
            <section id='tabs'>
                <div class='container'>
                    <p class="lead">{{dataType}} Menu</p>
                    <div class='row'>
                        <div class='container'>
                            <div class="row">
                                <div class='col-md'>
                                    <button class='btn btn-info' type='button' @click='generateQRCodes();'>Generate QR Codes</button>
                                    <button class='btn btn-primary' type='button' @click='printPDF()'>Print as PDF</button>
                                </div>
                                <div class='col-md text-right'>
                                    <button class='btn btn-warning' type='button' @click=''>Add New {{dataType}}</button>

                                </div>
                            </div>
                            <div class='row' v-if='!loading'>
                                <div class='col-md'>
                                    <table class='table table-striped table-responsive-md overflow-auto'>
                                        <thead>
                                            <tr>
                                                <td v-for='(data,index) in crudData[0]'>{{index}}</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for='row in crudData'>
                                                <td v-for='data in row' v-html='data'>{{data}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class='row align-middle text-center' v-else-if='loading'>
                                <div class='col-md text-center'>
                                    <h4 style='text-align:center' >Generating QR Codes</h4>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </section>

            <?php include"footer.php" ?> 
        </div>
        <script>
            var adminVue = new Vue({
                el: '#mainContainer',
                data: {
                    phpajaxresponsepage: './admin/admin.axios.php',
                    dataType: '',
                    loading: false,

                    crudData: ''
                },
                watch: {

                },
                methods: {
                    getListByDataType: function () {
                        this.loading = true;
                        axios.post(this.phpajaxresponsepage, {
                            action: 'getListByDataType',
                            dataType: this.dataType
                        }).then(function (response) {
                            console.log('on GetListByDataType');
                            console.log(response.data);
                            adminVue.crudData = response.data;
                            adminVue.loading = false;
                        });
                    },
                    generateQRCodes: function () {
                        this.loading = true;
                        axios.post(this.phpajaxresponsepage, {
                            action: 'generateQRCodes',
                            dataType: this.dataType
                        }).then(function (response) {
                            console.log('on generateQRCodes');
                            console.log(response.data);
                            window.alert(response.data);
                        }).then(function () {
                            adminVue.getListByDataType();
                            adminVue.loading = false;
                        });
                    },
                    printPDF: function (){
                        let dataType = this.dataType;
                        let url = './admin/pdf-print.php?datatype='+dataType;
                        window.open(url,"_blank");
                    }
                },
                beforeMount: function () {
                    let dataType = document.getElementById('dataType').value;
                    String.prototype.capitalize = function () {
                        return this.charAt(0).toUpperCase() + this.slice(1);
                    };
                    this.dataType = dataType.capitalize();

                },
                mounted: function () {
                    this.getListByDataType();
                }
            })
        </script>
    </body>
</html>