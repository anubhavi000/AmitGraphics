document.getElementById("myPaymentForm").onkeypress = function(e) {
    var key = e.charCode || e.keyCode || 0;     
    if (key == 13) {
      e.preventDefault();
    }
   }


function insertField(a) {
    // console.log('karan');
    var id = a + 'div';
    var num = parseFloat(a.match(/\d+/), 10);
    // console.log(num);
    var tds_amount = "tds_amount" + num;
    var total_amount = "total_amount" + num;

    // var inputid = a+"ledger";
    var finalname = a.replace(/\d+/g, '');

    // console.log(inputid);


    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;



    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);

    // console.log(final_amount);


    if (final_total_amount == '') {
        alert('Please Fill Total Amount First!!');
        // $(document.getElementById(a)).checked = false;
        $(document.getElementById(a)).prop("checked", false);

    } else if ($(document.getElementById("securityClick" + num)).is(':checked')) {

        // pending bill div starts
        let div=document.getElementById('pendingbillcontainer'+num);
        if(div!=null){
            let table= div.querySelector("table");
            table.style.display="none";
        }
        // pending bill div starts



        $(document.getElementById(id)).append("<input value="+final_amount+" required type='text' class='form-control' id=securityClick" +
            num + "ledger placeholder='Amount' name=" + a + " onkeyup=securityKeyup(" + num + ")> ");

        $(document.getElementById("registrationClick" + num + "div")).append(
            "<input value='0' required type='text' class='form-control' id=registrationClick" + num +
            "ledger placeholder='Amount' name=registrationClick" + num + " onkeyup=registrationKeyup(" + num + ")>");


        $(document.getElementById("previousClick" + num)).prop("checked", false);
        $(document.getElementById("previousClick" + num + "div")).html("");
        $(document.getElementById("onAccountClick" + num + "div")).html("");



    } else if ($(document.getElementById("securityClick" + num)).is(':not(:checked)')) {

         // against check start
      $(document.getElementById("previousClick" + num + "div")).append("<input readonly value="+final_amount+" type='text' required class='form-control' id=previousClick" + num +
            "ledger placeholder='Amount' name=previousClick" + num + " onkeyup=previousKeyup(" + num + ")>");
        $(document.getElementById("onAccountClick" + num + "div")).append(
            "<input value='0' type='text' required class='form-control paid_amountof"+num+"' id=onAccountClick" + num +
            "ledger placeholder='Amount' name=onAccountClick" + num + " onkeyup=setTotalAmount(" + num + ") >");
        $(document.getElementById("previousClick" + num)).prop("checked", true);
        // against check ends


        // pending bill div starts
        let div=document.getElementById('pendingbillcontainer'+num);
        if(div!=null){
            let table= div.querySelector("table");
            table.style.display="revert";
        }
        // pending bill div starts

        $(document.getElementById(a)).prop("checked", false);

        $(document.getElementById(id)).html("");
        $(document.getElementById("registrationClick" + num + "div")).html("");


    } else {
        $(document.getElementById(id)).html("");
    }

}

function securityKeyup(val) {
    var num = val;

    var securityClick = document.getElementById("securityClick" + num + "ledger").value;

    var tds_amount = "tds_amount" + num;
    var total_amount = "total_amount" + num;
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);

    document.getElementById("clientDrop" + num).required = true;

    if (securityClick < final_amount) {
        var rem = parseFloat(final_amount) - parseFloat(securityClick);
        document.getElementById("registrationClick" + num + "ledger").value = rem;
    } else if (securityClick > final_amount) {
        alert("!!! Please Check Value !!!");

        // $(document.getElementById("securityClick" + num)).prop("checked", false);
        // $(document.getElementById("securityClick" + num + "div")).html("");
        // $(document.getElementById("registrationClick" + num + "div")).html("");

         document.getElementById("securityClick" + num + "ledger").value = final_amount;
        document.getElementById("registrationClick" + num + "ledger").value = "0";

    } else {
        document.getElementById("registrationClick" + num + "ledger").value = "0";

    }

}


function registrationKeyup(val) {
    var num = val;

    var securityClick = document.getElementById("registrationClick" + num + "ledger").value;

    var tds_amount = "tds_amount" + num;
    var total_amount = "total_amount" + num;
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);

    document.getElementById("clientDrop" + num).required = true;
    

    if (securityClick < final_amount) {
        var rem = parseFloat(final_amount) - parseFloat(securityClick);
        document.getElementById("securityClick" + num + "ledger").value = rem;
    } else if (securityClick > final_amount) {
        alert("!!! Please Check Value !!!");

        // $(document.getElementById("securityClick" + num)).prop("checked", false);
        // $(document.getElementById("securityClick" + num + "div")).html("");
        // $(document.getElementById("registrationClick" + num + "div")).html("");
        document.getElementById("securityClick" + num + "ledger").value = final_amount;
        document.getElementById("registrationClick" + num + "ledger").value = "0";

    } else {
        document.getElementById("securityClick" + num + "ledger").value = "0";

    }

}





