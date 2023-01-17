

function pendingPayment(value, i) {
    $('#overlay').show();
    // $('#highlighter').empty();
    let clientElements = document.getElementsByName("client[]");
    var counter = [];
    is_duplicate = 0;
    for (var ci = 0; ci < clientElements.length; ci++) {
        var checker = clientElements[ci].value;
        if (checker == value) {
            counter.push(checker);
            if (counter.length > 1) {
                is_duplicate++;
                $('#overlay').hide();
                $("#clientDrop" + i).val('').trigger('change');
                $('#highlighter').text(': Duplicate Client Please Select another client.');
            }
        }
    }
  

    var tds_amount = "tds_amount" + i;
    var total_amount = "total_amount" + i;
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);


    //////////////////////////

    $(document.getElementById("securityClick" + i)).prop("checked", false);
    $(document.getElementById("securityClick" + i + "div")).html("");
    $(document.getElementById("registrationClick" + i + "div")).html("");
    $(document.getElementById("previousClick" + i + "div")).html("");
    $(document.getElementById("onAccountClick" + i + "div")).html("");



    document.getElementById("previousClick" + i).checked = true;
    document.getElementById("previousClick" + i + "div").innerHTML += "<input readonly value=" + final_amount + " type='text' required class='form-control ' id=previousClick" + i +
        "ledger placeholder='Amount' name=previousClick" + i + " onkeyup=previousKeyup(" + i + ")>";
    document.getElementById("onAccountClick" + i + "div").innerHTML +=
        "<input value='0' type='text' required class='form-control paid_amountof" + i + "' id=onAccountClick" + i +
        "ledger placeholder='Amount' name=onAccountClick" + i + " onkeyup=setTotalAmount(" + i + ") >";


    ////////////////////////

    var auth_id = 1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: app_url + "get_pending_payment",
        dataType: 'json',
        data: { 'client': value, 'auth_id': auth_id },
        success: function (data) {



            if (data.code == 401) {
                // console.log("Unauthenticated");
                $('#overlay').hide();
            }
            else if (data.code == 200) {

                // console.log(data.clients.id);
                $('#select_client_details').html("");
                $('#overlay').hide();

                $('#select_client_details').append("TYPE : HCF <br> ROUTE :" + data.clients.route_name + "<br> Main :- " + data.clients.security_deposit + " <br> Security :- " + data.clients.security_deposit);


                // console.log(data);

                let tbody = document.getElementById('pendingbills' + i);

                let rows = ``;
                let newbills = data.response;


                for (let k = 0; k < newbills.length; k++) {
                    //   let newrow= document.createElement("tr");
                    final_amount = parseFloat(newbills[k].amount) + parseFloat(newbills[k].igst) + parseFloat(newbills[k].cgst) + parseFloat(newbills[k].sgst);
                    final_amount= Math.round(final_amount);

                    rows += `     
                    <tr> <td><input type="text" name= 'bill_no[]' value="${newbills[k].char_id}" hidden/> <input type="text"  value="${newbills[k].bill_no}" readonly/></td>
                               <td><input type="text" name= 'client_char_id[]' value="${newbills[k].client_char_id}" readonly/></td>
                                <td><input type="text" name= 'bill_date[]'  value="${newbills[k].billing_date}" readonly/></td>
                                <td><input type="text" name= 'total_amount[]'  value="${final_amount}" readonly/></td>
                                <td><input type="text" name= 'pending_amount[]'   value="${Math.round(newbills[k].pending_amount)}" readonly/></td>
                                <td><input type="text" name= 'paid_amount[]' class="paid_amountof${i}"  value="0"  onkeyup="setTotalAmount( ${i} )" /></td> </tr>`;

                }
                tbody.innerHTML = rows;

                if (tbody.children.length > 0) {
                    document.getElementById('pendingbillcontainer' + i).style.display = "block";
                }
                else {
                    document.getElementById('pendingbillcontainer' + i).style.display = "none";
                    tbody.innerHTML = '';
                }
            }
            else {

                alert_message(data.alert_message);
                $('#overlay').hide();

            }

        },
        complete: function () {
            // $('#loading-image').hide();
            $('#overlay').hide();
        },
        error: function () {
            $('#overlay').hide();
        }
    })

}
function pendingPaymentFromEdit(value, i) {
    $('#overlay').show();

    let clientElements = document.getElementsByName("updated_client[]");
    var counter = [];
    is_duplicate = 0;
    for (var ci = 0; ci < clientElements.length; ci++) {
        var checker = clientElements[ci].value;
        if (checker == value) {
            counter.push(checker);
            if (counter.length > 1) {
                is_duplicate++;

                // $('#highlighter').html(': Duplicate Client Please Select another client.');
                $('#overlay').hide();
                $("#clientDrop" + i).val('').trigger('change');
                $('#highlighter').text(': Duplicate Client Please Select another client.');

            }
        }

    }
   

    var tds_amount = "tds_amount" + i;
    var total_amount = "total_amount" + i;
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);


    //////////////////////////

    $(document.getElementById("securityClick" + i)).prop("checked", false);
    $(document.getElementById("securityClick" + i + "div")).html("");
    $(document.getElementById("registrationClick" + i + "div")).html("");
    $(document.getElementById("previousClick" + i + "div")).html("");
    $(document.getElementById("onAccountClick" + i + "div")).html("");



    document.getElementById("previousClick" + i).checked = true;
    document.getElementById("previousClick" + i + "div").innerHTML += "<input readonly value=" + final_amount + " type='text' required class='form-control ' id=previousClick" + i +
        "ledger placeholder='Amount' name=previousClick" + i + " onkeyup=previousKeyup(" + i + ")>";
    document.getElementById("onAccountClick" + i + "div").innerHTML +=
        "<input value='0' type='text' required class='form-control paid_amountof" + i + "' id=onAccountClick" + i +
        "ledger placeholder='Amount' name=onAccountClick" + i + " onkeyup=setTotalAmount(" + i + ") >";


    ////////////////////////

    var auth_id = 1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: app_url + "get_pending_payment",
        dataType: 'json',
        data: { 'client': value, 'auth_id': auth_id },
        success: function (data) {



            if (data.code == 401) {
                // console.log("Unauthenticated");
                $('#overlay').hide();
            }
            else if (data.code == 200) {

                // console.log(data.clients.id);
                $('#select_client_details').html("");
                $('#overlay').hide();

                $('#select_client_details').append("TYPE : HCF <br> ROUTE :" + data.clients.route_name + "<br> Main :- " + data.clients.security_deposit + " <br> Security :- " + data.clients.security_deposit);


                // console.log(data);

                let tbody = document.getElementById('pendingbills' + i);

                let rows = ``;
                let newbills = data.response;


                for (let k = 0; k < newbills.length; k++) {
                    //   let newrow= document.createElement("tr");
                    final_amount = parseFloat(newbills[k].amount) + parseFloat(newbills[k].igst) + parseFloat(newbills[k].cgst) + parseFloat(newbills[k].sgst);
                    final_amount= Math.round(final_amount);
                    rows += `     
                                <tr> <td><input type="text" name= 'bill_no[]' value="${newbills[k].char_id}" hidden/> <input type="text"  value="${newbills[k].bill_no}" readonly/></td>
                                <td><input type="text" name= 'client_char_id[]' value="${newbills[k].client_char_id}" readonly/></td>
                                <td><input type="text" name= 'bill_date[]'  value="${newbills[k].billing_date}" readonly/></td>
                                <td><input type="text" name= 'total_amount[]'  value="${final_amount}" readonly/></td>
                                <td><input type="text" name= 'pending_amount[${newbills[k].char_id}]'   value="${Math.round(newbills[k].pending_amount)}" readonly/></td>
                                <td><input type="text" name= 'paid_amount[${newbills[k].char_id}]' class="paid_amountof${i}"  value="0"  onkeyup="setTotalAmount( ${i} )" /></td> </tr>`;

                }
                tbody.innerHTML = rows;

                if (tbody.children.length > 0) {
                    document.getElementById('pendingbillcontainer' + i).style.display = "block";
                }
                else {
                    document.getElementById('pendingbillcontainer' + i).style.display = "none";
                    tbody.innerHTML = '';
                }
            }
            else {

                alert_message(data.alert_message);
                $('#overlay').hide();

            }

        },
        complete: function () {
            // $('#loading-image').hide();
            $('#overlay').hide();
        },
        error: function () {
            $('#overlay').hide();
        }
    })

}

