$statuses = ['Pending','Approved','Inactive'];
$statusClass = ['info','success','danger'];
function toggle_back_image(_this){
  if($(_this).find('option[value="'+_this.value+'"]').hasClass('required-back')){
    $($(_this).data('target')).show();
    $($(_this).data('target')).find('input[type="file"]').removeAttr('disabled');
  }else{
    $($(_this).data('target')).hide();
    $($(_this).data('target')).find('input[type="file"]').attr('disabled','disabled');
  }
}
function open_update_status_modal(_this,target){
  console.log(_this.value);
  _f = $(target).find('form');
  _f.attr('action',$(_this).data('action'));
  _f.find('[name="status"]').val(_this.value);
  $(target).show();
}
function open_update_parent_modal(_this,target){
  console.log(_this.value);
  _f = $(target).find('form');
  _f.attr('action',$(_this).data('action'));
  $(target).show();
}

(function($){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(window).on('onload,beforeunload', function(){
  $('#global-loader').show();
});
 $(document).on('ready', function(){
  $('#global-loader').hide();
  setTimeout(function(){
    $('.flash-message').html('');
  },5000);
});
 $( document ).ajaxStart(function() {
   $('#global-loader').show();
 });
 $( document ).ajaxStop(function() {
  setTimeout(function(){  $('#global-loader').hide(); }, 500);

});
 $( document ).ajaxComplete(function() {
   setTimeout(function(){  $('#global-loader').hide(); }, 500);
 }); 
 function readURL(input) {
  if($(input).closest('.form-group').find('.badge').length){
    $(input).closest('.form-group').find('.badge').text(input.files[0].name);
  }else if($(input).next('.custom-file-label').length){
    $(input).next('.custom-file-label').text(input.files[0].name);
  }
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
     $('#'+ input.id+'-preview').attr('src', e.target.result);
   }
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }else{
    $('#'+ input.id+'-preview').attr('src', null);
  }
}
$('.datepicker:not(#from_date,#to_date)').each(function() {
  $(this).datepicker({
    dateFormat: 'dd-mm-yy'
  });
});

$("#from_date").datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    maxDate:  new Date($("#to_date").val()),
    onSelect: function(){
        $('#to_date').datepicker('option', 'minDate', $("#from_date").datepicker("getDate"));
    }
});
// .datepicker("setDate", new Date($("#from_date").val()));


$("#to_date").datepicker({
    dateFormat: 'dd-mm-yy',
    changeMonth: true,
    changeYear: true,
    minDate:  new Date($("#from_date").val()),
    onSelect: function(){
        $('#from_date').datepicker('option', 'maxDate', $("#to_date").datepicker("getDate"));
    }
});
// .datepicker("setDate", new Date($("#to_date").val()));

$(document).on('change',"input[type='file']",function() {
  readURL(this);
});
// $(document).on('change',"input[type='file'].media-file",function() {
//   readURL(this);
//   $(this.form).ajaxSubmit();
// });
function parseResponse(response,form){
  status = response.status == 'error'?'danger':response.status;
  $('.flash-message').html('<p class="alert alert-'+status+'">'+response.message+'</p>');
  setTimeout(function(){
    $('.flash-message').html('');
  },3000);
   if(response.errors !=undefined){
    $.each( response.errors, function( key, value ) {
      console.log(key);
      if(key.indexOf('.')!=-1){
        _key = key.split('.');
        key = _key[0];
        _key.shift();
        key += '['+ _key.join('][')+']';
      }
      if($(form).length)
     {
      // console.log($(form).find('[name="'+key+'"]').closest('.input-group'));
      if($(form).find('[name="'+key+'"]').siblings('.invalid-feedback').length){
        $(form).find('[name="'+key+'"]').siblings('.invalid-feedback').text(value);
        $(form).find('[name="'+key+'"]').addClass('is-invalid');
      }
      else if($(form).find('[name="'+key+'"]').closest('.input-group').siblings('.invalid-feedback').length)
      {
        $(form).find('[name="'+key+'"]').closest('.input-group').siblings('.invalid-feedback').text(value).show();
        $(form).find('[name="'+key+'"]').closest('.input-group').addClass('is-invalid');
      }
    }
  });
  }
  if(response.action!=undefined){
    if(response.action=='reload'){
      location.reload();
    }
    if(response.action=='redirect' && response.url!=undefined){
      location.href=response.url;
    }
  }
}
$(document).on('click','.trigger-xhr',function(e){
  e.preventDefault();
  _t = $(this);
  var form = _t.closest('form');
  $.ajax({
    url: _t.attr('href'),
    method: _t.data('method'),
    beforeSend: function() {
      $(form).find('.invalid-feedback').text('');
      $(form).find('.is-invalid').removeClass('is-invalid');
    },
    success: function(response,xhr){
      parseResponse(response,form)
    },
    error:function(xhr,status,error){
      response = xhr.responseJSON;
      if(status=='error'){
        parseResponse(response,form);
      }
    }
  });
});
$('.ajax-form').ajaxForm({
  beforeSubmit: function(arr, form, options){
    $(form).find('.invalid-feedback').text('');
    $(form).find('.is-invalid').removeClass('is-invalid');
  },
  success:function(response,status, xhr,form){
   $('#global-loader').hide();
   fn = eval($(form).data('onsuccess'));
   if(typeof fn =='function'){
    fn(response,form) 
  }
  parseResponse(response,form)
},
error:function(xhr,status,error,form){
  $('#global-loader').hide();
  response = xhr.responseJSON;
  if(status=='error'){
    parseResponse(response,form);
  }
  return false;
}
});
if($("#e4").length){
  $("#e4").select2({
    formatResult: format,
    formatSelection: format,
    escapeMarkup: function(m) { return m; }
  });
}

