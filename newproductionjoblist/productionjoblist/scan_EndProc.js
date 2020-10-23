
    function undoJobUpdate(poid,period,jobcode) {
        procVue.undoJobUpdate(poid,period,jobcode);
    }

    function resetForm() {
        procVue.staffid = '';
        procVue.staff_response = '';
        procVue.machineid = '';
        procVue.machine_response = '';
        procVue.jobcode = '';
        procVue.jobcode_response = '';
    }
    ;
    var procVue = new Vue({
        el: '#mainArea',
        data: {
            phpajaxresponsefile: 'backend/proc-scan.axios.php',
            inputmode: 'scan',

            proc: '',
            proc_status: 'end',
            staffid: '',
            staff_response: '',
            jobcode: '',
            jobcode_response: '',
            quantity: '',
            quantity_response: ''
        },
        watch: {
            //put variables detect here      
            staffid: function () {
                if (this.inputmode === 'scan') {
                    if (this.staffid.length == 6) {
                        this.getStaffName();
                    }
                }
            },
            staff_response: function () {
                if (this.staff_response.indexOf('Cannot') >= 0) {
                    this.staffid = '';
                    document.getElementById('staffid').focus();
                } else {
                    document.getElementById('jobno').focus();
                }
            },
            jobcode_response: function () {
                if (this.jobcode_response.indexOf('Cannot') >= 0) {
                    this.jobcode = '';
                    document.getElementById('jobno').focus();
                }
            },
            quantity_response: function(){
                if (this.inputmode === 'scan'){
                    this.jobcode = '';
                    this.jobcode_response = '';
                    document.getElementById('jobno').focus();
                }
            }
        },
        methods: {
            //put method/functions here
            getStaffName: function () {
                axios.post(this.phpajaxresponsefile, {
                    action: 'getStaffName',
                    staffid: procVue.staffid
                }).then(function (response) {
                    console.log('on getStaffName');
                    console.log(response.data);
                    procVue.staff_response = response.data;
                });
            },
            getParseJobCode: function () {
                axios.post(this.phpajaxresponsefile, {
                    action: 'getParseJobCode',
                    jobcode: procVue.jobcode
                }).then(function (response) {
                    console.log('on getParseJobCode');
                    console.log(response.data);
                    procVue.jobcode_response = response.data;
                });
            },
            getJobUpdate: function () {
                axios.post(this.phpajaxresponsefile, {
                    action: 'getJobUpdate',
                    proc: procVue.proc,
                    proc_status: procVue.proc_status,
                    jobcode: procVue.jobcode,
                    staffid: procVue.staffid,
                    quantity : procVue.quantity
                }).then(function (response) {
                    console.log('on getJobUpdate');
                    console.log(response.data);
                    procVue.quantity_response = response.data.msg;
                });
            },
            undoJobUpdate: function (poid,period,jobcode) {
                axios.post(this.phpajaxresponsefile,{
                    action:'undoJobUpdate',
                    poid: poid,
                    period: period,
                    jobcode: jobcode,
                    proc_status: procVue.proc_status
                }).then(function(response){
                    console.log('on undoJobUpdate');
                    console.log(response.data);
                    procVue.quantity_response = response.data;
                })
            }
        },
        beforeMount: function () {
            //Put codes needed before vue.js mount  
            this.staffid = document.getElementById('staffid').value;
            this.jobno = document.getElementById('jobno').value;
            this.inputmode = document.getElementById('input_mode').value;
            this.proc = document.getElementById('proc').value;
        },
        mounted: function () {
            //put codes needed after vue.js is mounted
            document.getElementById('staffid').focus();
        }
    });