function pendingPharmaPayment(value, i) {

    $('#overlay').show();


    let clientElements = document.getElementsByName("client[]");
    var counter = [];
    is_duplicate = 0;
    for (var ci = 0; ci < clientElements.length; ci++) {
        var checker = clientElements[ci].value;
        if (checker == value) {
            counter.push(checker);
            if (counter.length > 1) {
                $('#overlay').hide();
                $("#clientDrop" + i).val('').trigger('change');
                $('#highlighter').text(': Duplicate Client Please Select another client.');

            }
        }

    }
   

    var tds_amount = "tds_amount" + i;
    var total_amount = "total_amount" + i;
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);


    //////////////////////////

    $(document.getElementById("securityClick" + i)).prop("checked", false);
    $(document.getElementById("securityClick" + i + "div")).html("");
    $(document.getElementById("registrationClick" + i + "div")).html("");
    $(document.getElementById("previousClick" + i + "div")).html("");
    $(document.getElementById("onAccountClick" + i + "div")).html("");



    document.getElementById("previousClick" + i).checked = true;
    document.getElementById("previousClick" + i + "div").innerHTML += "<input readonly value=" + final_amount + " type='text' required class='form-control ' id=previousClick" + i +
        "ledger placeholder='Amount' name=previousClick" + i + " onkeyup=previousKeyup(" + i + ")>";
    document.getElementById("onAccountClick" + i + "div").innerHTML +=
        "<input value='0' type='text' required class='form-control paid_amountof" + i + "' id=onAccountClick" + i +
        "ledger placeholder='Amount' name=onAccountClick" + i + " onkeyup=setTotalAmount(" + i + ") >";


    ////////////////////////

    var auth_id = 1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: app_url + "get_pending_pharma_payment",
        dataType: 'json',
        data: { 'client': value, 'auth_id': auth_id },
        success: function (data) {



            if (data.code == 401) {
                // console.log("Unauthenticated");
                $('#overlay').hide();
            }
            else if (data.code == 200) {

                // console.log(data.clients.id);
                $('#select_client_details').html("");
                $('#overlay').hide();

                $('#select_client_details').append("TYPE : Pharma ");


                // console.log(data);

                let tbody = document.getElementById('pendingbills' + i);

                let rows = ``;
                let newbills = data.response;


                for (let k = 0; k < newbills.length; k++) {
                    //   let newrow= document.createElement("tr");
                    final_amount = parseFloat(newbills[k].amount) + parseFloat(newbills[k].igst) + parseFloat(newbills[k].cgst) + parseFloat(newbills[k].sgst);
                    final_amount= Math.round(final_amount);
                    rows += `     
                            <tr> 
                            <td>
                            <input type="text" name= 'bill_no[]' value="${newbills[k].char_id}" hidden/>
                            <input type="text"  value="${newbills[k].bill_no}" readonly/>
                            </td>
                             <td><input type="text" name= 'client_char_id[]' value="${newbills[k].client_char_id}" readonly/></td>
                           <td><input type="text" name= 'bill_date[]'  value="${newbills[k].billing_date}" readonly/></td>
                             <td><input type="text" name= 'total_amount[]'  value="${final_amount}" readonly/></td>
                               <td><input type="text" name= 'pending_amount[]'   value="${Math.round(newbills[k].pending_amount)}" readonly/></td>
                            <td><input type="text" name= 'paid_amount[]' class="paid_amountof${i}"  value="0"  onkeyup="setTotalAmount( ${i} )" /></td> </tr>
                                
                         `
                    //   tbody.appendChild(newrow);

                }
                tbody.innerHTML = rows;

                if (tbody.children.length > 0) {

                    document.getElementById('pendingbillcontainer' + i).style.display = "block";

                    // document.getElementById("modalbtn").click();

                }
                else {
                    document.getElementById('pendingbillcontainer' + i).style.display = "none";
                    tbody.innerHTML = '';
                }

            }
            else {

                alert_message(data.alert_message);
                $('#overlay').hide();

            }


        }
    })

}
function pendingPharmaPaymentFromEdit(value, i) {

    $('#overlay').show();


    let clientElements = document.getElementsByName("updated_client[]");
    var counter = [];
    is_duplicate = 0;
    for (var ci = 0; ci < clientElements.length; ci++) {
        var checker = clientElements[ci].value;
        if (checker == value) {
            counter.push(checker);
            if (counter.length > 1) {
                $('#overlay').hide();
                $("#clientDrop" + i).val('').trigger('change');
                $('#highlighter').text(': Duplicate Client Please Select another client.');
            }
        }

    }
   


    var tds_amount = "tds_amount" + i;
    var total_amount = "total_amount" + i;
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);


    //////////////////////////

    $(document.getElementById("securityClick" + i)).prop("checked", false);
    $(document.getElementById("securityClick" + i + "div")).html("");
    $(document.getElementById("registrationClick" + i + "div")).html("");
    $(document.getElementById("previousClick" + i + "div")).html("");
    $(document.getElementById("onAccountClick" + i + "div")).html("");



    document.getElementById("previousClick" + i).checked = true;
    document.getElementById("previousClick" + i + "div").innerHTML += "<input readonly value=" + final_amount + " type='text' required class='form-control ' id=previousClick" + i +
        "ledger placeholder='Amount' name=previousClick" + i + " onkeyup=previousKeyup(" + i + ")>";
    document.getElementById("onAccountClick" + i + "div").innerHTML +=
        "<input value='0' type='text' required class='form-control paid_amountof" + i + "' id=onAccountClick" + i +
        "ledger placeholder='Amount' name=onAccountClick" + i + " onkeyup=setTotalAmount(" + i + ") >";


    ////////////////////////

    var auth_id = 1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: app_url + "get_pending_pharma_payment",
        dataType: 'json',
        data: { 'client': value, 'auth_id': auth_id },
        success: function (data) {



            if (data.code == 401) {
                // console.log("Unauthenticated");
                $('#overlay').hide();
            }
            else if (data.code == 200) {

                // console.log(data.clients.id);
                $('#select_client_details').html("");
                $('#overlay').hide();

                $('#select_client_details').append("TYPE : Pharma ");


                // console.log(data);

                let tbody = document.getElementById('pendingbills' + i);

                let rows = ``;
                let newbills = data.response;


                for (let k = 0; k < newbills.length; k++) {
                    //   let newrow= document.createElement("tr");
                    final_amount = parseFloat(newbills[k].amount) + parseFloat(newbills[k].igst) + parseFloat(newbills[k].cgst) + parseFloat(newbills[k].sgst);
                    final_amount= Math.round(final_amount);
                    rows += `     
                            <tr> 
                            <td>
                            <input type="text" name= 'bill_no[]' value="${newbills[k].char_id}" hidden/>
                            <input type="text"  value="${newbills[k].bill_no}" readonly/>
                            </td>
                             <td><input type="text" name= 'client_char_id[]' value="${newbills[k].client_char_id}" readonly/></td>
                           <td><input type="text" name= 'bill_date[]'  value="${newbills[k].billing_date}" readonly/></td>
                             <td><input type="text" name= 'total_amount[]'  value="${final_amount}" readonly/></td>
                               <td><input type="text" name= 'pending_amount[${newbills[k].char_id}]'   value="${Math.round(newbills[k].pending_amount)}" readonly/></td>
                            <td><input type="text" name= 'paid_amount[${newbills[k].char_id}]' class="paid_amountof${i}"  value="0"  onkeyup="setTotalAmount( ${i} )" /></td> </tr>
                                
                         `
                    //   tbody.appendChild(newrow);

                }
                tbody.innerHTML = rows;

                if (tbody.children.length > 0) {

                    document.getElementById('pendingbillcontainer' + i).style.display = "block";

                    // document.getElementById("modalbtn").click();

                }
                else {
                    document.getElementById('pendingbillcontainer' + i).style.display = "none";
                    tbody.innerHTML = '';
                }

            }
            else {

                alert_message(data.alert_message);
                $('#overlay').hide();

            }


        }
    })

}


