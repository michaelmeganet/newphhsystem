//login
function login_validator(lin){
  if(lin.username.value == ""){
	alert("Please enter Username!");
	lin.username.focus();
	return(false);
  }
  
  if(lin.password.value == ""){
	alert("Please enter Password!");
	lin.password.focus();
	return(false);
  }
  
  return (true);
}


//function check customer
function checkCoName(){
  var cne = document.getElementById("co_name");
  
  if(cne.value == "co name"){
	cne.value = "";  
  }
}

/*
function checkCoNo(){
  var cno = document.getElementById("co_no");
  
  if(cno.value == "co no."){
	cno.value = "";  
  }
}
*/

function checkQuoNoFro(){
  var qnf = document.getElementById("quotationnofront");
  
  if(qnf.value == "xxx"){
	qnf.value = "";  
  }
}

function checkAdd1(){
  var add1 = document.getElementById("address1");
  
  if(add1.value == "address1"){
	add1.value = "";  
  }
}

function checkCountry(){
  var cry = document.getElementById("country");
  
  if(cry.value == "country"){
	cry.value = "";  
  }
}


//issue manual orderlist
function issuemanualorderlist_validator(imo){	
  if(imo.cid.value == "" && imo.cid2.value == ""){
	alert("Please select Company!");
	imo.cid.focus();
	return(false);
  }
  
  if(imo.runningno.value == ""){
	alert("Please enter Running No!");
	imo.runningno.focus();
	return(false);
  }
  
  var material = document.getElementById("material" + 1).value;
  
  if(material == ""){
	alert("Please select Grade!");
	return(false);
  }
  
  var mdt = document.getElementById("mdt" + 1).value;
  
  if(mdt == ""){
	alert("Please select Material Dimension Thickness!");
	return(false);
  }
  
  var mdl = document.getElementById("mdl" + 1).value;
  
  if(mdl == ""){
	alert("Please enter Material Dimension Length!");
	return(false);
  }
  
  if(material && mdt && mdl != ""){
    var agree=confirm("Are you sure you wish to submit this Quotation?");
      if(agree)
        return true;
      else
        return false;
  }
  
  return (true);
}


//issue quotation
function issuequotation_validator(iqn){	
  if(iqn.cid.value == "" && iqn.cid2.value == ""){
	alert("Please select Company!");
	iqn.cid.focus();
	return(false);
  }
  
  if(iqn.cid2.value != ""){
	if(iqn.cust_type.value == "new"){
      if(iqn.co_name.value == "" || iqn.co_name.value == "co name"){
	    alert("Please enter Company Name!");
	    iqn.co_name.focus();
	    return(false);
      }
		
	  /*
      if(iqn.co_no.value == "" || iqn.co_no.value == "co no."){
	    alert("Please enter Company Registration No.!");
	    iqn.co_no.focus();
	    return(false);
      }
	  */
	
	  if(iqn.address1.value == "" || iqn.address1.value == "address1"){
	    alert("Please enter Address 1!");
	    iqn.address1.focus();
	    return(false);
      }
	
	  if(iqn.country.value == "" || iqn.country.value == "country"){
	    alert("Please enter Country!");
	    iqn.country.focus();
	    return(false);
      }
	
	  if(iqn.attn_sales.value == ""){
	    alert("Please enter Attention to!");
	    iqn.attn_sales.focus();
	    return(false);
      }
	
	  if(iqn.telephone_sales.value == ""){
	    alert("Please enter Telephone!");
	    iqn.telephone_sales.focus();
	    return(false);
      }
	
	  if(iqn.quotationnofront.value == "" || iqn.quotationnofront.value == "xxx"){
	    alert("Please enter Company Code!");
	    iqn.quotationnofront.focus();
	    return(false);
      }
	}
  }
  
  
  if(iqn.status.value == "hold"){
	if(iqn.terms.value != "COD" && iqn.terms.value != "P.B.O (Payment Before Order)"){
	  alert("This customer account is on 'Credit Hold'.\nOnly 'COD' or 'P.B.O (Payment Before Order)' is allowed.\nPlease contact 'Account Department' or 'IT Department' for further information!");
	  return(false);
	}
  }
  
  if(iqn.quotationlogadmin.value == ""){
	alert("Please select Quotation Log for Admin!");
	iqn.quotationlogadmin.focus();
	return(false);
  }
  
  var material = document.getElementById("material" + 1).value;
  
  if(material == ""){
	alert("Please select Grade!");
	return(false);
  }
  
  var mdt = document.getElementById("mdt" + 1).value;
  
  if(mdt == ""){
	alert("Please select Material Dimension Thickness!");
	return(false);
  }
  
  var mdl = document.getElementById("mdl" + 1).value;
  
  if(mdl == ""){
	alert("Please enter Material Dimension Length!");
	return(false);
  }
  
  for(x = 1; x <= 20; x++){
	var material2 = document.getElementById("material" + x).value;
	var mat2 = document.getElementById("mat" + x).value;
	
	if(material2 == "cttopst" || material2 == "mlcgpst" || material2 == "cccgpst" || material2 == "pacgpst" || material2 == "lrcgpst" || material2 == "shrgpst" || material2 == "bgcspst" || material2 == "transportationpst" || material2 == "arftcs" || material2 == "cttophh" || material2 == "mlcgphh" || material2 == "cccgphh" || material2 == "pacgphh" || material2 == "lrcgphh" || material2 == "shrgphh" || material2 == "bgcsphh" || material2 == "transportation"){
	  if(mat2 != "" && mat2 != "0.00"){
		alert("Cutting & Transportation Charges must be keyed in Other column!!!"); 
		return(false);
	  }
	}
  }  
  
  if(document.pressed == "Transfer to Free Page"){
	msg = "Are you sure you wish to transfer to Free Page?";
  }
  else if(document.pressed == "Submit"){
	msg = "Are you sure you wish to submit this Quotation?";
  }
  else{
	msg = "Are you sure you wish to submit this Quotation?";
  }
  
  if(material && mdt && mdl != ""){
    var agree=confirm(msg);
      if(agree)
        return true;
      else
        return false;
  }
  
  return (true);
}


