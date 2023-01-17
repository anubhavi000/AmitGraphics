
let rate=0;
let billing_type=0;
let maximum_weight=0;
let total_beds=0;
let no_of_fixed_beds=0;
let fixed_amount_for_fixed_beds=0;
let excess_rate=0;
   function showfunction(value , type){  
    $('#overlay').show();

    if(CheckNullUndefined(value)){
        
    }else{
        var auth_id = 1;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url:  app_url + "get_credit_debit_details",
            dataType: 'json',
            data: {'hcf_client': value , 'note_type':type},
            success: function (data) 
            {
              
               
                
                if(data.code == 401)
                {
                    // console.log(data.message);
                    alert(data.message);
                    // $("#select2-hcf_Client-container").text('');
                    $("#hcf_Client").val('').trigger('change');
                    $('#overlay').hide();
                }
                else if(data.code == 200)
                { 
                    $('#overlay').hide();
                
                 let detailcontainer=document.getElementById("client_previous_bill_details");
                    let billing_date=document.getElementById("billing_Date");
                    if(data.response!==""){

                        last_billing_date= data.response[0].billing_date;
                        bill_date= last_billing_date.split("-").reverse().join("-");
                        billing_date.value=bill_date;
                        // document.getElementById("narration1").value='';
                        // billing_date.setAttribute("min" , data.response[0].billing_date);
                        // //console.log(data.response[1].billing_type);
                        let details='';
                        if(data.response[1].billing_type==1){
                         details=` <hr class="mt-3 border-dark bold"> <h5>Last Details  </h5> <h6> Last Note No: ${data.response[0].bill_no} <br> Last Created Date : ${bill_date} <br> Billing Type : ${data.response[3].text} <br> Fixed Amount : ${data.response[1].minimum_amount} <br> Maximum Weight : ${data.response[1].maximum_weight} <br> <br> Name :  ${data.response[1].business_name} <br> Address: ${data.response[2]} </h6> `
                        }
                        else if(data.response[1].billing_type==2){
                          
                         details=` <hr class="mt-3 border-dark bold"> <h5>Last Details   </h5> <h6> Last Note No: ${data.response[0].bill_no} <br> Last Created Date : ${data.response[0].billing_date} <br> Billing Type : ${data.response[3].text}  <br> Total Beds : ${data.response[1].per_bed_total_beds} <br>Fixed Beds : ${data.response[1].per_bed_fixed_beds}<br> Per Bed Amount : ${data.response[1].per_bed_amount} <br> Fixed Amount For Fixed Beds : ${data.response[1].per_bed_fixed_amount} <br> <br> Name :  ${data.response[1].business_name} <br> Address: ${data.response[2]} </h6> `
                      
                        }
                         else if(data.response[1].billing_type==3){
                          
                         details=` <hr class="mt-3 border-dark bold"> <h5>Last Details   </h5> <h6> Last Note No: ${data.response[0].bill_no} <br> Last Created Date : ${data.response[0].billing_date} <br> Billing Type : ${data.response[3].text} <br> Per Kg Amount : ${data.response[1].per_kg_amount} <br> Maximum Weight : ${data.response[1].per_kg_maximum_weight} <br> <br> Name :  ${data.response[1].business_name} <br> Address: ${data.response[2]} </h6> `
                      
                        }
                        detailcontainer.innerHTML=details;
                        
                        
                      
                       
                    }
                    else{
                        detailcontainer.innerHTML=`<hr class="mt-3 border-dark bold"> <h5>No Previous Details Found </h5>`;
                     billing_date.value=null;
                              billing_date.setAttribute("min" , " ");
                          // document.getElementById("narration").value=''
                    }
                        
                   
                }
                    else{
                    
                        alert_message(data.alert_message);
                        $('#overlay').hide();
                     
                    }
                    
                
            }
        })
    }
        
                
         
         
  }
  
function CheckNullUndefined(value) {
  return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}
  
 function checkBillingDate(date){
    $("#overlay").show();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url:  app_url + "check_billing_date",
        dataType: 'json',
        data: {'entered_date': date},
        success: function (data) 
        {
            if(data.code ==401){
                $("#overlay").hide();
              alert(data.message);
              $("#billing_Date").val('');
            }
            else if(data.code==200){
                $("#overlay").hide();
                // console.log(data);
            }
            else{
                $("#overlay").hide();
                 alert(data.message);
                 $("#billing_Date").val('');
            }
        }
    });
 }