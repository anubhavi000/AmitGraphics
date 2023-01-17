
// function confirMationAlert(){

//     // $('#confirmationModal').modal('show');
//         //  alert("this is called");
//   let route= $("input[name=route]").val();
//   let id= $("#delete_id").val();


//   final_route= `${route}/${id}`;
                
               
//   $("#confirmationmodalbtn").click() ;
 
//   $("#confirmationModalForm").attr("action", final_route);  

//     //    alert( id)

//     // $.ajaxSetup({
//     //     headers: {
//     //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     //     }});
//     //     $.ajax({
//     //         type: "get",
//     //         url:  app_url+ 'confirmationAlert',
//     //         dataType: 'json',
//     //         data: {'route': route , id:id},
//     //         success: function (data) 
//     //         {
             
//     //             if(data.code == 401)
//     //             {
//     //                 // //console.log("error show");
//     //             }
//     //             else if(data.code == 200)
//     //             { 
//     //             //    console.log(data.response[0]);
//     //             if(data.response!=null){
//     //                 var route_name = data.response[0];
//     //                 var delete_id  = data.response[1];
//     //             }
//     //             final_route= `${route_name}/${delete_id}`;
                
               
//     //             $("#confirmationmodalbtn").click() ;
               
//     //             $("#confirmationModalForm").attr("action", final_route);    

//     //             }
                
//     //         }
        
//     //     });
//     }
            function confirMationAlert(no){

           // console.log(no);
                $('#confirmationModal').modal('show');
               
              
              let route= $("#route_id"+no).val();
              let id= $("#delete_id"+no).val();
            //   alert(id);

              final_route= `${route}/${id}`;
                            
                           
              $("#confirmationmodalbtn").click() ;
             
              $("#confirmationModalForm").attr("action", final_route);  

                //    alert( id)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
                    $.ajax({
                        type: "get",
                        url:  app_url+ 'confirmationAlert',
                        dataType: 'json',
                        data: {'route': route , id:id},
                        success: function (data) 
                        {
                         
                            if(data.code == 401)
                            {
                                // //console.log("error show");
                            }
                            else if(data.code == 200)
                            { 
                            //    console.log(data.response[0]);
                            if(data.response!=null){
                                var route_name = data.response[0];
                                var delete_id  = data.response[1];
                            }
                            final_route= `${route_name}/${delete_id}`;
                            
                           
                            $("#confirmationmodalbtn").click() ;
                           
                            $("#confirmationModalForm").attr("action", final_route);    

                            }
                            
                        }
                    
                    });
                }


                // confirmation alert for generate buttons 

                
            function confirMationAlert1(){

                // $('#confirmationModal').modal('show');
                    //  alert("this is called");
              let route= $("input[name=route]").val();
              let id= $("#delete_id").val();


              final_route= `${route}/${id}`;
                            
                           
              $("#confirmationmodalbtn1").click() ;
             
              $("#confirmationModalForm1").attr("action", final_route);    


              // console.log(route,id);

                //    alert( id)

                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }});
                //     $.ajax({
                //         type: "get",
                //         url:  app_url+ 'confirmationAlert',
                //         dataType: 'json',
                //         data: {'route': route , id:id},
                //         success: function (data) 
                //         {
                         
                //             if(data.code == 401)
                //             {
                //                 // //console.log("error show");
                //             }
                //             else if(data.code == 200)
                //             { 
                //             //    console.log(data.response[0]);
                //             if(data.response!=null){
                //                 var route_name = data.response[0];
                //                 var delete_id  = data.response[1];
                //             }
                //             final_route= `${route_name}/${delete_id}`;
                            
                           
                //             $("#confirmationmodalbtn1").click() ;
                           
                //             $("#confirmationModalForm1").attr("action", final_route);    

                //             }
                            
                //         }
                    
                //     });
                }


                
          