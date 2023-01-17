
let rate=0;
let billing_type=0;
let maximum_weight=0;
let total_beds=0;
let no_of_fixed_beds=0;
let fixed_amount_for_fixed_beds=0;
var selected_client_id=0;
let excess_rate=0;
   function showfunction(value){  
    $('#overlay').show();
      selected_client_id= value;
   
   
    if(value===""){
     document.getElementById('amount').disabled = true;
     document.getElementById('amount').value = '';

    }
    else{
    document.getElementById('amount').disabled = false;
    }

    // console.log(value);
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
            url:  app_url + "get_billing_details",
            dataType: 'json',
            data: {'hcf_client': value},
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
                        

                        var last_billing_date1= data.response[4].billing_date;
                        var bill_date1= last_billing_date1.split("-").reverse().join("-");
                        var plant_last_bill_date = bill_date1;
                        billing_date.value=bill_date1;
                        // document.getElementById("narration1").value='';
                        // billing_date.setAttribute("min" , data.response[0].billing_date);
                        // //console.log(data.response[1].billing_type);
                        let details='';
                        if(data.response[1].billing_type==1){
                         details=` <hr class="mt-3 border-dark bold"> <h5>Last Billing Details Of This Client </h5> <h6> Plant Wise Last Bill No: ${data.response[4].bill_no} <br>  Plant Wise Last Billing Date: ${plant_last_bill_date} <br>  Last Bill No: ${data.response[0].bill_no} <br> Last Billing Date : ${data.response[0].billing_date1} <br> Billing Type : ${data.response[3].text} <br> Fixed Amount : ${data.response[1].minimum_amount} <br> Maximum Weight : ${data.response[1].maximum_weight}<br> is Arrear Applicalble : ${(data.response[1].is_arrears_applied == 1)?'True':'False'} <br> <br> Name :  ${data.response[1].business_name} <br> Address: ${data.response[2]} </h6> `
                        }
                        else if(data.response[1].billing_type==2){
                          
                         details=` <hr class="mt-3 border-dark bold"> <h5>Last Billing Details Of This Client </h5> <h6> Plant Wise Last Bill No: ${data.response[4].bill_no} <br>  Plant Wise Last Billing Date: ${plant_last_bill_date} <br>  Last Bill No: ${data.response[0].bill_no} <br> Last Billing Date : ${data.response[0].billing_date1} <br> Billing Type : ${data.response[3].text}  <br> Total Beds : ${data.response[1].per_bed_total_beds} <br>Fixed Beds : ${data.response[1].per_bed_fixed_beds}<br> is Arrear Applicalble : ${(data.response[1].is_arrears_applied == 1)?'True':'False'}<br> Per Bed Amount : ${data.response[1].per_bed_amount} <br> Fixed Amount For Fixed Beds : ${data.response[1].per_bed_fixed_amount} <br> <br> Name :  ${data.response[1].business_name} <br> Address: ${data.response[2]} </h6> `
                      
                        }
                         else if(data.response[1].billing_type==3){
                          
                         details=` <hr class="mt-3 border-dark bold"> <h5>Last Billing Details Of This Client </h5> <h6> Plant Wise Last Bill No: ${data.response[4].bill_no} <br>  Plant Wise Last Billing Date: ${plant_last_bill_date} <br>  Last Bill No: ${data.response[0].bill_no} <br> Last Billing Date : ${data.response[0].billing_date1} <br> Billing Type : ${data.response[3].text} <br> Per Kg Amount : ${data.response[1].per_kg_amount} <br> Maximum Weight : ${data.response[1].per_kg_maximum_weight} <br> is Arrear Applicalble : ${(data.response[1].is_arrears_applied == 1)?'True':'False'}<br> <br> Name :  ${data.response[1].business_name} <br> Address: ${data.response[2]} </h6> `
                      
                        }
                        detailcontainer.innerHTML=details;
                        
                        
                      
                       
                    }
                    else{
                        detailcontainer.innerHTML=`<hr class="mt-3 border-dark bold"> <h5>No Previous Billing Details Found For This Client </h5>`;
                     billing_date.value=null;
                              billing_date.setAttribute("min" , " ");
                          // document.getElementById("narration").value=''
                    }
                        
                    calculateTotalAmount();
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
  
 function calculateTotalAmount(){
     let service_start_date=document.getElementById("service_start_date").value;
     start_date= service_start_date.split("-").reverse().join("-");
     let year= new Date(start_date).getFullYear();
    let month= new Date(start_date).getMonth();

    //   let month= document.getElementById("month").value;
      let end=document.getElementById("service_end_date")
    //   end.setAttribute("min" ,start_date);
     service_end_date=end.value;
     end_date = service_end_date.split("-").reverse().join("-");
      let client_id=document.getElementById("hcf_Client").value;
      if(start_date!==''&&end_date!==''){
  
        //console.log(month);  
const diffInMs= new Date(end_date) - new Date(start_date)
const no_of_days = diffInMs / (1000 * 60 * 60 * 24)+1;
       
          let total_amount=0;
          
              var auth_id = 1;
              var bill_month = $("#bill_month").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url:  app_url +"calculatebill",
                    dataType: 'json',
                    data: {'hcf_client': client_id, 'start_date':start_date , 'end_date':end_date,'billing_month':bill_month ,'auth_id': auth_id},
                    success: function (data) 
                    {
                      
                       
                        
                        if(data.code == 401)
                        {
                            alert(data.message);
                            //console.log("error show");
                        }
                        else if(data.code == 200)
                        { 
                            if(CheckNullUndefined(data.message)){
                            }else{
                                $("#warning_messages").html('');
                                if(data.message == true){
                                    var append_str = "<div style='color:green; border: 1px solid; text-align:center; padding:5px;'>Account Posting Ok </div>";
                                }else{
                                    var append_str = "<div style='color:red; border: 1px solid; text-align:center; padding:5px;'>"+data.message+"</div>";
                                }
                                $("#warning_messages").html(append_str);
                            }
                            // console.log(data);
                            document.getElementById("amount").value='';
                            document.getElementById("total_collection").value='';
                            document.getElementById("weight_limit").value='';
                            document.getElementById("rate").value='';
                            document.getElementById("excess_rate").value='';
                            document.getElementById("total_bed").value='';
                            document.getElementById("total_collection").value='';
                            // console.log(data.rate);
                            document.getElementById("bill_fixed_amount").value=0;
                            document.getElementById("arrear_value").value=0;

                            document.getElementById("amount").value=data.calculated_amount.toFixed(2);
                            document.getElementById("total_collection").value=data.total_collection.toFixed(2);
                            document.getElementById("weight_limit").value=data.weight_limit;
                            document.getElementById("rate").value=data.rate;
                            document.getElementById("excess_rate").value=data.excess_rate;
                            document.getElementById("total_bed").value=data.total_bed;
                            document.getElementById("total_collection").value=data.total_collection_cus;
                            document.getElementById("bill_fixed_amount").value=data.bill_fixed_amount;
                            document.getElementById("arrear_value").value=data.arrear;
                            //console.log(data);
                          //   if(data.occupancy_details!=''){
                          //       let supply_charge=data.occupancy_details.supply_charge;
                          //        let service_charge=data.occupancy_details.service_charge;
                          //         let occupancy=data.occupancy_details.occupancy;
                          //          let total_beds=data.occupancy_details.total_beds;
                          //          let billing_beds=total_beds*occupancy/100;
                          //          total_amount=Math.ceil(no_of_days*billing_beds*supply_charge+no_of_days*billing_beds*service_charge);
                          //   }
                            
                          //   else{
                          //     billing_type=data.response[1].billing_type;
                          //     supply_charge= Number(data.response[1].supply_charges);
                          //       if(billing_type==1){
                          //             rate=(data.response[1].minimum_amount);
                                 
                          //                 //   month wise rate 
                          //          if(month==0){
                          //             rate= rate/31;
                          //                }
                          //                else if(month==1){
                          //                    if(year/4==0){
                          //                            rate= rate/29;
                          //                    }
                          //                    else{
                          //                       rate= rate/28;
                          //                    }
                                  
                          //                }
                          //                else if(month==2){
                          //             rate= rate/31;
                          //                }
                          //                else if(month==3){
                          //             rate= rate/30;
                          //                }
                          //                else if(month==4){
                          //             rate= rate/31;
                          //                }else if(month==5){
                          //             rate= rate/30;
                          //                }else if(month==6){
                          //             rate= rate/31;
                          //                }
                          //                else if(month==7){
                          //             rate= rate/31;
                          //                }else if(month==8){
                          //             rate= rate/30;
                          //                }
                          //        else if(month==9){
                          //             rate= rate/31;
                          //                }
                          //        else if(month==10){
                          //             rate= rate/30;
                          //                }
                          //                else if(month==11){
                          //             rate= rate/31;
                          //                }
                          //                else{
                          //                    rate=rate/30;
                          //                }
                                      
                          //             maximum_weight=data.response[1].maximum_weight;
                          //             total_beds=data.response[1].fixed_amount_total_beds;
                          //             excess_rate=data.response[1].excess_rate;
                                      
                          //       }
                          //       else if(billing_type==2){
                          //            rate=data.response[1].per_bed_amount;
                          //               maximum_weight=data.response[1].per_bed_maximum_weight;
                          //               no_of_fixed_beds=data.response[1].per_bed_fixed_beds;
                          //               fixed_amount=data.response[1].per_bed_fixed_amount;
                          //               total_beds=data.response[1].per_bed_total_beds;
                          //               excess_rate=data.response[1].per_bed_excess_bill;
                                        
                          //               if(month==0){
                          //             fixed_amount_for_fixed_beds= fixed_amount/31;
                          //                }
                          //                else if(month==1){
                          //                       if(year/4==0){
                          //                            fixed_amount_for_fixed_beds= fixed_amount/29;
                          //                    }
                          //                    else{
                          //                     fixed_amount_for_fixed_beds= fixed_amount/28;
                          //                    }
                                     
                          //                }
                          //                else if(month==2){
                          //             fixed_amount_for_fixed_beds= fixed_amount/31;
                          //                }
                          //                else if(month==3){
                          //             fixed_amount_for_fixed_beds= fixed_amount/30;
                          //                }
                          //                else if(month==4){
                          //             fixed_amount_for_fixed_beds= fixed_amount/31;
                          //                }else if(month==5){
                          //             fixed_amount_for_fixed_beds= fixed_amount/30;
                          //                }else if(month==6){
                          //             fixed_amount_for_fixed_beds= fixed_amount/31;
                          //                }
                          //                else if(month==7){
                          //             fixed_amount_for_fixed_beds= fixed_amount/31;
                          //                }else if(month==8){
                          //             fixed_amount_for_fixed_beds= fixed_amount/30;
                          //                }
                          //        else if(month==9){
                          //             fixed_amount_for_fixed_beds= fixed_amount/31;
                          //                }
                          //        else if(month==10){
                          //             fixed_amount_for_fixed_beds= fixed_amount/30;
                          //                }
                          //                else if(month==11){
                          //             fixed_amount_for_fixed_beds= fixed_amount/31;
                          //                }
                          //                else{
                          //                       fixed_amount_for_fixed_beds= fixed_amount/30;
                          //                }
                          //       }
                          //       else if(billing_type==3){
                          //            rate=data.response[1].per_kg_amount;
                          //               maximum_weight=data.response[1].per_kg_maximum_weight;
                          //                 total_beds=data.response[1].per_kg_total_beds;
                          //                 excess_rate=data.response[1].excess_rate;
                          //                 excess_rate=data.response[1].per_kg_excess_bill;
                          //       }
                             
                              
                              
                        
                            
                            
                            
                          // let total_collection=data.response[0];
                          // if(billing_type==1){
                            
                          //      excess_weight=total_collection-maximum_weight;
                             
                            
                          //   if(excess_weight>0){
                          //          total_amount=Math.ceil(rate*no_of_days+excess_rate*excess_weight);
                          //   }
                          //   else{
                          //          total_amount=Math.ceil(rate*no_of_days);
                          //   }
                          
                          // }
                          // else if(billing_type==2){
                          //     no_of_beds=total_beds-no_of_fixed_beds;
                           
                          //      excess_weight=total_collection-maximum_weight;
                          //      if(excess_weight>0){
                          //               total_amount=Math.ceil(rate*no_of_beds*no_of_days+fixed_amount_for_fixed_beds*no_of_days+excess_rate*excess_weight);
                          //      }
                          //      else{
                          //          total_amount=Math.ceil(rate*no_of_beds*no_of_days+fixed_amount_for_fixed_beds*no_of_days);
                          //      }
                          
                        
                          
                          // }
                          
                          //    else if(billing_type==3){
                             
                            
                          //      excess_weight=total_collection-maximum_weight;
                          //      if(excess_weight>0){
                          //                 total_amount=Math.ceil(rate*maximum_weight+excess_rate*excess_weight);
                          //      }
                          //      else{
                          //                 total_amount=Math.ceil(rate*maximum_weight);
                          //      }
                        
                         
                          
                          // }
                          //   }
                          
                          // document.getElementById("amount").value=total_amount;
                         
                        }
                    }
                });
          
      }
 }

 function checkBillingDate(date){
    if(selected_client_id ==0){
       alert("please Select Client");
    }else{
    


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
        data: {'entered_date': date , 'client_id': selected_client_id},
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
 }