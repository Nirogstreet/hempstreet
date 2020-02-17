var csrfToken = jQuery('meta[name="csrf-token"]').attr("content");
var url = jQuery('meta[name="url"]').attr("content");
var nurl = jQuery('meta[name="nurl"]').attr("content");
function hidepost(postid){
    //alert(postid);
    $.ajax({
     url:url+'/?r=query/approve-query',
     type:'POST',
     cache:false,
     data: {_csrf: csrfToken, postid: postid},
     beforeSend:function(){
         $('#hidepost'+postid).text('Wait...');
     },
     success:function(value){
         $('#hidepost'+postid).text(value.message);
     },
     error:function(){
     }     
   })
}
function ignorepost(postid){
    //alert(postid);
    $.ajax({
     url:url+'/?r=query/ignore-query',
     type:'POST',
     cache:false,
     data: {_csrf: csrfToken, postid: postid},
   
     success:function(value){
       $('#ignorepost'+postid).hide(); 
    
     },
     error:function(){
     }     
   })
}
function deleteDoc(docid){
    //alert(postid);
    $.ajax({
     url:url+'/?r=post/delete-document',
     type:'POST',
     cache:false,
     data: {_csrf: csrfToken, docid: docid},
     beforeSend:function(){
         $('#deletedoc'+docid).text('Wait...');
     },
     success:function(value){
         $('#deletedoc'+docid).text(value.message);
     },
     error:function(){
     }     
   })
}
function FieldValidationNew(){
    this.signupField =function(fieldId,attribute){ 
        if(!$(fieldId).val()){ 
           $(fieldId).parent().addClass('has-error');
           $(fieldId).next().text('Please enter '+attribute);
           return true;
       }else{
           $(fieldId).parent().removeClass('has-error');
           $(fieldId).next().text('');
           return false;
       }       
    },
     this.signupNewField =function(fieldId,attribute){ 
        if(!$(fieldId).val()){ 
           $(fieldId).parent().parent().addClass('has-error');
           $(fieldId).next().next().text('Please enter '+attribute);
           return true;
       }else{
           $(fieldId).parent().removeClass('has-error');
           $(fieldId).next().text('');
           return false;
       }       
    },
     this.removeNewError = function (fieldId){
        $(fieldId).parent().parent().removeClass('has-error');
        $(fieldId).next().next().text(''); 
    }       
   this.removeError = function (fieldId){
        $(fieldId).parent().removeClass('has-error');
        $(fieldId).next().text(''); 
    }
   
}

var FValidationNew = new FieldValidationNew();

