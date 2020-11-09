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
                            <!--  modal area  -->
                            <div class="modal fade  bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="reviseModal">
                                <div class="modal-dialog modal-xl" style="max-height:80%;height:auto;">
                                    <div class="modal-content">
                                        <div class='modal-header'>
                                            <h5 class="modal-title">{{modalTitle}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body' style='max-height: 90%;height:auto;overflow-y: scroll'>
                                            <div class='form-group' v-if='dataType === "Machine"'>
                                                <div class='row' v-show="modalType === 'edit'">
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>MCID</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_mcid' class='form-control' readonly/>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Machine ID</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_machineid' class='form-control' maxlength="5" />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Name</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_name' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Machine Model</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_model' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Machine No.</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_machine_no' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Index Per Hour</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_index_per_hour' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Max Table Load (Kg)</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_max_table_load_kg' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>QRCode</label>
                                                    </div>
                                                    <div class='col-md-3' v-html='mdl_qrcode'>
                                                        <img v-bind:src='mdl_qrcode' />
                                                    </div>
                                                    <div class='col-md-3 text-left'>
                                                        <label class='control-label label-important' v-if="modalType === 'edit'">After Update, QRCode must be generated again.</label>
                                                        <label class='control-label label-important' v-else>QRCode is generated via Menu.</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-group' v-if='dataType === "Staff"'>
                                                <div class='row' v-show="modalType === 'edit'">
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>SFID</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_sfid' class='form-control' readonly/>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Staff ID</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_staffid' class='form-control' maxlength="6" />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Name</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_name' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Division</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_division' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Status</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <select class='custom-select' v-model="mdl_status">
                                                            <option value="active">Active</option>
                                                            <option value="">Disabled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>Staff Level</label>
                                                    </div>
                                                    <div class='col-md-3'>
                                                        <input type='text' v-model='mdl_staff_level' class='form-control' />
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>
                                                        <label class='control-label'>QRCode</label>
                                                    </div>
                                                    <div class='col-md-3' v-html='mdl_qrcode'>
                                                        <img v-bind:src='mdl_qrcode' />
                                                    </div>
                                                    <div class='col-md-3 text-left'>
                                                        <label class='control-label label-important' v-if="modalType === 'edit'">After Update, QRCode must be generated again.</label>
                                                        <label class='control-label label-important' v-else>QRCode is generated via Menu.</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button @click="processData(modalType);clearData();" type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
                                            <button @click="clearData();"type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal area-->

                            <div class="row">
                                <div class='col-md'>
                                    <button class='btn btn-info' type='button' @click='generateQRCodes();'>Generate QR Codes</button>
                                    <button class='btn btn-primary' type='button' @click='printPDF()'>Print as PDF</button>
                                </div>
                                <div class='col-md text-right'>
                                    <button @click='modalType = "create"' data-toggle="modal" data-target=".bd-example-modal-lg" 
                                             class='btn btn-warning' type='button' >Add New {{dataType}}</button>

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
                                                <td v-if='dataType === "Machine"'>
                                                    <button @click='getDetails(row);modalType = "edit";' data-toggle="modal" data-target=".bd-example-modal-lg" type='button' class='btn btn-primary btn-sm'>Edit</button>
                                                    <button @click='getDetails(row);modalType = "delete";deleteData()' type='button' class='btn btn-danger btn-sm'>Delete</button>
                                                </td>
                                                <td v-else-if='dataType === "Staff"'>
                                                    <button @click='getDetails(row);modalType = "edit";' data-toggle="modal" data-target=".bd-example-modal-lg" type='button' class='btn btn-primary btn-sm'>Edit</button>
                                                    <button @click ='getDetails(row);modalType = "delete";deleteData()' type='button' class='btn btn-danger btn-sm'>Delete</button>
                                                </td>
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

        </div>
        <?php include"footer.php" ?> 
        <script>

            var adminVue = new Vue({
                el: '#mainContainer',
                data: {
                    phpajaxresponsepage: './admin/admin.axios.php',
                    dataType: '',
                    loading: false,
                    crudData: '',
                    //modalvariables
                    modalType: '',
                    mdl_division: '',
                    mdl_name: '',
                    mdl_qrcode: '',
                    mdl_sfid: '',
                    mdl_staff_level: '',
                    mdl_staffid: '',
                    mdl_status: '',
                    mdl_mcid: '',
                    mdl_machineid: '',
                    mdl_model: '',
                    mdl_machine_no: '',
                    mdl_index_per_hour: '',
                    mdl_max_table_load_kg: ''
                },
                computed: {
                    modalTitle: function () {
                        return this.dataType + ' Edit';
                    }
                },
                watch: {

                },
                methods: {
                    clearData: function () {
                        this.modalType = '';
                        this.mdl_division = '';
                        this.mdl_name = '';
                        this.mdl_qrcode = '';
                        this.mdl_sfid = '';
                        this.mdl_staff_level = '';
                        this.mdl_staffid = '';
                        this.mdl_status = '';
                        this.mdl_mcid = '';
                        this.mdl_machineid = '';
                        this.mdl_model = '';
                        this.mdl_machine_no = '';
                        this.mdl_index_per_hour = '';
                        this.mdl_max_table_load_kg = '';

                    },
                    processData: function (mdlType) {
                        let dataType = this.dataType;
                        axios.post(this.phpajaxresponsepage, {
                            action: 'processData',
                            dataType: dataType,
                            mdlType: mdlType,
                            division: this.mdl_division,
                            name: this.mdl_name,
                            qrcode: null,
                            sfid: this.mdl_sfid,
                            staff_level: this.mdl_staff_level,
                            staffid: this.mdl_staffid,
                            status: this.mdl_status,
                            mcid: this.mdl_mcid,
                            machineid: this.mdl_machineid,
                            model: this.mdl_model,
                            machine_no: this.mdl_machine_no,
                            index_per_hour: this.mdl_index_per_hour,
                            max_table_load_kg: this.mdl_max_table_load_kg
                        }).then(function (response) {
                            console.log('on processData');
                            console.log(response.data);
                            window.alert(response.data);
                        }).then(function () {
                            adminVue.getListByDataType();
                        });
                    },
                    deleteData: function () {
                        if (this.dataType === 'Machine') {
                            id = "Machine ID = " + this.mdl_machineid;
                        } else if (this.dataType === 'Staff') {
                            id = "Staff ID = " + this.mdl_staffid;
                        }
                        var resp = window.confirm("Are you sure you want to delete this data?\n" + id);
                        if (resp) {
                            this.processData('delete');
                        }
                    },
                    getDetails: function (data) {
                        console.log(data);
                        if (this.dataType === 'Staff') {
                            this.mdl_division = data.division;
                            this.mdl_name = data.name;
                            this.mdl_qrcode = data.qrcode;
                            this.mdl_sfid = data.sfid;
                            this.mdl_staff_level = data.staff_level;
                            this.mdl_staffid = data.staffid;
                            this.mdl_status = data.status;
                        } else if (this.dataType === 'Machine') {
                            this.mdl_mcid = data.mcid;
                            this.mdl_machineid = data.machineid;
                            this.mdl_name = data.name;
                            this.mdl_model = data.model;
                            this.mdl_machine_no = data.machine_no;
                            this.mdl_index_per_hour = data.index_per_hour;
                            this.mdl_max_table_load_kg = data.max_table_load_kg;
                            this.mdl_qrcode = data.qrcode;
                        }
                    },
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
                    printPDF: function () {
                        let dataType = this.dataType;
                        let url = './admin/pdf-print.php?datatype=' + dataType;
                        window.open(url, "_blank");
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