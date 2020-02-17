var csrfToken = jQuery('meta[name="csrf-token"]').attr("content");
var url = jQuery('meta[name="url"]').attr("content");

/*********************************************************************
 @ preview main image
*********************************************************************/
function readURL(input,img) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#'+img).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function myFunction(){
    var val = $('#pro_cat').val();
    jQuery.ajax({
            type: 'post',
            url: url + 'products/getsubcategory',
            datatype: 'json',
            data: {_csrf: csrfToken, id: val}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            beforeSend: function () {
                
            },
            success: function (response) {
                if (response.status == 'success') {
                   $( "select#product_subcategory_id" ).html(response.data);

                   
                } else if (response.status == 'failed') {
                    
                }
            },
            error: function (responce) {
            }
        });
}
function savetemp(e){
    
     var form = $('form').get(0);
     // e.preventDefault();
         jQuery.ajax({
            type: 'post',
            url: url + 'purchase/temp',
            processData: false,
            contentType: false,
            data: new FormData(form), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            beforeSend: function () {
                
            },
            success: function (response) {
                if (response.status == 'success') {
                    $('#modall').modal('show');
                    $('#modalprevie').html(response.view);
                    $('#van_name').html(''); 
                }
                else{
                    $('#van_name').html(response.error1);
                    $('#purchase-invoice_no').parent().addClass('has-error');
                    $('#purchase-invoice_no').next().text(response.error2);
                  //  alert('Invoice No. already has been taken');
                }
            },
            error: function (responce) {
            }
        });
}
$('#modall .close').click(function(){
    jQuery.ajax({
            type: 'post',
            url: url + 'purchase/truncate',
            processData: false,
            contentType: false,
            data: false, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            beforeSend: function () {
                
            },
            success: function (response) {
                if (response.status == 'success') {
             
                   
                }
            },
            error: function (responce) {
            }
        });
});
 $('.update-modal-click').click(function () {
    $('#update-modal').modal('show');
    // .find('#updateModalContent');
    // .load($(this).attr('value'));
    var vall = $(this).attr('invento');
    var idd = $(this).attr('idd');
    $('#purchaseit').val(vall);
    $('#modelid').val(idd);
});

$('#invo').click(function () {
    var quan = $('#purchaseit').val();
    var id = $('#modelid').val();
    if (quan === '' && !$.trim(quan).length) {
        return false;
    }
  jQuery.ajax({
            type: 'post',
            url: url + 'packages/inv',
            datatype: 'json',
            
             data: {_csrf: csrfToken,id:id,quan:quan}, 
            beforeSend: function () {
                
            },
            success: function (response) {
                if (response.status == 'success') {
             
                   
                }
            },
            error: function (responce) {
            }
        });
    });

function RemoveImage(name,id){
                var current_val = $('#gal_img').val();
                var string_to_array = current_val.split(",");
                var new_val_array = 
                    jQuery.grep(string_to_array, function(value) {
                        return value != name;
                    });
                    var new_val = new_val_array.join(',');

//                     if(new_val !== ''){
//                        var all_ids = new_val+','+name;
//                    }else{
//                        var all_ids = valuee;
//                    }
                    $('#gal_img').val(new_val);
                    $('#farm_'+id).attr('style','display:none;');
//                alert(selectedid);
            }