//issue order list
function issueorderlist_validator(iol){
  var digits = "0123456789";
  var selec = checkArray(iol, "selection[]");
  
  if(iol.status.value == "hold"){
	if(iol.termsiv.value == "COD" || iol.termsiv.value == "P.B.O (Payment Before Order)"){
	  //do nothing
	}
	else{
	  alert("This customer account is on 'Credit Hold'.\nOnly 'COD' or 'P.B.O (Payment Before Order)' is allowed.\nPlease contact 'Account Department' or 'IT Department' for further information!");
	  return(false);
	}
  }
  
  if(selec.length <= 0){
    alert("Please select item to Issue Order List!");
    return false;
  }
  
  if(iol.runningno.value == ""){
	alert("Please enter Running No.");
	iol.runningno.focus();
	return(false);
  }
  for(var i = 0; i < iol.runningno.value.length; i++){
    temp = iol.runningno.value.substring(i, i + 1)

    if(digits.indexOf(temp) == -1 && iol.runningno.value != ""){
      alert("Running No. must be numerical!");
	  iol.runningno.focus();
	  return(false);
    }
  }
  if(iol.runningno.value.length != 4){
	alert("Running No. must be 4 numerical long.");
	iol.runningno.focus();
	return(false);
  }
  
  if(!iol.chkrunno){
	//do nothing
  }
  else{
    if(iol.chkrunno.value == "no"){
	  if(iol.overwritern.checked == true){
	    //do nothing
	  }
	  else{
		alert("Running No. exist in database");
	    return(false);
	  }
    }
  }

  if(iol.invday.value == ""){
	alert("Please select invoice Date Day!");
	iol.invday.focus();
	return(false);
  }
  
  if(iol.invmonth.value == ""){
	alert("Please select invoice Date Month!");
	iol.invmonth.focus();
	return(false);
  }
  
  if(iol.invyear.value == ""){
	alert("Please select invoice Date Year!");
	iol.invyear.focus();
	return(false);
  }
  
  var quodate = document.getElementById("quotationdate").value;
  var quoyear = quodate.substr(0, 2);
  var quomonth = quodate.substr(2, 2);
  
  var invyear2 = iol.invyear.value.substr(2, 2);
  var invmonth2 = iol.invmonth.value;
  
  quoyear = quoyear * 1;
  quomonth = quomonth * 1;
  invyear2 = invyear2 * 1;
  invmonth2 = invmonth2 * 1;
  
  if(quoyear != invyear2 || quomonth != invmonth2){
	alert("Invoice Date and Quotation Date must be on the same month and year!");
	return(false);
  }
     
  var oveaccbal = document.getElementById("overallaccbal");

  if(oveaccbal.value < 0){
    if(iol.passover.value == ""){
	  alert("Please enter Password for Credit Limit Overriding!");
	  iol.passover.focus();
	  return(false);
	} 
  }
  
  if(selec.length != 0){
	if(!iol.chkpono){
	  var agree=confirm("Are you sure you wish to submit this Order List?");
      if(agree){
        return true;
	  }
      else{
        return false;
	  }
    }
    else{
      if(iol.chkpono.value == "no"){
	    var agree=confirm("Are you sure you wish to submit this Order List?");
        if(agree){
          return true;
		}
        else{
          return false;
		}
	  }
	  else{
	    var agreepo=confirm("PO No. exist in database. Are you sure you want to continue?");
        if(agreepo){
          var agree=confirm("Are you sure you wish to submit this Order List?");
          if(agree){
            return true;
		  }
          else{
            return false;
		  }
	    }
        else{
          return false;
	    }
	  }
    }  
  }
  
  for(i = 1; i <= 20; i++){	
	var sel = document.getElementById("selection" + i);

    if(sel.checked == true){
	  var die = document.getElementById("dateissue" + i);
	  var cde = document.getElementById("completiondate" + i);
	  var soe = document.getElementById("source" + i);
	  var cte = document.getElementById("cuttingtype" + i);
	  
	  if(die.value == ""){
		alert("Please check your Item " + i + " Date Issued!");
		return(false);
	  }
	  
	  if(cde.value == ""){
		alert("Please check your Item " + i + " Completion Date!");
		return(false);
	  }
	  
	  if(soe.value == ""){
		alert("Please check your Item " + i + " Source!");
		return(false);
	  }
	  
	  if(cte.value == ""){
		alert("Please check your Item " + i + " Cutting Type!");
		return(false);
	  }
	}
  }
}