function insertFieldAgain(a) {
    // alert(a);
    var id = a + 'div';
    var num = parseFloat(a.match(/\d+/), 10);
    var tds_amount = "tds_amount" + num;
    var total_amount = "total_amount" + num;

    var inputid = a + "ledger";
    var finalname = a.replace(/\d+/g, '');

    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);

    // console.log(final_amount);


    if (final_total_amount == '') {
        alert('Please Fill Total Amount First!!');
        $(document.getElementById(a)).prop("checked", false);

    } else if ($(document.getElementById("previousClick" + num)).is(':checked')) {

         // pending bill div starts
        let div=document.getElementById('pendingbillcontainer'+num);
        if(div!=null){
            let table= div.querySelector("table");
            table.style.display="revert";
        }
        // pending bill div starts

        
        $(document.getElementById(id)).append("<input readonly value="+final_amount+" type='text' required class='form-control' id=previousClick" + num +
            "ledger placeholder='Amount' name=" + a + " onkeyup=previousKeyup(" + num + ")>");

        $(document.getElementById("onAccountClick" + num + "div")).append(
            "<input value='0' type='text' required class='form-control paid_amountof"+num+" ' id=onAccountClick" + num +
            "ledger placeholder='Amount' name=onAccountClick" + num + " onkeyup=setTotalAmount(" + num + ") >");

        $(document.getElementById("securityClick" + num)).prop("checked", false);
        $(document.getElementById("securityClick" + num + "div")).html("");
        $(document.getElementById("registrationClick" + num + "div")).html("");

    } else if ($(document.getElementById("previousClick" + num)).is(':not(:checked)')) {

         // pending bill div starts
        let div=document.getElementById('pendingbillcontainer'+num);
        if(div!=null){
            let table= div.querySelector("table");
            table.style.display="none";
        }
      
        // pending bill div starts


        // against check start
        $(document.getElementById("securityClick" + num + "div")).append("<input value="+final_amount+" required type='text' class='form-control' id=securityClick" +
            num + "ledger placeholder='Amount' name=securityClick" + num + " onkeyup=securityKeyup(" + num + ")> ");
        $(document.getElementById("registrationClick" + num + "div")).append(
            "<input value='0' required type='text' class='form-control' id=registrationClick" + num +
            "ledger placeholder='Amount' name=registrationClick" + num + " onkeyup=registrationKeyup(" + num + ")>");
        $(document.getElementById("securityClick" + num)).prop("checked", true);
        // against check ends


        $(document.getElementById(a)).prop("checked", false);
        $(document.getElementById(id)).html("");
        $(document.getElementById("onAccountClick" + num + "div")).html("");
    } else {
        $(document.getElementById(id)).html("");
    }

}


function previousKeyup(val) {
    var num = val;

    var securityClick = document.getElementById("previousClick" + num + "ledger").value;

    var tds_amount = "tds_amount" + num;
    var total_amount = "total_amount" + num;
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);

    if (securityClick < final_amount) {
        var rem = parseFloat(final_amount) - parseFloat(securityClick);
        document.getElementById("onAccountClick" + num + "ledger").value = rem;
    } else if (securityClick > final_amount) {
        alert("!!! Please Check Value !!!");

        // $(document.getElementById("previousClick" + num)).prop("checked", false);
        // $(document.getElementById("previousClick" + num + "div")).html("");
        // $(document.getElementById("onAccountClick" + num + "div")).html("");
        document.getElementById("previousClick" + num + "ledger").value = final_amount;
        document.getElementById("onAccountClick" + num + "ledger").value = "0";


    } else {
        document.getElementById("onAccountClick" + num + "ledger").value = "0";

    }

}


// function onaccountKeyup(val) {

//     /////  for get billing  starts
//     var value = document.getElementById("clientDrop"+val).value;
//     var auth_id = 1;
//     var paid_array = 0;
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         type: "post",
//         url:  app_url+"get_pending_payment",
//         dataType: 'json',
//         data: {'client': value,'auth_id': auth_id},

//         success: function (data) 
//         {
//             if(data.code == 200)
//             { 
//                 let newbills=data.response;
//                 for(let k=0; k<newbills.length; k++) 
//                 {
//                     paid_array += parseFloat(document.getElementById("paid_amount" + k).value);
//                 }

//                 var num = val;

//                 var onAccountClick = document.getElementById("onAccountClick" + num + "ledger").value;

//                 var tds_amount = "tds_amount" + num;
//                 var total_amount = "total_amount" + num;
//                 var final_tds_amount = document.getElementById(tds_amount).value;
//                 var final_total_amount = document.getElementById(total_amount).value;
//                 var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount)-parseFloat(paid_array);

//                 if (onAccountClick < final_amount) {
//                     var rem = parseFloat(final_amount) - parseFloat(onAccountClick);
//                     document.getElementById("previousClick" + num + "ledger").value = rem;
//                 } else if (onAccountClick > final_amount) {
//                     alert("!!! Please Check Value !!!");
//                     // $(document.getElementById("previousClick" + num)).prop("checked", false);
//                     // $(document.getElementById("previousClick" + num + "div")).html("");
//                     // $(document.getElementById("onAccountClick" + num + "div")).html("");
//                     document.getElementById("previousClick" + num + "ledger").value = final_amount;
//                     document.getElementById("onAccountClick" + num + "ledger").value = "0";
//                 } else {
//                     document.getElementById("previousClick" + num + "ledger").value = "0";

//                 }

    

//             }

//         }

// })
//     ///// for get billing ends ///


// }