function toggletable(i) {
    let div = document.getElementById('pendingbillcontainer' + i);
    let table = div.querySelector("table");

    if (table.style.display == "none") {
        // table.style.display="block"; change by rupesh on 7 apr
        table.style.display = "revert";
    } else {
        table.style.display = "none";
    }
}

function setTotalAmount(i) {


    // var paid_array = 0;
    // for(let j=0; j<length; j++) 
    // {   
    //     if(j != k){
    //         paid_array += parseFloat(document.getElementById("paid_amount" + j).value);
    //     }



    // }




    var tds_amount = "tds_amount" + i;
    var total_amount = "total_amount" + i;
    var onAccountClick = "onAccountClick" + i + "ledger";
    var previousClick = "previousClick" + i + "ledger";
    var final_tds_amount = document.getElementById(tds_amount).value;
    var final_total_amount = document.getElementById(total_amount).value;
    // var onAccountClick_amount = document.getElementById(onAccountClick).value;
    var paid_array = 0;
    var final_cal_amount = 0;
    let allpaidamount = document.querySelectorAll(`.paid_amountof${i}`);
    allpaidamount.forEach(each => {
        // console.log(each.value)
        if (CheckNullUndefined(each.value)) {
            each.value = 0;
        }
        // if(Number.isNaN(each.value)){
        //     //  alert("hii")
        //     each.value=0;
        // }
        paid_array += parseFloat(each.value);
        final_cal_amount = parseFloat(final_total_amount) + parseFloat(final_tds_amount) - parseFloat(paid_array);
        if (final_cal_amount < 0) {
            alert("Please check the value");

            paid_array -= parseFloat(each.value);
            each.value = 0
            final_cal_amount = parseFloat(final_total_amount) + parseFloat(final_tds_amount) - parseFloat(paid_array);

        }

    })
    document.getElementById(previousClick).value = final_cal_amount.toFixed(2);
    // if(final_cal_amount>=0){

    //     document.getElementById(previousClick).value = final_cal_amount; 
    // }else{
    //     alert("Please check the entered amount");
    // }
    // var paidAmount = "paid_amount" + k;
    // var paidAmountValue = document.getElementById(paidAmount).value;



    // if(final_cal_amount >= paidAmountValue)
    // {
    //     var final_amount = parseFloat(final_cal_amount) - parseFloat(paidAmountValue);
    //     document.getElementById(previousClick).value = final_amount;
    // }else{
    //      alert("entered amount must not be greater than total amount");
    // }


    // if(final_cal_amount<=final_total_amount){
    //     document.getElementById(previousClick).value = final_cal_amount;      
    // }else{
    //     alert("entered amount must not be greater than total amount");
    // }



    //   let total_amount=0;
    // let all= document.querySelectorAll(`.paid_amount${i}`);
    // field_value_am= document.getElementById("total_amount"+i).value
    // tds_value= document.getElementById("tds_amount"+i).value

    // var field_value = parseFloat(field_value_am)+parseFloat(tds_value);
    // console.log(field_value)
    // all.forEach(each=>{

    //     total_amount+=Number(each.value);

    //     if(Number(field_value)< total_amount){
    //       alert("entered amount must not be greater than total amount");
    //       total_amount-=each.value;
    //       each.value=0;
    //   }
    // })



}




