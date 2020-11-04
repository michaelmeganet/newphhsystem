function undoJobUpdate(poid, period, jobcode) {
    procVue.undoJobUpdate(poid, period, jobcode);
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
        proc_status: 'start',
        quantity: '',
        staffid: '',
        staff_response: '',
        machineid: '',
        machine_response: '',
        jobcode: '',
        jobcode_response: ''
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
                document.getElementById('machineid').focus();
            }
        },
        machineid: function () {
            if (this.inputmode === 'scan') {
                if (this.machineid.length == 5) {
                    this.getMachineName();
                }
            }
        },
        machine_response: function () {
            if (this.machine_response.indexOf('Cannot') >= 0) {
                this.machineid = '';
                document.getElementById('machineid').focus();
            } else {
                document.getElementById('quantity').focus();
            }
        },
        jobcode_response: function () {
            if (this.jobcode_response != '') {
                this.jobcode = '';
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
        getMachineName: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getMachineName',
                machineid: procVue.machineid
            }).then(function (response) {
                console.log('on getMachineName');
                console.log(response.data);
                procVue.machine_response = response.data;
            });
        },
        getJobUpdate: function () {
            axios.post(this.phpajaxresponsefile, {
                action: 'getJobUpdate',
                proc: procVue.proc,
                proc_status: procVue.proc_status,
                jobcode: procVue.jobcode,
                staffid: procVue.staffid,
                machineid: procVue.machineid,
                quantity: procVue.quantity
            }).then(function (response) {
                console.log('on getJobUpdate');
                console.log(response.data);
                procVue.jobcode_response = response.data.msg;
            });
        },
        undoJobUpdate: function (poid, period, jobcode) {
            axios.post(this.phpajaxresponsefile, {
                action: 'undoJobUpdate',
                poid: poid,
                period: period,
                jobcode: jobcode,
                proc_status: procVue.proc_status
            }).then(function (response) {
                console.log('on undoJobUpdate');
                console.log(response.data);
                procVue.jobcode_response = response.data;
            })
        },
        jobnoFocus: function () {
            document.getElementById('jobno').focus();
        }
    },
    beforeMount: function () {
        //Put codes needed before vue.js mount  
        this.staffid = document.getElementById('staffid').value;
        this.machineid = document.getElementById('machineid').value;
        this.jobno = document.getElementById('jobno').value;
        this.inputmode = document.getElementById('input_mode').value;
        this.proc = document.getElementById('proc').value;
    },
    mounted: function () {
        //put codes needed after vue.js is mounted
        document.getElementById('staffid').focus();
    }
});