$(document).ready(function(){
  
  $("#chat-attachment-trigger").on("click",function(e){
    $("#chat-attachment").trigger("click");
    e.preventDefault();
  });
  
  $("#chat-attachment").on("change",function(e){
    var uploaded_file_url;
    var file_attachment = $(this);
    var main_form = file_attachment.parents('form');
    var submit_url = $(this).attr("data-upload-url");
    
    var trigger_btn = $("#chat-attachment-trigger");
    var initialhtml = trigger_btn.html();
    
    trigger_btn.html('<i class="fa fa-spinner fa-spin"></i>');
    trigger_btn.addClass('disabled');
    
    
    $.ajax({
      url : submit_url,
      type: 'POST',
      processData: false,
      contentType: false,
      data: new FormData(main_form[0]),
      success: function(data){
           console.log(data);
            $('[name="message"]').val($('[name="message"]').val()+data);
    
            trigger_btn.html(initialhtml);
            trigger_btn.removeClass('disabled');
       }
    });
  });
});
 