//issue orderlist conversion
function orderlistconversion_validator(olc){	  
  var agree=confirm("Are you sure you wish to Convert this Order List?");
  
  if(agree){
    return true;
  }
  else{
    return false;
  }
}


//issue quotation
function enterscheduling_validator(esv){	
  var agree=confirm("Are you sure you wish to submit this Scheduling?");
    if(agree)
      return true;
    else
      return false;
}


//add customer
function customer_validator(ctr){
  if(ctr.co_name.value == ""){
	alert("Please enter Company Name!");
	ctr.co_name.focus();
	return(false);
  }

  if(ctr.co_no.value == ""){
	alert("Please enter Company Registration No!");
	ctr.co_no.focus();
	return(false);
  }
  
  if(ctr.address1.value == ""){
	alert("Please enter Address 1!");
	ctr.address1.focus();
	return(false);
  }
  
  if(ctr.country.value == ""){
	alert("Please enter Country!");
	ctr.country.focus();
	return(false);
  }
  
  if(ctr.telephone_sales.value == "" && ctr.handphone_sales.value == ""){
	alert("Please enter at lease one Sales Contact Number!");
	ctr.telephone_sales.focus();
	return(false);
  }
  
  /*
  if(ctr.email_sales.value != ""){  
    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(ctr.email_sales.value)){
      //do nothing
    }
    else{
	  alert("Invalid Sales E-mail Address! Please re-enter.");
      ctr.email_sales.focus();
      return(false);
    }
  }
  
  if(ctr.email_acc.value != ""){  
    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(ctr.email_acc.value)){
      //do nothing
    }
    else{
	  alert("Invalid Account E-mail Address! Please re-enter.");
      ctr.email_acc.focus();
      return(false);
    }
  }
  */
  
  if(ctr.group.value == ""){
	alert("Please enter Group!");
	ctr.group.focus();
	return(false);
  }
  
  if(ctr.salesperson.value == ""){
	alert("Please select Salesperson!");
	ctr.salesperson.focus();
	return(false);
  }
  
  if(ctr.terms.value == ""){
	alert("Please select Terms!");
	ctr.terms.focus();
	return(false);
  }
  
  if(ctr.credit_limit.value == ""){
	alert("Please enter Credit Limit!");
	ctr.credit_limit.focus();
	return(false);
  }
  
  if(ctr.company.value == ""){
	alert("Please select Company!");
	ctr.company.focus();
	return(false);
  }
  
  if(ctr.status.value == ""){
	alert("Please select Status!");
	ctr.status.focus();
	return(false);
  }
  
  if(ctr.day.value == ""){
	alert("Please select Day Created!");
	ctr.day.focus();
	return(false);
  }
  
  if(ctr.month.value == ""){
	alert("Please select Month Created!");
	ctr.month.focus();
	return(false);
  }
  
  if(ctr.year.value == ""){
	alert("Please select Year Created!");
	ctr.year.focus();
	return(false);
  }

  return(true);
}