/*********************************************************************
 @ preview image other images
*********************************************************************/
window.onload = function () {
    var newImgIndex=0;
    var allNewImages=[];
    $("#fileupload").change(function () {
        var fileUpload = document.getElementById("fileupload");
        if (typeof (FileReader) != "undefined") {
            var dvPreview = document.getElementById("dvPreview");
            var regex = /^([a-zA-Z0-9\s_\\.\-:\!\@\#\$\%\&\*\(\)])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            for (var i = 0; i < fileUpload.files.length; i++) {
                var file = fileUpload.files[i];
                allNewImages.push(fileUpload.files[i].name);
                if (regex.test(file.name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var newItem = document.createElement("DIV");
                        var clrDIV = document.createElement("a");
                        clrDIV.className = "close-btn";
                        newItem.className = "uploaded-content other-img pull-left";
                        var img = document.createElement("IMG");
                        img.src = e.target.result;
                        img.width = "400";
                        img.height = "158";
                        dvPreview.appendChild(newItem);
                        var el = document.getElementsByClassName('remove' + j);
                        clrDIV.id = "bottom" + j;
                        newItem.id = "imgli" + j;
                        clrDIV.setAttribute("onclick", "removerOtherimg('imgli" + j + "','"+allNewImages[newImgIndex]+"')");
                        newItem.appendChild(img);
                        newItem.appendChild(clrDIV);
                        j++;
                        newImgIndex++;
                        console.log(allNewImages);
                    }
                    reader.readAsDataURL(file);
                } else {
                    dvPreview.innerHTML = "";
                    return false;
                }
            }
        } else {
            console.log("This browser does not support HTML5 FileReader.");
        }
    });
    var j = $('#hiddenImagesCount').val();
    var j = j++;
    
};
/*********************************************************************
 @ remove image on click cross icon
*********************************************************************/
function removerOtherimg(liid,name)
{   
    $('div#'+liid).remove();
    if(name){
        alreadydel = $('#hiddenImagetoDel').val();
        if(alreadydel == ''){
            newdel = name;
        }else{
        newdel = alreadydel+','+name;
        }
        $('#hiddenImagetoDel').val(newdel);
    }    
}
/*********************************************************************
 @ document ready
*********************************************************************/
$(document).ready(function(){
        $("#modelimgfileupload").change(function(){
        readURL(this,'product-main-img');
        });
        $("#modelimgfileupload-primary").change(function(){
        readURL(this,'product-main-img-primary');
        });
	$(".datepicker").datepicker({ //minDate: 0 
            });
        $( ".datepicker" ).datepicker( "option", "dateFormat", "yy-m-d" );
        $('.add-item').click(function(){
            setTimeout(function(){
                $(".startdatepickerexp").datepicker({ minDate:'-1Y',changeMonth: true,
        changeYear: true, });
        $( ".startdatepickerexp" ).datepicker( "option", "dateFormat", "yy-m-d" );
        
        $('.kv-plugin-loading').hide();
     //   $('.selectpicker').select2();
            }, 1000)
            
        });
        
/*********************************************************************
 @ integer only keyboard enabled
*********************************************************************/
            $(".intOnly").keydown(function (e) {
        // Allow: backspace, delete, tab, escape and enter
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
      
     
    
})
// *******************************************/
$(function() {

    $( ".startdatepickerexp" ).datepicker({ 
        changeMonth: true,
        changeYear: true,
      //  yearRange: "+100:-100",
        minDate: '-1Y',
           });
//     $( ".startdatepicker" ).datepicker({ 
//    //  changeMonth: true,
//       // changeYear: true,
//       //yearRange: "+100:-100",
//       // maxDate: 'today',
//       
//    });
});
$( function() {
    var dateFormat = "d MM, yy",
      from = $( ".startdatepicker" )
        .datepicker()
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".enddatepicker" ).datepicker()
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      }
      catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  

  $("#select_user").autocomplete({ 
               appendTo: ".srch_place",
               source: url + 'orders/select-user',
               select: function (e, ui) { 
                      $("#buyer_id").val(ui.item.type);
           },
        })._renderItem = function(ul, item) {

            if(item.value != ''){
                return $('<li>')
                .append('<a>'+item.value+'</a>')
                .appendTo(ul);
            }else{
                return $('<li>')
                .append('<a>No results found</a>')
                .appendTo(ul);
            }
        };
        
        
  $(document).on("click", "#select_User_next", function () {
    if ($('#buyer_id').val()) {
        select_address();
    } else {
        
       var uid =  $('#select_user').val() ;
         if(isNaN(uid)){
             $('#person_phone').html('Not a Valid number.');
             $('#select_user').attr('style','border-bottom: 1px solid red;');
              return false;
        }else{
           if(uid.length != 10){
                    $('#person_phone').html('Not a Valid number.');
                    $('#select_user').attr('style','border-bottom: 1px solid red;');
                    return false;
             }else{
                    $('#person_phone').html('');  
                    $('#select_user').attr('style','');
             }
        }
         jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/add-new-user',
             data: {_csrf: csrfToken,phone:uid}, 
             success: function (result) {
                 if(result.status == 1){
                    $('#buyer_id').val(result.user_id) ;
                    $('#select_user').val(result.mobile) ;
                    $('#is_new').val('1') ;
                      select_address();   
                    }else{
                        alert(result.errorMsg);
                    }
           }
             
         });
        
    }
});

$(document).on("click","#add_address_prev",function(){
             $('input[name=address_id]').val(''); 
             $('#select_user_div').show() ;
             $('#select_address').hide() ;
  });
  
$(document).on("click","#add_address_next",function(){ 
    
    var rates = document.getElementsByName('address_id');
        var rate_value;
        for(var i = 0; i < rates.length; i++){
            if(rates[i].checked){
                rate_value = rates[i].value;
            } } 
        if(rate_value){
          
           var userId =  $('#buyer_id').val();
             jQuery.ajax({ 
            type: 'post',
            url: url+'orders/select-address',
            data: {_csrf: csrfToken,addId: rate_value ,userId:userId},
            datatype: 'json',
            success: function (response) {
                if(response.status == 1){
                    $('#select_address').hide() ;
                    $('#select_meals').show() ;
                }

            },
            error: function(response){

             }
     });
              
        }else{
            alert('Please select a address / or add new address');
        }
    
  });
$(document).on("click","#show_add_data",function(){
    $('#select_meals').hide() ;
    $('#select_address').show() ;
    
  });
  
$(document).on("click","#pre_last",function(){
    var buyer_id =  $('#buyer_id').val() ;
      jQuery.ajax({ 
            type: 'post',
            url: url+'orders/remove-all-item',
            data: {_csrf: csrfToken,userid:buyer_id},
            datatype: 'json',
            success: function (response) {
                if(response.status == 1){
                      $('#select_meals').show() ;
                      $('#confirm_the_order').hide() ;
                   }
                       },
            error: function(response){

             }
     });
  
    
  });
function select_address(){
    var buyer_id =  $('#buyer_id').val() ;
        jQuery.ajax({ 
            type: 'post',
            url: url+'orders/getuseraddress',
            data: {_csrf: csrfToken,id: buyer_id },
            datatype: 'json',
            success: function (response) {
                if(response.status == 1){
                     $('#select_user_div').hide();
                     $('#all_addresses').html(response.data);
                     $('#select_address').show();
                }

            },
            error: function(response){

             }
     });
  }
  
  $(document).on("click","#add_address",function(){
      var buyer_id =  $('#buyer_id').val() ;
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/add-addr',
             data: {_csrf: csrfToken,user_id:buyer_id}, 
             success: function (response) {
                 $('#modal').modal('show');
                 $('#modaluser').html(response);

           }
             
         });
  });
   $(document).on("click","#update_address",function(){
      var add_id =  $(this).attr('val') ;
            var data =  $(this).attr('data') ;

     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/add-addr',
             data: {_csrf: csrfToken,add_id:add_id,data:data}, 
             success: function (response) {
                 $('#modal').modal('show');
                 $('#modaluser').html(response);

           }
             
         });
  });
     $(document).on("click","#delete_address",function(){
          var result = confirm("Are you sure you want to delete this address?");
      if (result) {
      var add_id =  $(this).attr('val') ;
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/delete-addr',
             data: {_csrf: csrfToken,add_id:add_id}, 
             success: function (response) {
            select_address();y
           }
             
         }); }
  });
 function Generateorder(){
     var userid = $("#buyer_id").val();
     var note =   $("#order-note").val();
     var agent_name =   $("#agent_name").val();
     var payoption =  $('input[name=payoption]:checked').val();
     var delcharge =  $('input[name=charge]:checked').val();
    
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/place-order',
             data: {_csrf: csrfToken,userID:userid,note:note,payment_option:payoption,delcharge:delcharge,agent_name:agent_name}, 
             success: function (response) {
               
           }
             
         });
 }
 function addCart(formid,next){
        var isChecked=false ;
        
        var items = document.getElementsByClassName('pro_class');
        var quant = document.getElementsByClassName('input-unit');
        if (next == 1 && items.length == 0) {
            isChecked=true ;
        }
        for (var i = 0; i < items.length; i++){
          if (items[i] && items[i].value) {
           isChecked=true ;
        }
        else {
           alert('please select Medicine');
           return false;
        }
        }
         for (var i = 0; i < quant.length; i++){
          if (quant[i] && quant[i].value) {
              if((quant[i].value)>0){
                  isChecked=true ;
              }else{
                   alert('Quantity must be more than 0');
           return false;
              }
           
        }
        else {
           alert('please select Quantity');
           return false;
        }
        }
       if(isChecked){ 
        var userid = $("#buyer_id").val();   
         var mobile = $("#select_user").val();   
        var form = $(formid)[0];
        var formdata = new FormData(form);
        formdata.append('Cart[user_id]', userid); 
      //  formdata.append('mobile', mobile); 
      $.ajax({
            url:url+'orders/add-to-cart',
            datatype: 'json',
            type:'POST',
            cache:'false',
            processData: false,
            contentType: false,
            data:formdata,
        beforeSend:function(){
           
        },
        success: function(data){
            if(data.status== 1){
             
              $('#select_meals').hide();
             
              $('#confirm_the_order').show();
              $('#all_data').html(data.view);
             
            }else{
             // alert('Medicine not saved');  
            }
        },
        error:function(){
                
        }
        })
     
     }
  }