$(document).ready(function(){
      $('form#package-form').on('beforeSubmit', function () {
         var rate = $('#checkrate').val(); 
           
         if((rate > 100)){
      
          $('#checkrate').next().html('Invalid discount-rate');
          $('#checkrate').next().css('color','red');
          $('#checkrate').next().show(); 
               return false ; 
         }              
    });
//   $('.educationData').click(function(event){ 
//     $('.educationData').prop('disabled',true);
//   });
       
  });
  
     $(document).ready(function(){
         
        $('.check_tick').on('click',function(){
            if(!$("#"+$(this).attr('for')).is(':checked')) { 
            $('#2'+$(this).attr('data-index')).addClass('anchor-session');
            $(this).parent().next().children().find(".ui-timepicker-input").removeAttr("readonly");            
            $(this).parent().next().next().next().children().find(".ui-timepicker-input").removeAttr("readonly");
            $(this).parent().next().children().find(".ui-timepicker-input").addClass('active-field-timing-new');
            $(this).parent().next().next().next().children().find(".ui-timepicker-input").addClass('active-field-timing-new');
            $(this).parents('.appointment-timing').addClass('selected-box');
             var svalue =  $('#stime'+$(this).attr('val-data')).val();
             var evalue =  $('#etime'+$(this).attr('val-data')).val();
             var snvalue =  $('#stime2'+$(this).attr('val-data')).val();
             var envalue =  $('#etime2'+$(this).attr('val-data')).val();
            
            $('#stime'+$(this).attr('for')).val(svalue);
            $('#etime'+$(this).attr('for')).val(evalue);
            $('#stime2'+$(this).attr('for')).val(snvalue);
            $('#etime2'+$(this).attr('for')).val(envalue);
       }else{
           
            $('#stime'+$(this).attr('for')).val('');
            $('#etime'+$(this).attr('for')).val('');
            $('#stime2'+$(this).attr('for')).val('');
            $('#etime2'+$(this).attr('for')).val('');
            $('#2'+$(this).attr('data-index')).removeClass('anchor-session');
            $(this).parent().next().children().find(".ui-timepicker-input").attr("readonly",true);          
            $(this).parent().next().next().next().children().find(".ui-timepicker-input").attr("readonly",true);
            $(this).parent().next().children().find(".ui-timepicker-input").removeClass('active-field-timing-new');
            $(this).parent().next().next().next().children().find(".ui-timepicker-input").removeClass('active-field-timing-new');
            $(this).parents('.appointment-timing').removeClass('selected-box');
       }
        });
    });
    $(document).ready(function(){
        $('#crouseDetail').on('click', function () {
        var error = 0;
        var i = $(this).attr('index');
        var k = $(this).attr('key');
        var n = $(this).attr('ndata');
      
      if(FValidationNew.signupField('#knowledgecenter-name','course name')){ error++; }
      if(FValidationNew.signupField('#knowledgecenter-description','course detail')){ error++; }
      if(FValidationNew.signupField('#knowledgecenter-author_ids','instructor name')){ error++; }
      if(FValidationNew.signupField('#knowledgecenter-banner','course image')){ error++; }
      if(FValidationNew.signupField('#modName'+i,'module name')){ error++; }
      if(FValidationNew.signupField('#modDes'+i,'module detail')){ error++; }
      if(FValidationNew.signupField('#topicName'+i+k,'topic name')){ error++; }
      if(FValidationNew.signupField('#filesName'+i+k+n,'file name')){ error++; }
      if(FValidationNew.signupField('#pdfData'+i+k+n,'file')&& FValidationNew.signupField('#vidData'+i+k+n,'file')&& FValidationNew.signupNewField('#htmData'+i+k+n,'file')){ error++; }
   
      if(error === 0){ 
          $('#submit_data').trigger('click');
      }
    
      else { 
          return false ;}   
                    
    });
     $('#submit_data').on('click', function () {
     $('#loading_image').show(); 
     $('#course-form').yiiActiveForm('submitForm');
     $('#course-form').unbind('submit'); 
        });
  
    $('#knowledgecenter-name').click(function(){
      FValidationNew.removeError('#knowledgecenter-name');
     })    
     $('#knowledgecenter-description').click(function(){
      FValidationNew.removeError('#knowledgecenter-description');
     }) 
       $('#knowledgecenter-author_ids').click(function(){
      FValidationNew.removeError('#knowledgecenter-author_ids');
     }) 
       $('.addtopic').click(function(){
      FValidationNew.removeError('.addtopic');
     }) 
  });
