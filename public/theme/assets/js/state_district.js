
            function get_district(str){

                $('#overlay').show();
                var value=str;
                // //console.log(value);
                // alert(value);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url:  app_url+ 'get_district',
                    dataType: 'json',
                    data: {'state_id': value},
                    success: function (data) 
                    {
                     
                        if(data.code == 401)
                        {
                            // //console.log("error show");
                        }
                        else if(data.code == 200)
                        { 
                            $('#overlay').hide();
                
                                let set = data.response;
                               

                                var dropdown= document.getElementById("district_name")
                        
                                var dropdown_option= `<option value=''>Select</option>`;
                                for(var i = 0; i < set.length; i++) {
                                    dropdown_option+=`<option value="`+set[i].id+`">`+set[i].district+`</option>`;
                                   
                               
                                }
                                if(dropdown_option===null){
                                     dropdown.innerHTML= "<option value=''>Select</option>";
                                }
                                else{
                                   dropdown.innerHTML= dropdown_option; 
                                }
                                 
                         
                         $(".chosen-select").trigger("chosen:updated");
                            }
                            else{
                               
                                alert_message(data.alert_message);
                               
                            }
                            
                        }
                
                });
            }
            function get_bill_district(str){

                $('#overlay').show();
                var value=str;
                // //console.log(value);
                // alert(value);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url:  app_url+ 'get_district',
                    dataType: 'json',
                    data: {'state_id': value},
                    success: function (data) 
                    {
                     
                        if(data.code == 401)
                        {
                            // //console.log("error show");
                        }
                        else if(data.code == 200)
                        { 
                            $('#overlay').hide();
                
                                let set = data.response;
                               

                                var dropdown= document.getElementById("bill_district_name")
                        
                                var dropdown_option= `<option value=''>Select</option>`;
                                for(var i = 0; i < set.length; i++) {
                                    dropdown_option+=`<option value="`+set[i].id+`">`+set[i].district+`</option>`;
                                   
                               
                                }
                                if(dropdown_option===null){
                                     dropdown.innerHTML= "<option value=''>Select</option>";
                                }
                                else{
                                   dropdown.innerHTML= dropdown_option; 
                                }
                                 
                         
                         $(".chosen-select").trigger("chosen:updated");
                            }
                            else{
                               
                                alert_message(data.alert_message);
                               
                            }
                            
                        }
                
                });
            }
            
              function get_bill_district(str , dist){
                $('#overlay').show();
                var value=str;
                //console.log(dist);
                // //console.log(value);
                // alert(value);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url:   app_url+ 'get_district',
                    dataType: 'json',
                    data: {'state_id': value},
                    success: function (data) 
                    {
                     
                        if(data.code == 401)
                        {
                            // //console.log("error show");
                        }
                        else if(data.code == 200)
                        { 
                            $('#overlay').hide();
                                let set = data.response;
                               

                                var dropdown= document.getElementById("bill_district_name")
                        
                                var dropdown_option= `<option value=''>Select</option>`;
                                for(var i = 0; i < set.length; i++) {
                                    if(set[i].id==dist){
                                            dropdown_option+=`<option selected value="`+set[i].id+`">`+set[i].district+`</option>`;  
                                    }
                                    else
                                    dropdown_option+=`<option value="`+set[i].id+`">`+set[i].district+`</option>`;
                                   
                               
                                }
                                if(dropdown_option===null){
                                     dropdown.innerHTML= "<option value=''>Select</option>";
                                }
                                else{
                                   dropdown.innerHTML= dropdown_option; 
                                }
                                 
                         
                         $(".chosen-select").trigger("chosen:updated");
                            }
                            else{
                               
                                alert_message(data.alert_message);
                               
                            }
                            
                        }
                
                });
            }
            function get_district(str , dist){

                $('#overlay').show();
                var value=str;
                //console.log(dist);
                // //console.log(value);
                // alert(value);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url:   app_url+ 'get_district',
                    dataType: 'json',
                    data: {'state_id': value},
                    success: function (data) 
                    {
                     
                        if(data.code == 401)
                        {
                            // //console.log("error show");
                        }
                        else if(data.code == 200)
                        { 
                            $('#overlay').hide();
                                let set = data.response;
                               

                                var dropdown= document.getElementById("district_name")
                        
                                var dropdown_option= `<option value=''>Select</option>`;
                                for(var i = 0; i < set.length; i++) {
                                    if(set[i].id==dist){
                                            dropdown_option+=`<option selected value="`+set[i].id+`">`+set[i].district+`</option>`;  
                                    }
                                    else
                                    dropdown_option+=`<option value="`+set[i].id+`">`+set[i].district+`</option>`;
                                   
                               
                                }
                                if(dropdown_option===null){
                                     dropdown.innerHTML= "<option value=''>Select</option>";
                                }
                                else{
                                   dropdown.innerHTML= dropdown_option; 
                                }
                                 
                         
                         $(".chosen-select").trigger("chosen:updated");
                            }
                            else{
                               
                                alert_message(data.alert_message);
                               
                            }
                            
                        }
                
                });
            }
            
            
            
              function get_district_second(str){
                $('#overlay').show();
                var value=str;
               
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url:  app_url+'get_district',
                    dataType: 'json',
                    data: {'state_id': value},
                    success: function (data) 
                    {
                  
                    
                        if(data.code == 401)
                        {
                            // //console.log("error show");
                        }
                        else if(data.code == 200)
                        { 
                            $('#overlay').hide();
                                let set = data.response;
                               

                                var dropdown= document.getElementById("district_name1")
                        
                                var dropdown_option= `<option value=''>Select</option>`;
                                for(var i = 0; i < set.length; i++) {
                                    dropdown_option+=`<option value="`+set[i].id+`">`+set[i].district+`</option>`;
                                   
                               
                                }
                                if(dropdown_option===null){
                                     dropdown.innerHTML= "<option value=''>Select</option>";
                                }
                                else{
                                   dropdown.innerHTML= dropdown_option; 
                                }
                                 
                         
                         $(".chosen-select").trigger("chosen:updated");
                            }
                            else{
                               
                                alert_message(data.alert_message);
                               
                            }
                            
                        }
             
                });
            }
    
           function get_district_second(str , dist){
            $('#overlay').show();
                var value=str;
                // //console.log(dist);
                // //console.log(value);
                // alert(value);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url:  app_url+'get_district',
                    dataType: 'json',
                    data: {'state_id': value},
                    success: function (data) 
                    {
                     
                        if(data.code == 401)
                        {
                            // //console.log("error show");
                        }
                        else if(data.code == 200)
                        { 
                            $('#overlay').hide();
                                let set = data.response;
                               

                                var dropdown= document.getElementById("district_name1")
                        
                                var dropdown_option= `<option value=''>Select</option>`;
                                for(var i = 0; i < set.length; i++) {
                                    if(set[i].id==dist){
                                            dropdown_option+=`<option selected value="`+set[i].id+`">`+set[i].district+`</option>`;  
                                    }
                                    else
                                    dropdown_option+=`<option value="`+set[i].id+`">`+set[i].district+`</option>`;
                                   
                               
                                }
                                if(dropdown_option===null){
                                     dropdown.innerHTML= "<option value=''>Select</option>";
                                }
                                else{
                                   dropdown.innerHTML= dropdown_option; 
                                }
                                 
                         
                         $(".chosen-select").trigger("chosen:updated");
                            }
                            else{
                               
                                alert_message(data.alert_message);
                               
                            }
                            
                        }
                
                });
            }
            
            
            
            