function saveAddress(formid){ 
    
    var userid = $('#buyer_id').val();
    var name = $('#address-contact_person_name').val();
    var phone = $('#address-contact_person_phone').val();
    var add = $('#address-address').val();
    var locality = $('#geocomplete').val();
    var city = $('#address-city').val();
    var pincode = $('#address-pin_code').val();
    var dataval = $('#data').val();
     //alert(dataval);
    if(name == ''){
        $('.field-address-contact_person_name .help-block').html('Contact Person Name cannot be blank.');
        $('#name').attr('style','border-bottom: 1px solid red;');
        return false;
    }
    
    if(phone == ''){
        $('.field-address-contact_person_phone .help-block').html('Contact Person Phone cannot be blank.');
        $('#phonennumber').attr('style','border-bottom: 1px solid red;');
        return false;
    }else{
        if(isNaN(phone)){
             $('.field-address-contact_person_phone .help-block').html('Not a Valid number.');
             $('#phonennumber').attr('style','border-bottom: 1px solid red;');
              return false;
        }else{
           if(phone.length != 10){
                    $('.field-address-contact_person_phone .help-block').html('Not a Valid number.');
                    $('#phonennumber').attr('style','border-bottom: 1px solid red;');
                    return false;
             }else{
                    $('.field-address-contact_person_phone .help-block').html('');  
             }
        }
    }
    if(add == ''){
        $('.field-address-address .help-block').html('Contact Person address cannot be blank.');
        $('#address').attr('style','border-bottom: 1px solid red;');
        return false;
    }
    if(locality == ''){
                $('.field-geocomplete .help-block').html('Please enter a location');
               return false;
    }else{
            if(city == ''){
                    $('.field-address-city .help-block').html('Please enter a specific location');
                    return false;
             }
    }
   
   if(pincode == ''){
         $('.field-address-pin_code .help-block').html('Please enter a pincode');
        return false;
   }else{
        if(isNaN(pincode)){
             $('.field-address-pin_code .help-block').html('Please enter a valid pincode');
               return false;
        }else{
           if(pincode.length != 6){
                    $('.field-address-pin_code .help-block').html('Please enter a valid pincode');
                 return false;
             }
        }
       
         }
        var is_new = $('#is_new').val() ;
        var form = $(formid)[0];
        var formdata = new FormData(form);
        formdata.append('Address[user_id]', userid);
        if(is_new == 1){
         formdata.append('is_new', is_new);   
        }
  $.ajax({
            url:url+'orders/add-new-address',
            datatype: 'json',
            type:'POST',
            cache:'false',
            processData: false,
            contentType: false,
            data:formdata,
        beforeSend:function(){
           
        },
        success: function(data){
            if(data.status== 1){
              $('#modal').modal('hide');
              $(formid)[0].reset();
              select_address();
            if(dataval==1){  location.reload();}
            }else{
              alert('Address not saved');  
            }
        },
        error:function(){
                
        }
        })
   
}