function totalAmountData(i) {

    var tds_amount = "tds_amount" + i;
    var total_amount = "total_amount" + i;
    var securityClick_amount = "securityClick" + i + "ledger";
    var registrationClick_amount = "registrationClick" + i + "ledger";
    var previousClick_amount = "previousClick" + i + "ledger";
    var onAccountClick_amount = "onAccountClick" + i + "ledger";




    var final_tds_amount = document.getElementById(tds_amount) ? document.getElementById(tds_amount).value : '0';
    var final_total_amount = document.getElementById(total_amount) ? document.getElementById(total_amount).value : '0';
    var final_securityClick_amount = document.getElementById(securityClick_amount) ? document.getElementById(securityClick_amount).value : '0';
    var final_registrationClick_amount = document.getElementById(registrationClick_amount) ? document.getElementById(registrationClick_amount).value : '0';
    var final_previousClick_amount = document.getElementById(previousClick_amount) ? document.getElementById(previousClick_amount).value : '0';
    var final_onAccountClick_amount = document.getElementById(onAccountClick_amount) ? document.getElementById(onAccountClick_amount).value : '0';


    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);
    // console.log(final_amount);
    // var divide = parseFloat(final_amount)/2;

    var final_divide = isNaN(final_amount) ? '0' : final_amount;


    document.getElementById(securityClick_amount) ? document.getElementById(securityClick_amount).value = final_divide : '0';
    document.getElementById(registrationClick_amount) ? document.getElementById(registrationClick_amount).value = '0' : '0';
    document.getElementById(previousClick_amount) ? document.getElementById(previousClick_amount).value = final_divide.toFixed(2) : '0';
    document.getElementById(onAccountClick_amount) ? document.getElementById(onAccountClick_amount).value = '0' : '0';




    //rupesh added

    let alltotal = document.querySelectorAll(".total_amount");
    let am = 0;
    alltotal.forEach(each => {
        am += parseFloat(each.value);
    })
    document.getElementById("all_total_amount").value = am;

}