function showmpinform(res){
  if(res.status=='success' && res.message=='Verified'){
    $('#verify-section').hide();
    $('#change-psd').show();
  }
}
function shownext(res,form){
  if(res.status=='success'){
    if(res.data != undefined&& res.data.id !=undefined){
      $("[name='_id']").val(res.data.id);
    }
    $(form).closest('._section-form').hide();
    $($(form).data('next')).show();
  }
}
function update_status(res,form){
    target = $(form).data('target');
    if($(target).length){
   $(target).attr('class', '');
     $(target).addClass('badge').addClass('badge-'+$statusClass[res.data.status]).text($statuses[res.data.status]);
   }
   $(form).hide();
   if($(form).closest('.status-form-wrapper').length){
     $(form).closest('.status-form-wrapper').find(res.data.status==1 ?'.inactive':'.active').show();
   }
}


$('.depenent-cities,.depenent-states').each(function(){
  console.log(this);
  $this = this;
  $("#"+this.id).depdrop({
    depends: $($this).data('depend').split(','),
    url: $($this).data('url')
    // initialize: true
  });
});
// $('._section-form').show();
$(document).on('keypress','.number',function(){
  return  !(isNaN(this.value + String.fromCharCode(event.keyCode)));
});
$(document).on('keypress','.mobile',function(){
  return  !isNaN(this.value + String.fromCharCode(event.keyCode)) && (this.value + String.fromCharCode(event.keyCode)).length <= 10;  
});
$(document).on('keyup','.onlyalpha',function(){
    if (this.value.match(/[^a-zA-Z ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z ]/g, '');
        }
});
$(document).on('keyup','.onlynumber',function(){
    if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        }
});
$(document).on('keyup','.onlyalphanumber',function(){
    if (this.value.match(/[^a-zA-Z0-9]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        }
});
$(document).on('change','#same_as_above',function(e){
  if($(this).is(':checked')){
    $('[name="resident[house_no]"]').val($('[name="business[house_no]"]').val());
    $('[name="resident[full_address]"]').val($('[name="business[full_address]"]').val());
    $('[name="resident[landmark]"]').val($('[name="business[landmark]"]').val());
    $('[name="resident[pincode]"]').val($('[name="business[pincode]"]').val());
    
    $('[name="resident[country]"]').val($('[name="business[country]"]').val());
    if($('[name="business[state]"]').val()){
       $('[name="resident[state]"]').html($('[name="business[state]"]').html());  
      $('[name="resident[state]"]').val($('[name="business[state]"]').val()).removeAttr('disabled');  
    }
    if($('[name="business[city]"]').val()){
      $('[name="resident[city]"]').html($('[name="business[city]"]').html());  
      $('[name="resident[city]"]').val($('[name="business[city]"]').val()).removeAttr('disabled');  
    }
  } 
 });
$(document).on('click','main img:not(#preview-popup-wrapper img)',function(){
  $('#preview-popup-wrapper img').attr('src',this.src).parent().show();
});
$(document).on('click','#preview-popup-wrapper',function(){
  $(this).hide();
});
$('[name="idproof[document_type]"]').change();
$('[name="addressproof[document_type]"]').change();

$(document).on('change','.check-checkbox',function(){
  if($(this).hasClass('select-all-trash')){
    $('.check-checkbox:not(.select-all-trash)').prop('checked',$(this).is(':checked'));
  }
   var ids = [];
    $('.check-checkbox:not(.select-all-trash):is(:checked)').each(function(){
      ids.push(this.value);
    });
    $('#trash_ids').val(ids);
  if($('.check-checkbox:not(.select-all-trash):is(:checked)').length){
   
     $('#trash_ids_delete').removeClass('d-none');
  }else{
     $('#trash_ids_delete').addClass('d-none');
  }
});
$(document).on('click','.modal .close',function(e){
  e.preventDefault();
  $(this).closest('.modal').hide();
});
})(jQuery);