//add staff
function staff_validator(saf){
  if(saf.username.value == ""){
	alert("Please enter Username!");
	saf.username.focus();
	return(false);
  }

  if(saf.password.value == ""){
	alert("Please enter Password!");
	saf.password.focus();
	return(false);
  }
  
  if(saf.password2.value == ""){
	alert("Please Re-enter Password!");
	saf.password2.focus();
	return(false);
  }

  pass1 = saf.password.value;
  pass2 = saf.password2.value;

  if(pass1 != pass2){
    alert ("Password does not match. Please re-enter your password.")
    return(false);
  }

  if(saf.name.value == ""){
	alert("Please enter Name!");
	saf.name.focus();
	return(false);
  }
  
  if(saf.position.value == ""){
	alert("Please enter Position!");
	saf.position.focus();
	return(false);
  }
  
  if(saf.canoverride.value == "yes"){
	if(saf.overridepassword.value == ""){
	  alert("Please enter Override Password!");
	  saf.overridepassword.focus();
	  return(false);
	}
  }

  return(true);
}


//edit staff
function editstaff_validator(esf){
  if(esf.password.value == "" && esf.password2.value == ""){
	//do nothing
  }
  else{
    if(esf.password.value == ""){
	  alert("Please enter Password!");
	  esf.password.focus();
	  return(false);
    }
  
    if(esf.password2.value == ""){
	  alert("Please Re-enter Password!");
	  esf.password2.focus();
	  return(false);
    }

    pass1 = esf.password.value;
    pass2 = esf.password2.value;

    if(pass1 != pass2){
      alert ("Password does not match. Please re-enter your password.")
     return(false);
    }
  }

  if(esf.name.value == ""){
	alert("Please enter Name!");
	esf.name.focus();
	return(false);
  }
  
  if(esf.position.value == ""){
	alert("Please enter Position!");
	esf.position.focus();
	return(false);
  }
  
  if(esf.canoverride.value == "yes"){
	if(esf.overridepassword.value == ""){
	  alert("Please enter Override Password!");
	  esf.overridepassword.focus();
	  return(false);
	}
  }

  return(true);
}


//check array
function checkArray(form, arrayName){
  var retval = new Array();
  for(var i=0; i < form.elements.length; i++){
    var el = form.elements[i];
    if(el.type == "checkbox" && el.name == arrayName && el.checked){
      retval.push(el.value);
    }
  }
  
  return retval;
}


//confirmation delete
function confirmDelete(){
  var agree=confirm("Are you sure you wish to delete this entry?");
    if(agree)
      return true;
    else
      return false;
}


//confirmation reset customer
function confirmReset(){
  var agree=confirm("Are you sure you wish to reset this customer price?");
    if(agree)
      return true;
    else
      return false;
}


//confirmation delete
function confirmDeleteOL(cou){
  var reason = document.getElementById("reason").value;
  var qno = document.getElementById("qno" + cou).value;
  var dat = document.getElementById("dat" + cou).value;
  var com = document.getElementById("com" + cou).value;
  var cid = document.getElementById("cid" + cou).value;
  var bid = document.getElementById("bid" + cou).value;

  if(reason == ""){
	alert("Please enter Reason for deletion.");  
	return false;
  }
  else{
    var agree=confirm("Are you sure you wish to delete this entry?");
      if(agree){
	    window.location="index2.php?view=dol&act=del&qno=" + encodeURIComponent(qno) + "&dat=" + dat + "&com=" + com + "&cid=" + cid + "&bid=" + bid + "&rea=" + reason + "";
	    return true;
	  }
      else{
	    return false;
	  }
  }
}


//confirmation delete manual orderlist
function confirmDeleteManualOL(cou){
  var reason = document.getElementById("reason").value;
  var qno = document.getElementById("qno" + cou).value;
  var dat = document.getElementById("dat" + cou).value;
  var com = document.getElementById("com" + cou).value;
  var cid = document.getElementById("cid" + cou).value;
  var bid = document.getElementById("bid" + cou).value;

  if(reason == ""){
	alert("Please enter Reason for deletion.");  
	return false;
  }
  else{
    var agree=confirm("Are you sure you wish to delete this entry?");
      if(agree){
	    window.location="index2.php?view=dmo&act=del&qno=" + encodeURIComponent(qno) + "&dat=" + dat + "&com=" + com + "&cid=" + cid + "&bid=" + bid + "&rea=" + reason + "";
	    return true;
	  }
      else{
	    return false;
	  }
  }
}

//confirmation delete off-setting
function confirmDeleteOS(cou){
  var com = document.getElementById("com_select").value;
  var dat = document.getElementById("cust_date").value;
  var ortype = document.getElementById("ortype" + cou).value;
  var orno = document.getElementById("orno" + cou).value;

  var agree=confirm("Are you sure you wish to delete this entry?");
    if(agree){
	  window.location = "index2.php?view=dos&act=del&com=" + com + "&dat=" + dat + "&ortype=" + ortype + "&orno=" + orno + "";
	  return true;
	}
    else{
	  return false;
	}
}