function tdsAmountData(i) {

    var tds_amount = "tds_amount" + i;
    var total_amount = "total_amount" + i;
    var securityClick_amount = "securityClick" + i + "ledger";
    var registrationClick_amount = "registrationClick" + i + "ledger";
    var previousClick_amount = "previousClick" + i + "ledger";
    var onAccountClick_amount = "onAccountClick" + i + "ledger";




    var final_tds_amount = document.getElementById(tds_amount) ? document.getElementById(tds_amount).value : '0';
    var final_total_amount = document.getElementById(total_amount) ? document.getElementById(total_amount).value : '0';
    var final_securityClick_amount = document.getElementById(securityClick_amount) ? document.getElementById(securityClick_amount).value : '0';
    var final_registrationClick_amount = document.getElementById(registrationClick_amount) ? document.getElementById(registrationClick_amount).value : '0';
    var final_previousClick_amount = document.getElementById(previousClick_amount) ? document.getElementById(previousClick_amount).value : '0';
    var final_onAccountClick_amount = document.getElementById(onAccountClick_amount) ? document.getElementById(onAccountClick_amount).value : '0';


    var final_amount = parseFloat(final_tds_amount) + parseFloat(final_total_amount);

    // var divide = parseFloat(final_amount)/2;

    var final_divide = isNaN(final_amount) ? '0' : final_amount;


    document.getElementById(securityClick_amount) ? document.getElementById(securityClick_amount).value = final_divide : '0';
    document.getElementById(registrationClick_amount) ? document.getElementById(registrationClick_amount).value = '0' : '0';
    document.getElementById(previousClick_amount) ? document.getElementById(previousClick_amount).value = final_divide.toFixed(2) : '0';
    document.getElementById(onAccountClick_amount) ? document.getElementById(onAccountClick_amount).value = '0' : '0';


}



// for cheking undefined and empty
function CheckNullUndefined(value) {
    return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}


//   function erasePreviousData(i){
//     $("#cheque_no"+i).val('');
//     $("#date"+i).val('');
//     $("#bank"+i).val('').trigger('change');
//     $("#total_amount"+i).val('');
//     $("#tds_amount"+i).val('');
//     $("#transactionno"+i).val('');
//     $("#securityClick"+i).attr('checked' , 'false');
//     $("#previousClick"+i).attr('checked' , 'false');
//     $("#securityClick"+i+"ledger").val(0);
//     $("#registrationClick"+i+"ledger").val(0);
//     $("#previousClick"+i+"ledger").val(0);
//     $("#onAccountClick"+i+"ledger").val(0);

//   }