function googleMap(atLat,atLong,postId){
                initialize();
                map_zoom = 15;                    
                var map_options = {
                   center: new google.maps.LatLng(atLat, atLong),
                   zoom: map_zoom,
                   panControl: true,
                   zoomControl: true,
                   mapTypeControl: true,
                   streetViewControl: true,
                   mapTypeId: google.maps.MapTypeId.TERRAIN,
                   scrollwheel: false,      
                } ; 
                var map = new google.maps.Map(document.getElementById('feed-pointer'+postId), map_options);	
                var marker = new google.maps.Marker({
                   position: new google.maps.LatLng(atLat, atLong),
                   map: map,
                   visible: true,
                   icon: '/images/map-marker.png',
                });   
}
function CreateProfile(){
     this.timeError = function (Id,session,dId){
      var start = $('#stime'+Id).val();
      var end = $('#etime'+Id).val(); 
      var day = $('#'+Id).val();  
      
     $.ajax({
     url:url+'user/valid-time',
     type:'POST',
     cache:false,
     data:{end_time:end,start_time:start,day:day,session:session,dId:dId},
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
      },
              
    this.Addmore = function(urldata,indx,type,kdata,nkey){
        
        $.ajax({
            url:url+ urldata,
            datatype: 'json',
            type:'POST',
            data:{index:indx,key:kdata,newkey:nkey},
        beforeSend:function(){
        },
        success: function(data){
            if(data.status=='success'){
               $(".add-education").show();
               if(type==1){
               $(".addData").append(data.view);
           } else if(type==2){
               $(".addTopicData").append(data.view); 
               $('.addModule').attr('kdata',data.key);
               $('#crouseDetail').attr('key',data.key);
           } else{
               $(".addFileData").append(data.view); 
               $('.addModule').attr('kdata',data.key);
               $('.addModule').attr('ndata',data.ndata);
               $('#crouseDetail').attr('ndata',data.ndata);
           }
               $('.addModule').attr('idata',data.index);
               $('#crouseDetail').attr('index',data.index);
               
            }
             // $('#htmData'+data.index+data.key+data.ndata).redactor('refresh');
        
            
        },
        error:function(){
                
        }
        })
    } 
}
var Profile = new CreateProfile();
 $('body').on('click','.addModule',function(){
         var indx = $(this).attr('idata');
         var urldata = $(this).attr('urldata');
         var type = $(this).attr('type');
         var kdata = $(this).attr('kdata');
         var nkey = $(this).attr('ndata');
         var error = 0;
         Profile.Addmore(urldata,indx,type,kdata,nkey);  
      
          });
   $('body').on('click','.NewaddFile',function(){
        
        var key = $(this).attr('key');
       var old = $(this).attr('oldData');
         jQuery.ajax({
             type: 'post',
             datatype: 'json',
             url: url+'knowledge-center/more-file-new',
             data: {_csrf: csrfToken,key:key,old:old}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
             success: function (response) {
           
               //  $('#modal'+key).modal('show');
                 $('#fileid'+key).hide();
                 $('#modalcontent'+key).html(response.view);
               
           }
             
         }); 
      
          });        
        
       $('body').on('click','.addfileDetails',function(){
        
        var key = $(this).attr('key');
        var ndata = $(this).attr('ndata');
         jQuery.ajax({
             type: 'post',
             datatype: 'json',
             url: url+'knowledge-center/more-file-new-repeat',
             data: {_csrf: csrfToken,key:key,ndata:ndata}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
             success: function (response) {
           
                 $('.addfileDetails').attr('ndata',response.ndata)
                 $('.more-filesDeatils').append(response.view);
           }
             
         }); 
      
          }); 
      $('body').on('click','.NewaddTopic',function(){ 
         var key = $(this).attr('key');
      
         jQuery.ajax({
             type: 'post',
             datatype: 'json',
             url: url+'knowledge-center/more-topic-new',
             data: {_csrf: csrfToken,key:key}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
             success: function (response) {
           
                 $('.fileNewwData').append(response.view);
                 $('.NewaddTopic').attr('key',response.key);
           }
             
         });
         
      
          });
   $('body').on('click','.cross-more-div',function(){
       var id = $(this).attr('id');
       var newdata = $(this).attr('newdata');
       var type = $(this).attr('type');
       var indx = +newdata - 1;
       
      $('.neww'+id).remove();
           
          if(indx==0){
              if(type == 1){
           $('.addModule').attr('idata','1'); 
           $('#crouseDetail').attr('index','1');
       } else if(type == 2){
           $('.addModule').attr('kdata','1'); 
           $('#crouseDetail').attr('key','1');
       } else if (type == 3){
           $('.addModule').attr('ndata','1'); 
           $('#crouseDetail').attr('ndata','1');
          }}
         else{
            if(type == 1){
           $('.addModule').attr('idata',indx); 
           $('#crouseDetail').attr('index',indx);
       } else if(type == 2){
           $('.addModule').attr('kdata',indx); 
           $('#crouseDetail').attr('key',indx);
       }else if (type == 3){
           $('.addModule').attr('ndata',indx);   
           $('#crouseDetail').attr('ndata',indx);
         }}
     });   
     
     $('body').on('click','.cross-more-div-new',function(){
       var id = $(this).attr('id');
       var newdata = $(this).attr('newdata');
       
       var indx = +newdata - 1;
       
      $('.neww'+newdata).remove();
           
          if(indx==0){
            
           $('.addfileDetails').attr('key','1'); 
           $('.addfileDetails').attr('ndata','1');
       }
         else{
           
           $('.addfileDetails').attr('key',indx); 
           $('.addfileDetails').attr('ndata',indx);
       }
     });   
       $("#clinicprofile-clinic_name" ).autocomplete({
        
        source: url + 'user/auto-all',
        select: function (e, ui) {

                $(this).val(ui.item.value);
                  SubmitSearch(ui.item.value) ;
              
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
//    $("#packages-name" ).autocomplete({
//        
//        source: url + 'packages/find-all',
//        select: function (e, ui) {
//               // $(this).val(ui.item.value);
//        window.open(ui.item.value,'_blank');
//            
//           //  window.location.href = ui.item.value;    
//              
//    },
//    })._renderItem = function(ul, item) {
//        if(item.value != ''){
//        return $('<li>')
//        .append('<a>'+item.value+'</a>')
//        .appendTo(ul);
//        }else{
//            return $('<li>')
//            .append('<a>No results found</a>')
//            .appendTo(ul);
//        }
//    }; 
//    
    
 function SubmitSearch(valu){ 
    
            $.ajax({
            url: url + 'user/find-clinic',
            data: {_csrf: csrfToken,valu: valu},
            type: 'post',
            dataType: 'json',

         success: function (response) {
             if(response.status == 'success'){
              $('#clinic_id').val(response.modelData.id); 
              $('#clinicprofile-address').val(response.modelData.address);
              $('#geocomplete').val(response.modelData.locality);
              $('#clinicprofile-city').val(response.modelData.city);
              $('#clinicprofile-pincode').val(response.modelData.pincode);
              $('.tagit-new').prepend(response.view);
              $('.findData').attr('readonly', 'true');
              $('.findData').addClass('not-editable');
             }
              $('body #singleFieldTags2').addClass('filled');
              $('.material-input input').each(function(){
               if($(this).val()){
              $(this).addClass('filled'); 
        } 
    });
           },
           error: function (e) {

           }

          });  
     
  }   
     $("#knowledgecenter-author_ids" ).autocomplete({
        
        source: url + 'knowledge-center/auto-all',
        select: function (e, ui) {

         $('#instructor_id').val(ui.item.dataa);
               
              
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
   $('ul#singleFieldTags2 input[type="hidden"]').attr("name", "Services[name][]");
   
 function updateservice(id,sid){
        var service = $('.dctrsrvc'+sid).val();
          $.ajax({
                    type:'POST',
                    datatype:'JSON',
                    url:url+'user/add-services',
                    data: { _csrf: csrfToken, service:service,id:id,sid:sid},
                    beforeSend:function(e){
                     $('.btn .btn-orange').text('wait..');
                    },
                    success:function(response){
                    if(response.status=='success'){
                   
                    $('.textEditer').show();
                    $('.new'+sid).hide();
                    $('.old'+sid).show();
                    $('#ser'+sid).html(response.value);
                    $('.dctrsrvc'+sid).val(response.value);
                   }
                    },
                    error:function(e){

                    }
                });
    
  
};
$(function () {
    $('.stepExample1').timepicker({'step': 30,
    'minTime': '6:00am',
    'maxTime': '2:00pm',
  
    });
    $('.stepExample2').timepicker({'step': 30,
    'minTime': '7:00am',
    'maxTime': '3:00pm',
    });
     $('.stepExample3').timepicker({'step': 30,
    'minTime': '3:00pm',
    'maxTime': '11:00pm',
    });
     $('.stepExample4').timepicker({'step': 30,
    'minTime': '4:00pm',
    'maxTime': '12:00am',
    });
});
 $('.stepExample1').on('changeTime', function() { 
    var time = $(this).val();
    var getTime = time.split(":"); 
    var hours = parseInt(getTime[0])+1; 
    var newTime = hours+":"+getTime[1];
            $('.stepExample2').timepicker('option', 'minTime', newTime);
        });
 $('.stepExample3').on('changeTime', function() { 
        var time = $(this).val();
        var getTime = time.split(":"); 
        var hours = parseInt(getTime[0])+1; 
        var newTime = hours+":"+getTime[1];
            $('.stepExample4').timepicker('option', 'minTime', newTime);
        });  
 function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}  
    $('body').on('click','#timeData',function(){     
        var isChecked=false ;
        var isdata=false;
        var items = document.getElementsByClassName('timing_day');
        for (var i = 0; i < items.length; i++){
        if(items[i].checked)
        isChecked=true ;
            }

       
 if(isChecked) {
        $('#timeModal').hide(); 
       
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
      
         
    }
    
      else{
        alert('Please fill the detail');
        }
        var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        var timming='';
        var totaldays=0;
        $('.divTableRow.appointment-timing').each(function(){            
            if($("#"+$(this).attr('data-rowid')).is(':checked') && $("#2"+$(this).attr('data-rowid')).is(':checked')) {
                timming=timming+' '+days[$(this).attr('data-rowid')]+': '+$('#stime'+$(this).attr('data-rowid')).val()+' - '+$('#etime'+$(this).attr('data-rowid')).val();
                timming=' '+timming+','+$('#stime2'+$(this).attr('data-rowid')).val()+' - '+$('#etime2'+$(this).attr('data-rowid')).val();
                totaldays++;
            }else if($("#"+$(this).attr('data-rowid')).is(':checked')) {
                timming=timming+' '+days[$(this).attr('data-rowid')]+': '+$('#stime'+$(this).attr('data-rowid')).val()+' - '+$('#etime'+$(this).attr('data-rowid')).val();
                totaldays++;
            }else if($("#2"+$(this).attr('data-rowid')).is(':checked')) {
                timming=timming+' '+days[$(this).attr('data-rowid')]+': '+$('#stime2'+$(this).attr('data-rowid')).val()+' - '+$('#etime2'+$(this).attr('data-rowid')).val();
                totaldays++;
            }
            if(totaldays>=3){
                timming=timming+'...';
                return false;
            }
        });
       
        $('#clinic-timing').val(timming);
        if(timming!=''){
           $('#clinic-timing').addClass('filled');
        }
    });
     
     $('#tedx').click(function(){ 
           $( "#upload" ).trigger( "click" );
         
     
       });
        
       $('#upload').on('change', function () { 
          $pp = $('#profile-pic').croppie({
                        enableExif: true,
                        mouseWheelZoom:false,
                        viewport: {
                            width: 250,
                            height: 250,
                            type: 'square'
                        },
                        boundary: {
                            width: 500,
                            height: 300
                        }
                 });
           $('.create-crop-modal').fadeIn(500);
           
               var reader = new FileReader();
              reader.onload = function (e) {
                
                         $pp.croppie('bind', {
                           url: e.target.result
                   }).then(function(){
                           $('#userprofile-pic').addClass('no-bgimg');
                   });

           }
           reader.readAsDataURL(this.files[0]);
       });
    
       $('.upload-result.sbt-albm').on('click', function (ev) {
                $pp.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) { 
               $('#tedx').val(resp);
               $('.create-crop-modal').fadeOut(500); 

            }); 
        });
        
       $('.cncl-profileimages').click(function(){
                 $('.create-crop-modal').fadeOut(300);
        setTimeout(function() {
             $('body').css('paddingRight','0').removeClass('modal-open');
          }, 300);
           $('#profile-pic .cr-image').attr('src', '');
//           $('#profile-pic .cr-boundary').remove();
//           $('#profile-pic .cr-slider-wrap').remove();
         });