function removeFromcart(id){
     var result = confirm("Are you sure you want to remove this item from cart?");
        if (result) {
    var userid = $('#buyer_id').val();
        jQuery.ajax({ 
            type: 'post',
            url: url+'orders/removeitem',
            data: {_csrf: csrfToken,pId: id ,userid:userid},
            datatype: 'json',
            success: function (response) {
                if(response.status == 1){
                     if(response.count==0){
                    $('#confirm_the_order').hide(); 
                    $('#select_meals').show(); 
                    
                     }else{
                    $('#all_data').html(response.view);
                    $('#all_data_draft').html(response.view);
                   }}

            },
            error: function(response){

             }
     });
  } }

function FieldValidation(){
   this.timeError = function (Id,session){
      var start = $('#stime'+Id).val();
      var end = $('#etime'+Id).val(); 
      var day = $('#'+Id).val();  
    if((start)&&(end)){  
     $.ajax({
     url:url+'clinic/valid-time',
     type:'POST',
     cache:false,
     data:{end_time:end,start_time:start,day:day,session:session},
     beforeSend:function(){
     },
     success:function(data){
        if (data.status == 'success') {
            $('#'+Id).prop('checked', true);
            $('#timing_day_lbl'+Id).attr({
                for: Id
            });
            $('#time-error'+Id).hide();
            $('#time-error'+Id).html('');
        } 
       else{
       $('#time-error'+Id).show();
       $('#time-error'+Id).html('this time you filled for '+data.clinic);
       $('#'+Id).prop('checked', false);
       return false;
        }
     },
     error:function(){
     }     
   })
   }
      
      },
    this.removeError = function (fieldId){
        $(fieldId).parent().removeClass('has-error');
        $(fieldId).next().next().text(''); 
    },
     this.removeselectError = function (fieldId,attribute){
      
           $(fieldId).parent().parent().removeClass('has-error');
           $(fieldId).parent().next().text('');
           
    }
}

