
$( ".client" ).select2({
ajax: { 
 url: app_url+"getclientoptions",
 type: "get",
 dataType: 'json',
 delay: 250,
 data: function (params) {
  if(params.term !=undefined && params.term.length>=3){
    return {
       _token:$('meta[name="csrf-token"]').attr('content'),
       search: params.term // search term
      
    };}
 },
 processResults: function (response) {
  // console.log(response.status);
   return {
     results: response
   };
 },
 cache: true
}

});
$( ".ledger" ).select2({
  ajax: { 
   url: app_url+"getledgerclientoptions",
   type: "get",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    if(params.term !=undefined && params.term.length>=3){
      return {
         _token:$('meta[name="csrf-token"]').attr('content'),
         search: params.term // search term
        
      };}
   },
   processResults: function (response) {
     return {
       results: response
     };
   },
   cache: true
  }

});
$( ".ledger_expense" ).select2({
  ajax: { 
   url: app_url+"getledgerclientoptionsexpense",
   type: "get",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    if(params.term !=undefined && params.term.length>=3){
      return {
         _token:$('meta[name="csrf-token"]').attr('content'),
         search: params.term // search term
        
      };}
   },
   processResults: function (response) {
     return {
       results: response
     };
   },
   cache: true
  }

});

$( ".pharma_client").select2({
  ajax: { 
   url: app_url+"getpharmaclientoptions",
   type: "get",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    // alert(params.term)

    if(params.term !=undefined && params.term.length>=3){
     return {
        _token:$('meta[name="csrf-token"]').attr('content'),
        search: params.term // search term
       
     };}
   },
   processResults: function (response) {
     return {
       results: response
     };
   },
   cache: true
  }

});

$( ".file_no" ).select2({
ajax: { 
 url: app_url+"getfilenooptions",
 type: "get",
 dataType: 'json',
 delay: 250,
 data: function (params) {
  if(params.term !=undefined && params.term.length>=3){
    return {
       _token:$('meta[name="csrf-token"]').attr('content'),
       search: params.term // search term
      
    };}
 },
 processResults: function (response) {
   return {
     results: response
   };
 },
 cache: true
}

});
$( ".ledger_group" ).select2({
  ajax: { 
   url: app_url+"getledgergroupoptions",
   type: "get",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    if(params.term !=undefined && params.term.length>=3){
      return {
         _token:$('meta[name="csrf-token"]').attr('content'),
         search: params.term // search term
        
      };}
   },
   processResults: function (response) {
    // console.log(response.status);
    console.log(response);
     return {
       results: response
     };
   },
   cache: true
  }
  
  });


