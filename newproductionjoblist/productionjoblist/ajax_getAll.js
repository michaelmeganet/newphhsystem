function convertTojobno(input) {
//    var x = input.value;
    //console.log("input = " + input);
    //console.log(typeof input);
    if (input.length <= 28 && input.charAt(0) != '['){
    //is old QRCode
        var jobno = input;
    }else if (input.length >= 26 && input.charAt(0) == '['){
    //is new QRCode
        var x = input;
        var res = x.match(/\[[a-zA-Z].+\]/);// take what ever string contianed in square  bracket []
        var str2 = res.toString();// convert the result to string
        var strbody = str2.replace('[', '');// teake out [
        var str3 = strbody.toString();// convert the result to string
        var jobno = str3.replace(']', '');// take out ]
    }
    return jobno;
}
//joblist start
function getJoblistStart() {
    xmlhttpJTS = GetXmlHttpObjectJTS();

    if (xmlhttpJTS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var ds = document.getElementById("datestart").value;

    var url = "productionjoblist/getJoblistStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&ds=" + ds;

    jn.value = "";
    jn.focus();

    xmlhttpJTS.onreadystatechange = function() {
        if (xmlhttpJTS.readyState == 4 || xmlhttpJTS.readyState == "complete") {
            document.getElementById('jobliststart_data').innerHTML = xmlhttpJTS.responseText;
        }
    }

    xmlhttpJTS.open("GET", url, true);
    xmlhttpJTS.send(null);
}

function GetXmlHttpObjectJTS() {
    var xmlhttpJTS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpJTS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpJTS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpJTS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpJTS;
}

//joblist end
function getJoblistEnd(jn) {
    xmlhttpJTE = GetXmlHttpObjectJTE();

    if (xmlhttpJTE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
//    jobno = jn.value;
    var jobno = convertTojobno(jn);

    var url = "productionjoblist/getJoblistEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);

    jbn.value = "";
    jbn.focus();

    xmlhttpJTE.onreadystatechange = function() {
        if (xmlhttpJTE.readyState == 4 || xmlhttpJTE.readyState == "complete") {
            document.getElementById('joblistend_data').innerHTML = xmlhttpJTE.responseText;
        }
    }

    xmlhttpJTE.open("GET", url, true);
    xmlhttpJTE.send(null);
}

function GetXmlHttpObjectJTE() {
    var xmlhttpJTE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpJTE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpJTE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpJTE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpJTE;
}


//bandsaw cut start
function getBandsawCutStart(jn) {
    xmlhttpBWS = GetXmlHttpObjectBWS();

    if (xmlhttpBWS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    // var sf = document.getElementById("sfid").value;
    var sf = document.getElementById("staffid").value;

    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getBandsawCutStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpBWS.onreadystatechange = function() {
        if (xmlhttpBWS.readyState == 4 || xmlhttpBWS.readyState == "complete") {
            document.getElementById('bandsawcutstart_data').innerHTML = xmlhttpBWS.responseText;
        }
    }

    xmlhttpBWS.open("GET", url, true);
    xmlhttpBWS.send(null);
}

function GetXmlHttpObjectBWS() {
    var xmlhttpBWS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpBWS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpBWS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpBWS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpBWS;
}


//bandsaw cut end
function getBandsawCutEnd(jn) {
    xmlhttpBWE = GetXmlHttpObjectBWE();

    if (xmlhttpBWE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getBandsawCutEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpBWE.onreadystatechange = function() {
        if (xmlhttpBWE.readyState == 4 || xmlhttpBWE.readyState == "complete") {
            document.getElementById('bandsawcutend_data').innerHTML = xmlhttpBWE.responseText;
        }
    }

    xmlhttpBWE.open("GET", url, true);
    xmlhttpBWE.send(null);
}

function GetXmlHttpObjectBWE() {
    var xmlhttpBWE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpBWE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpBWE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpBWE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpBWE;
}


//milling thickness start
function getMillingStart(jn) {
    xmlhttpMGS = GetXmlHttpObjectMGS();

    if (xmlhttpMGS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getMillingStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpMGS.onreadystatechange = function() {
        if (xmlhttpMGS.readyState == 4 || xmlhttpMGS.readyState == "complete") {
            document.getElementById('millingstart_data').innerHTML = xmlhttpMGS.responseText;
        }
    }

    xmlhttpMGS.open("GET", url, true);
    xmlhttpMGS.send(null);
}

function GetXmlHttpObjectMGS() {
    var xmlhttpMGS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMGS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMGS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMGS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMGS;
}


//milling width start
function getMillingWidthStart(jn) {
    xmlhttpMGS = GetXmlHttpObjectMGS();

    if (xmlhttpMGS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getMillingWidthStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpMGS.onreadystatechange = function() {
        if (xmlhttpMGS.readyState == 4 || xmlhttpMGS.readyState == "complete") {
            document.getElementById('millingwidthstart_data').innerHTML = xmlhttpMGS.responseText;
        }
    }

    xmlhttpMGS.open("GET", url, true);
    xmlhttpMGS.send(null);
}

function GetXmlHttpObjectMGS() {
    var xmlhttpMGS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMGS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMGS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMGS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMGS;
}


//milling length start
function getMillingLengthStart(jn) {
    xmlhttpMGS = GetXmlHttpObjectMGS();

    if (xmlhttpMGS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getMillingLengthStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpMGS.onreadystatechange = function() {
        if (xmlhttpMGS.readyState == 4 || xmlhttpMGS.readyState == "complete") {
            document.getElementById('millinglengthstart_data').innerHTML = xmlhttpMGS.responseText;
        }
    }

    xmlhttpMGS.open("GET", url, true);
    xmlhttpMGS.send(null);
}

function GetXmlHttpObjectMGS() {
    var xmlhttpMGS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMGS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMGS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMGS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMGS;
}


//milling end
function getMillingEnd(jn) {
    xmlhttpMGE = GetXmlHttpObjectMGE();

    if (xmlhttpMGE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getMillingEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpMGE.onreadystatechange = function() {
        if (xmlhttpMGE.readyState == 4 || xmlhttpMGE.readyState == "complete") {
            document.getElementById('millingend_data').innerHTML = xmlhttpMGE.responseText;
        }
    }

    xmlhttpMGE.open("GET", url, true);
    xmlhttpMGE.send(null);
}

function GetXmlHttpObjectMGE() {
    var xmlhttpMGE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMGE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMGE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMGE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMGE;
}


//milling width end
function getMillingWidthEnd(jn) {
    xmlhttpMGE = GetXmlHttpObjectMGE();

    if (xmlhttpMGE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getMillingWidthEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpMGE.onreadystatechange = function() {
        if (xmlhttpMGE.readyState == 4 || xmlhttpMGE.readyState == "complete") {
            document.getElementById('millingwidthend_data').innerHTML = xmlhttpMGE.responseText;
        }
    }

    xmlhttpMGE.open("GET", url, true);
    xmlhttpMGE.send(null);
}

function GetXmlHttpObjectMGE() {
    var xmlhttpMGE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMGE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMGE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMGE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMGE;
}


//milling length end
function getMillingLengthEnd(jn) {
    xmlhttpMGE = GetXmlHttpObjectMGE();

    if (xmlhttpMGE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getMillingLengthEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpMGE.onreadystatechange = function() {
        if (xmlhttpMGE.readyState == 4 || xmlhttpMGE.readyState == "complete") {
            document.getElementById('millinglengthend_data').innerHTML = xmlhttpMGE.responseText;
        }
    }

    xmlhttpMGE.open("GET", url, true);
    xmlhttpMGE.send(null);
}

function GetXmlHttpObjectMGE() {
    var xmlhttpMGE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMGE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMGE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMGE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMGE;
}


//rough grinding start
function getRoughGrindingStart(jn) {
    xmlhttpRGS = GetXmlHttpObjectRGS();

    if (xmlhttpRGS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    var jobno = convertTojobno(jn);
    //jobno = jn.value;
    var sf = document.getElementById("staffid").value;
    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getRoughGrindingStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpRGS.onreadystatechange = function() {
        if (xmlhttpRGS.readyState == 4 || xmlhttpRGS.readyState == "complete") {
            document.getElementById('roughgrindingstart_data').innerHTML = xmlhttpRGS.responseText;
        }
    }

    xmlhttpRGS.open("GET", url, true);
    xmlhttpRGS.send(null);
}

function GetXmlHttpObjectRGS() {
    var xmlhttpRGS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpRGS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpRGS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpRGS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpRGS;
}


//rough grinding end
function getRoughGrindingEnd(jn) {
    xmlhttpRGE = GetXmlHttpObjectRGE();

    if (xmlhttpRGE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getRoughGrindingEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpRGE.onreadystatechange = function() {
        if (xmlhttpRGE.readyState == 4 || xmlhttpRGE.readyState == "complete") {
            document.getElementById('roughgrindingend_data').innerHTML = xmlhttpRGE.responseText;
        }
    }

    xmlhttpRGE.open("GET", url, true);
    xmlhttpRGE.send(null);
}

function GetXmlHttpObjectRGE() {
    var xmlhttpRGE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpRGE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpRGE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpRGE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpRGE;
}


//precision grinding start
function getPrecisionGrindingStart(jn) {
    xmlhttpPGS = GetXmlHttpObjectPGS();

    if (xmlhttpPGS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getPrecisionGrindingStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpPGS.onreadystatechange = function() {
        if (xmlhttpPGS.readyState == 4 || xmlhttpPGS.readyState == "complete") {
            document.getElementById('precisiongrindingstart_data').innerHTML = xmlhttpPGS.responseText;
        }
    }

    xmlhttpPGS.open("GET", url, true);
    xmlhttpPGS.send(null);
}

function GetXmlHttpObjectPGS() {
    var xmlhttpPGS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpPGS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpPGS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpPGS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpPGS;
}


//precision grinding end
function getPrecisionGrindingEnd(jn) {
    xmlhttpPGE = GetXmlHttpObjectPGE();

    if (xmlhttpPGE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getPrecisionGrindingEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpPGE.onreadystatechange = function() {
        if (xmlhttpPGE.readyState == 4 || xmlhttpPGE.readyState == "complete") {
            document.getElementById('precisiongrindingend_data').innerHTML = xmlhttpPGE.responseText;
        }
    }

    xmlhttpPGE.open("GET", url, true);
    xmlhttpPGE.send(null);
}

function GetXmlHttpObjectPGE() {
    var xmlhttpPGE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpPGE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpPGE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpPGE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpPGE;
}


//cnc machining start
function getCNCMachiningStart(jn) {
    xmlhttpCMS = GetXmlHttpObjectCMS();

    if (xmlhttpCMS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getCNCMachiningStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpCMS.onreadystatechange = function() {
        if (xmlhttpCMS.readyState == 4 || xmlhttpCMS.readyState == "complete") {
            document.getElementById('cncmachiningstart_data').innerHTML = xmlhttpCMS.responseText;
        }
    }

    xmlhttpCMS.open("GET", url, true);
    xmlhttpCMS.send(null);
}

function GetXmlHttpObjectCMS() {
    var xmlhttpCMS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpCMS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpCMS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpCMS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpCMS;
}


//cnc machining end
function getCNCMachiningEnd(jn) {
    xmlhttpCME = GetXmlHttpObjectCME();

    if (xmlhttpCME == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    //jobno = jn.value;
    var jobno = convertTojobno(jn);
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getCNCMachiningEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpCME.onreadystatechange = function() {
        if (xmlhttpCME.readyState == 4 || xmlhttpCME.readyState == "complete") {
            document.getElementById('cncmachiningend_data').innerHTML = xmlhttpCME.responseText;
        }
    }

    xmlhttpCME.open("GET", url, true);
    xmlhttpCME.send(null);
}

function GetXmlHttpObjectCME() {
    var xmlhttpCME = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpCME = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpCME = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpCME = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpCME;
}


//view joblist summary
function getViewJoblistSummary() {
    xmlhttpVJS = GetXmlHttpObjectVJS();

    if (xmlhttpVJS == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var ye = document.getElementById("year");
    var year = ye.options[ye.selectedIndex].value;

    var mo = document.getElementById("month");
    var month = mo.options[mo.selectedIndex].value;

    var da = document.getElementById("day");
    var day = da.options[da.selectedIndex].value;

    var bid = document.getElementById("bid").value;

    var url = "productionjoblist/getViewJoblistSummary.php";
    url = url + "?ye=" + year;
    url = url + "&mo=" + month;
    url = url + "&da=" + day;
    url = url + "&bid=" + bid;

    xmlhttpVJS.onreadystatechange = function() {
        if (xmlhttpVJS.readyState == 4 || xmlhttpVJS.readyState == "complete") {
            document.getElementById('viewjoblistsummary_data').innerHTML = xmlhttpVJS.responseText;
        }
    }

    xmlhttpVJS.open("GET", url, true);
    xmlhttpVJS.send(null);
}

function GetXmlHttpObjectVJS() {
    var xmlhttpVJS = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpVJS = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpVJS = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpVJS = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpVJS;
}


//view daily production target
function getViewDailyProductionTarget(viewnumber) {
    xmlhttpVDP = GetXmlHttpObjectVDP();

    if (xmlhttpVDP == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var year = document.getElementById("year").value;
    var month = document.getElementById("month").value;
    var day = document.getElementById("day").value;
    var jobtype = document.getElementById("jobtype" + viewnumber).value;
    var bid = document.getElementById("bid").value;

    var url = "productionjoblist/getViewDailyProductionTarget.php";
    url = url + "?ye=" + year;
    url = url + "&mo=" + month;
    url = url + "&da=" + day;
    url = url + "&jt=" + jobtype;
    url = url + "&bid=" + bid;

    xmlhttpVDP.onreadystatechange = function() {
        if (xmlhttpVDP.readyState == 4 || xmlhttpVDP.readyState == "complete") {
            document.getElementById('viewdailyproductiontarget' + viewnumber + '_data').innerHTML = xmlhttpVDP.responseText;
        }
    }

    xmlhttpVDP.open("GET", url, true);
    xmlhttpVDP.send(null);
}

function GetXmlHttpObjectVDP() {
    var xmlhttpVDP = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpVDP = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpVDP = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpVDP = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpVDP;
}


//print sticker
function getPrintSticker() {
    xmlhttpPSR = GetXmlHttpObjectPSR();

    if (xmlhttpPSR == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var ye = document.getElementById("year");
    var year = ye.options[ye.selectedIndex].value;

    var mo = document.getElementById("month");
    var month = mo.options[mo.selectedIndex].value;

    var da = document.getElementById("day");
    var day = da.options[da.selectedIndex].value;

    var bid = document.getElementById("bid").value;

    var url = "productionjoblist/getPrintSticker.php";
    url = url + "?ye=" + year;
    url = url + "&mo=" + month;
    url = url + "&da=" + day;
    url = url + "&bid=" + bid;

    xmlhttpPSR.onreadystatechange = function() {
        if (xmlhttpPSR.readyState == 4 || xmlhttpPSR.readyState == "complete") {
            document.getElementById('printsticker_data').innerHTML = xmlhttpPSR.responseText;
        }
    }

    xmlhttpPSR.open("GET", url, true);
    xmlhttpPSR.send(null);
}

function GetXmlHttpObjectPSR() {
    var xmlhttpPSR = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpPSR = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpPSR = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpPSR = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpPSR;
}


//staff id
function getStaffID(sfid) {
    xmlhttpSFI = GetXmlHttpObjectSFI();

    if (xmlhttpSFI == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var sfi = document.getElementById("staffid");
    //sfid = sfi.value;

    var url = "productionjoblist/getStaffID.php";
    url = url + "?sfid=" + sfid;

    xmlhttpSFI.onreadystatechange = function() {
        if (xmlhttpSFI.readyState == 4 || xmlhttpSFI.readyState == "complete") {
            document.getElementById('staffid_data').innerHTML = xmlhttpSFI.responseText;

            var sffd = document.getElementById("stafffound");
            var mcid = document.getElementById("machineid");

            if (sffd.value == "yes") {
                mcid.focus();
            } else {
                sfi.value = "";
                sfi.focus();
            }
        }
    }

    xmlhttpSFI.open("GET", url, true);
    xmlhttpSFI.send(null);
}

function GetXmlHttpObjectSFI() {
    var xmlhttpSFI = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpSFI = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpSFI = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpSFI = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpSFI;
}


//staff id end
function getStaffIDEnd(sfid) {
    xmlhttpSFIE = GetXmlHttpObjectSFIE();

    if (xmlhttpSFIE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var sfi = document.getElementById("staffid");
    //sfid = sfi.value;

    var url = "productionjoblist/getStaffID.php";
    url = url + "?sfid=" + sfid;

    xmlhttpSFIE.onreadystatechange = function() {
        if (xmlhttpSFIE.readyState == 4 || xmlhttpSFIE.readyState == "complete") {
            document.getElementById('staffid_data').innerHTML = xmlhttpSFIE.responseText;

            var sffd = document.getElementById("stafffound");
            var jbno = document.getElementById("jobno");

            if (sffd.value == "yes") {
                jbno.focus();
            } else {
                sfi.value = "";
                sfi.focus();
            }
        }
    }

    xmlhttpSFIE.open("GET", url, true);
    xmlhttpSFIE.send(null);
}

function GetXmlHttpObjectSFIE() {
    var xmlhttpSFIE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpSFIE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpSFIE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpSFIE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpSFIE;
}


//machine id
function getMachineID(mcid) {
    xmlhttpMCI = GetXmlHttpObjectMCI();

    if (xmlhttpMCI == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var mci = document.getElementById("machineid");
    //mcid = mci.value;

    var url = "productionjoblist/getMachineID.php";
    url = url + "?mcid=" + mcid;

    xmlhttpMCI.onreadystatechange = function() {
        if (xmlhttpMCI.readyState == 4 || xmlhttpMCI.readyState == "complete") {
            document.getElementById('machineid_data').innerHTML = xmlhttpMCI.responseText;

            var mcfd = document.getElementById("machinefound");
            var jbno = document.getElementById("jobno");

            if (mcfd.value == "yes") {
                jbno.focus();
            } else {
                mci.value = "";
                mci.focus();
            }
        }
    }

    xmlhttpMCI.open("GET", url, true);
    xmlhttpMCI.send(null);
}

function GetXmlHttpObjectMCI() {
    var xmlhttpMCI = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMCI = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMCI = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMCI = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMCI;
}

//jobno end
function getJobNoEnd(jn) {
    xmlhttpJNE = GetXmlHttpObjectJNE();

    if (xmlhttpJNE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var jno = document.getElementById("jobno");
    //jno = jno.value;
    var jobno = convertTojobno(jn);

    var bid = document.getElementById("bid").value;

    var url = "productionjoblist/getJobNo.php";
    url = url + "?jobno=" + encodeURIComponent(jobno);
    url = url + "&bid=" + bid;

    xmlhttpJNE.onreadystatechange = function() {
        if (xmlhttpJNE.readyState == 4 || xmlhttpJNE.readyState == "complete") {
            document.getElementById('jobno_data').innerHTML = xmlhttpJNE.responseText;

            var jnofd = document.getElementById("jobnofound");
            var qty = document.getElementById("quantity");

            if (jnofd.value == "yes") {
                qty.focus();
            } else {
                jno.value = "";
                jno.focus();
            }
        }
    }

    xmlhttpJNE.open("GET", url, true);
    xmlhttpJNE.send(null);
}

function GetXmlHttpObjectJNE() {
    var xmlhttpJNE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpJNE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpJNE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpJNE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpJNE;
}


//jobno end quantity
function getJobNoCFQ(jn) {
    xmlhttpJNEQ = GetXmlHttpObjectJNEQ();

    if (xmlhttpJNEQ == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var jbn = document.getElementById("jobno");
    var jobno = convertTojobno(jn);
    var bid = document.getElementById("bid").value;

    var url = "productionjoblist/getJobNo.php";
    url = url + "?jobno=" + encodeURIComponent(jobno);
    url = url + "&bid=" + bid;

    xmlhttpJNEQ.onreadystatechange = function() {
        if (xmlhttpJNEQ.readyState == 4 || xmlhttpJNEQ.readyState == "complete") {
            document.getElementById('jobno_data').innerHTML = xmlhttpJNEQ.responseText;

            var jnofd = document.getElementById("jobnofound");

            if (jnofd.value == "yes") {
                //do nothing
            } else {
                jbn.value = "";
                jbn.focus();
            }
        }
    }

    xmlhttpJNEQ.open("GET", url, true);
    xmlhttpJNEQ.send(null);
}

function GetXmlHttpObjectJNEQ() {
    var xmlhttpJNEQ = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpJNEQ = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpJNEQ = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpJNEQ = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpJNEQ;
}


//change finishing quantity
function getChangeFinishingQuantity(jn) {
    xmlhttpCFQ = GetXmlHttpObjectCFQ();

    if (xmlhttpCFQ == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var jobtype = document.getElementById("jobtype");  //customer id
    var jte = jobtype.options[jobtype.selectedIndex].value;

    var sfid = document.getElementById("staffid").value;
    //var jn = document.getElementById("jobno").value;
    var jno = convertTojobno(jn);
    var bid = document.getElementById("bid").value;

    var url = "productionjoblist/getChangeFinishingQuantity.php";
    url = url + "?jte=" + jte;
    url = url + "&sfid=" + sfid;
    url = url + "&jno=" + encodeURIComponent(jno);
    url = url + "&bid=" + bid;

    xmlhttpCFQ.onreadystatechange = function() {
        if (xmlhttpCFQ.readyState == 4 || xmlhttpCFQ.readyState == "complete") {
            document.getElementById('changefinishingquantity_data').innerHTML = xmlhttpCFQ.responseText;
        }
    }

    xmlhttpCFQ.open("GET", url, true);
    xmlhttpCFQ.send(null);
}

function GetXmlHttpObjectCFQ() {
    var xmlhttpCFQ = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpCFQ = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpCFQ = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpCFQ = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpCFQ;
}


function handleEnter(functype, jobno, event) {
    var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

    if (keyCode == 13) {
        functype(jobno);
        return false;
    } else
        return true;
}

//bandsaw cut start
function getManualCutStart(jn) {
    xmlhttpMNC = GetXmlHttpObjectMNC();

    if (xmlhttpMNC == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    var jobno = convertTojobno(jn);
    //jobno = jn.value;
    var sf = document.getElementById("staffid").value;
    var mc = document.getElementById("mcid").value;

    var url = "productionjoblist/getManualCutStart.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&mc=" + mc;

    jbn.value = "";
    jbn.focus();

    xmlhttpMNC.onreadystatechange = function() {
        if (xmlhttpMNC.readyState == 4 || xmlhttpMNC.readyState == "complete") {
            document.getElementById('manualcutstart_data').innerHTML = xmlhttpMNC.responseText;
        }
    }

    xmlhttpMNC.open("GET", url, true);
    xmlhttpMNC.send(null);
}

function GetXmlHttpObjectMNC() {
    var xmlhttpMNC = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMNC = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMNC = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMNC = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMNC
}


//bandsaw cut end
function getManualCutEnd(jn) {
    xmlhttpMNE = GetXmlHttpObjectMNE();

    if (xmlhttpMNE == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var bid = document.getElementById("bid").value;
    var jbn = document.getElementById("jobno");
    var jobno = convertTojobno(jn);
    //jobno = jn.value;
    var sf = document.getElementById("staffid").value;
    var qt = document.getElementById("quantity");

    var url = "productionjoblist/getManualCutEnd.php";
    url = url + "?bid=" + bid;
    url = url + "&jobno=" + encodeURIComponent(jobno);
    url = url + "&sf=" + sf;
    url = url + "&qt=" + qt.value;

    qt.value = "";
    jbn.value = "";
    jbn.focus();

    xmlhttpMNE.onreadystatechange = function() {
        if (xmlhttpMNE.readyState == 4 || xmlhttpMNE.readyState == "complete") {
            document.getElementById('manualcutend_data').innerHTML = xmlhttpMNE.responseText;
        }
    }

    xmlhttpMNE.open("GET", url, true);
    xmlhttpMNE.send(null);
}

function GetXmlHttpObjectMNE() {
    var xmlhttpMNE = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlhttpMNE = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlhttpMNE = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlhttpMNE = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    return xmlhttpMNE;
}