var FValidation = new FieldValidation();

function Sendsms(){
     var userid = $("#buyer_id").val(); 
     var mobile = $("#select_user").val();
     var delcharge =  $("input[name='charge']:checked"). val();
  
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/send-link',
             data: {_csrf: csrfToken,mobile:mobile,userid:userid,delcharge:delcharge}, 
             success: function (response) {
             alert('Link Successfully Send')    
               
           }
             
         });
 }
 
 function Savedraft(){
     var userid = $("#buyer_id").val();
      var agent_name = $("#agent_name").val(); 
   var isDelChrg=$("input[name='charge']:checked").val();
   var pay_mode=$("input[name='payoption']:checked").val();
  // console.log(isDelChrg); 
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/save-draft',
             data: {_csrf: csrfToken,userid:userid,isDelChrg:isDelChrg,pay_mode:pay_mode,agent_name:agent_name}, 
              beforeSend:function(){                
                    $('#preloader').show();                   
                    },
             success: function (response) {
             alert('Order Successfully Saved')    
               
           }
             
         });
 }
 function Savetowarehouse(){
     var userid = $("#buyer_id").val(); 
      var agent_name = $("#agent_name").val(); 
     var isDelChrg=$("input[name='charge']:checked").val();
   var pay_mode=$("input[name='payoption']:checked").val();
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/ware-house',
             data: {_csrf: csrfToken,userid:userid,isDelChrg:isDelChrg,pay_mode:pay_mode,agent_name:agent_name}, 
             beforeSend:function(){    
               
                    $('#preloader').show();                   
                    },
             success: function (response) {
             alert('Order Successfully Saved')    
               
           }
             
         });
 }
 function SaveUpdatedDraft(){
     var userid = $("#buyer_id").val(); 
      var agent_name = $("#agent_name").val(); 
     var isDelChrg=$("input[name='charge']:checked").val();
   var pay_mode=$("input[name='payoption']:checked").val();
  
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/save-update-draft',
             data: {_csrf: csrfToken,userid:userid,isDelChrg:isDelChrg,pay_mode:pay_mode,agent_name:agent_name}, 

             success: function (response) {
                 $('#save-error').show();
            // alert('Order Successfully Saved')    
               
           }
             
         });
 }

      $(document).on("click",".updateMrp",function(){
       var package_price_id =  $(this).attr('productId') ;
         if(package_price_id !=''){
       var result = confirm("Are you sure you would like to update MRP of this medicine in your inventory? \r\n You have to re-add the same medicine in your order list to get the updated price.");
          if (result) {
       var expdat =   $(this).parents('[class*="col-"]').siblings('[class*="col-"]').find('.expiryDate').attr('id');
       var mrpdata =  $(this).closest('[class*="col-"]').find('.input-mrp').attr('id');
       var d_price =  $(this).parents('[class*="col-"]').siblings('[class*="col-"]').find('.discount-price').attr('id');
       var discount = $(this).parents('[class*="col-"]').siblings('[class*="col-"]').find('.input-discount').attr('id');
       var packg_id = $(this).parents('[class*="col-"]').siblings('[class*="col-"]').find('.input-packg').attr('id');
       var pckg_price = $(this).parents('[class*="col-"]').siblings('[class*="col-"]').find('.pro_class').attr('id');
     
        $("#"+mrpdata).val('');
        $("#"+discount).val('');
        $("#"+packg_id).val('');
        $("#"+d_price).val('');
        $("#"+expdat).val('');
      //  $("#"+pckg_price).selectpicker('refresh');  
      //  $("#"+pckg_price).selectpicker('val',''); 
        window.open (url+'packages/update-price?id='+package_price_id,'_blank');
      }}
  });
  
   function ShowDraft(user_id){ 
      $.ajax({
            url:url+'orders/show-draft',
            datatype: 'json',
            type: 'POST',
            data: {_csrf: csrfToken,user_id:user_id}, 
        beforeSend:function(){
           
        },
        success: function(data){
            if(data.status== 1){
              $('#buyer_id').val(user_id);
              $('#select_user_div').hide();
              $('#select_meals').show();
              $('#all_data_draft').html(data.view);
             
            }
        },
        error:function(){
                
        }
        })
     
  }
  function Delivery(del){ 
    var user_id = $('#buyer_id').val();
      var amt = $('#totval').html();
   //  alert(del); alert(amt>2500);
     if(amt>=2500 && del==1){
         alert('Delivery Charge is not Applicable on Order Above 2500');
         $('#dels').prop('checked', true);
         return false;
     }else{
      $.ajax({
            url:url+'orders/delcharge',
            datatype: 'json',
            type: 'POST',
            data: {_csrf: csrfToken,user_id:user_id,del:del}, 
        beforeSend:function(){
           
        },
        success: function(data){
        if(data.status== 1){
         
         $('#delval').html(data.amount_array.deliverychag);    
         $('#totval').html(data.amount_array.total_including_tax.toFixed(2));    
         }
        },
        error:function(){
                
        }
        })}
     
  }
   $(document).on("click","#show-user-list",function(){
       $('#select_user_div').show();
       $('#preview_draft_order').hide(); 
       
   });
   
     $(document).on("click","#show-draft-cart",function(){
       $('#select_meals').show() ;
       $('#preview_draft_order').hide(); 
   });
   
   $(document).on("click","#show_draft_user",function(){
    $('#select_meals').hide() ;
    $('#select_user_div').show() ;
    
  });
  
   function Removefromdraft(userid=''){
       if(userid==''){
         var userid = $("#buyer_id").val();    
       }
    
     
     jQuery.ajax({
             type: 'POST',
             datatype: 'json',
             url: url+'orders/remove-draft-order',
             data: {_csrf: csrfToken,userid:userid}, 
             success: function (response) {
             alert('Successfully Removed')    
               
           }
             
         });
 }
 
  $('body').on('keydown', '.numberonly', function (e) { 
  
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
 $('body').on('click', '#dispatch-delivered_status', function () {
     var deliver_sts=$("input[name='Dispatch[delivered_status]']:checked").val();
   
  //   alert(deliver_sts);
    if(deliver_sts == 4){
     $('#return-type').show();
      // $('#full-check').attr('checked', true);
    }else{
       
        // $('#return-type').hide();
          //$('#sub-order').hide();
          location.reload();
    }
 });
 $('body').on('click', '#return-type', function () {
     var return_type=$("input[name='return_type[name]']:checked").val();
    
    // alert(return_type);
    if(return_type == 2){
     $('#sub-order').show();
     
    }else{
         $('#sub-order').hide(); 
         
    }
 });
    $('body').on('click','.checklevel',function(){
       var type=$("input[name='range']:checked").val();
   if(type==2){  
      
       var level = $('#docname').val();
   }
   else{
        var level = $('#testbooks-name').val();
   }
   
       var video = $('#videourl').val();
       var id = $('#testbooks-subject_id').val();
      /// alert(level);alert(id);
     if(video=='' && type==2){
         
        $('#error-msg').text('Video url Cannot be blank'); 
        return false;
     }else{
           $('#error-msg').text(''); 
     }
       $.ajax({
        url : url + 'test-books/quiz-level',
        type : "post",
        data: {level:level,id:id},
        success : function(data) {
             //   alert(data);
              if(data==1 && type==4){ $('#errors').show();
            return false;  
            } else if(data==1 && type==2){
                  $('#errors').show();
            return false;  
            
            }else if(data==1){
                  $('#errors').show();
            return false;  
            
            } else{
                  $('#errors').hide();
//                  $('#quiz').yiiActiveForm('submitForm');
//                   $('#quiz').unbind('submit');  
    $('form#quiz').submit();
              }
               
        },
        error: function(e){
        }
    });
  
   }); 
    $('body').on('change','#testbooks-name',function(){
      
      var level = $(this).val();
       var id = $('#testbooks-subject_id').val();
      // alert(level);
       $.ajax({
        url : url + 'test-books/quiz-level',
        type : "post",
        data: {level:$(this).val(),id:id},
        success : function(data) {
               // alert(data);
              if(data==1){ $('#errors').show();
            return false;  
            }else{
                  $('#errors').hide();
              }
               
        },
        error: function(e){
        }
    });
  
   }); 
   $('body').on('change','#docname',function(){
      
      var level = $(this).val();
       var id = $('#testbooks-subject_id').val();
      // alert(level);
       $.ajax({
        url : url + 'test-books/quiz-level',
        type : "post",
        data: {level:$(this).val(),id:id},
        success : function(data) {
              //  alert(data);
              if(data==1){ $('#errors').show();
            return false;  
            }else{
                  $('#errors').hide();
              }
               
        },
        error: function(e){
        }
    });
  
   }); 
      $('body').on('click','.updatechecklevel',function(){
       var type=$("input[name='range']:checked").val();

       var video = $('#videourl').val();
       var id = $('#testbooks-subject_id').val();
      // alert(video);
     if(video=='' && type==2){
         
        $('#error-msg').text('Video url Cannot be blank'); 
        return false;
     }else{
           $('#error-msg').text(''); 
     }
     $('form#quiz').submit();

   }); 

