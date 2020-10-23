//packing/complete item
function getPackingCompleteItem() {  
  xmlhttpPKG = GetXmlHttpObjectPKG(); 
  
  if(xmlhttpPKG == null){ 
    alert ("Your browser does not support AJAX!"); 
    return; 
  }  
  
  var bid = document.getElementById("bid").value;
  var jn = document.getElementById("jobno");
  jobno = jn.value;
  
  var url="logisticdelivery/getPackingCompleteItem.php"; 
  url = url + "?bid=" + bid;
  url = url + "&jobno=" + encodeURIComponent(jobno);
  
  jn.value = "";
  jn.focus();

  xmlhttpPKG.onreadystatechange = function() { 
    if(xmlhttpPKG.readyState == 4 || xmlhttpPKG.readyState == "complete") { 
      document.getElementById('packingcompleteitem_data').innerHTML = xmlhttpPKG.responseText; 
    } 
  } 
  
  xmlhttpPKG.open("GET", url, true); 
  xmlhttpPKG.send(null); 
} 

function GetXmlHttpObjectPKG(){ 
  var xmlhttpPKG=null; 
  try{ 
    // Firefox, Opera 8.0+, Safari 
    xmlhttpPKG = new XMLHttpRequest(); 
  } 
  catch(e){ 
    // Internet Explorer 
    try{ 
      xmlhttpPKG = new ActiveXObject("Msxml2.XMLHTTP"); 
    } 
    catch(e){ 
      xmlhttpPKG = new ActiveXObject("Microsoft.XMLHTTP"); 
    } 
  } 
  
  return xmlhttpPKG; 
}


//delivery out
function getDeliveryOut() {  
  xmlhttpDOT = GetXmlHttpObjectDOT(); 
  
  if(xmlhttpDOT == null){ 
    alert ("Your browser does not support AJAX!"); 
    return; 
  }  
  
  var bid = document.getElementById("bid").value;
  var jn = document.getElementById("jobno");
  jobno = jn.value;
  //var dou = document.getElementById("dateout").value;
  
  var url="logisticdelivery/getDeliveryOut.php"; 
  url = url + "?bid=" + bid;
  url = url + "&jobno=" + encodeURIComponent(jobno);
  //url = url + "&dou=" + dou;
  
  jn.value = "";
  jn.focus();

  xmlhttpDOT.onreadystatechange = function() { 
    if(xmlhttpDOT.readyState == 4 || xmlhttpDOT.readyState == "complete") { 
      document.getElementById('deliveryout_data').innerHTML = xmlhttpDOT.responseText; 
    } 
  } 
  
  xmlhttpDOT.open("GET", url, true); 
  xmlhttpDOT.send(null); 
} 

function GetXmlHttpObjectDOT(){ 
  var xmlhttpDOT=null; 
  try{ 
    // Firefox, Opera 8.0+, Safari 
    xmlhttpDOT = new XMLHttpRequest(); 
  } 
  catch(e){ 
    // Internet Explorer 
    try{ 
      xmlhttpDOT = new ActiveXObject("Msxml2.XMLHTTP"); 
    } 
    catch(e){ 
      xmlhttpDOT = new ActiveXObject("Microsoft.XMLHTTP"); 
    } 
  } 
  
  return xmlhttpDOT; 
}

//delivery return
function getDeliveryReturn() {  
  xmlhttpDRN = GetXmlHttpObjectDRN(); 
  
  if(xmlhttpDRN == null){ 
    alert ("Your browser does not support AJAX!"); 
    return; 
  }  
  
  var bid = document.getElementById("bid").value;
  var jn = document.getElementById("jobno");
  jobno = jn.value;
  //var dre = document.getElementById("datereturn").value;
  
  var url="logisticdelivery/getDeliveryReturn.php"; 
  url = url + "?bid=" + bid;
  url = url + "&jobno=" + encodeURIComponent(jobno);
  //url = url + "&dre=" + dre;
  
  jn.value = "";
  jn.focus();

  xmlhttpDRN.onreadystatechange = function() { 
    if(xmlhttpDRN.readyState == 4 || xmlhttpDRN.readyState == "complete") { 
      document.getElementById('deliveryreturn_data').innerHTML = xmlhttpDRN.responseText; 
    } 
  } 
  
  xmlhttpDRN.open("GET", url, true); 
  xmlhttpDRN.send(null); 
} 

function GetXmlHttpObjectDRN(){ 
  var xmlhttpDRN=null; 
  try{ 
    // Firefox, Opera 8.0+, Safari 
    xmlhttpDRN = new XMLHttpRequest(); 
  } 
  catch(e){ 
    // Internet Explorer 
    try{ 
      xmlhttpDRN = new ActiveXObject("Msxml2.XMLHTTP"); 
    } 
    catch(e){ 
      xmlhttpDRN = new ActiveXObject("Microsoft.XMLHTTP"); 
    } 
  } 
  
  return xmlhttpDRN; 
}
