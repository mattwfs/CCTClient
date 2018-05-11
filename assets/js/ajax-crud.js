$(function(){
  
  $(".ajax-crud-modal-form").on('submit',function(e){
    e.preventDefault();
    var form = $(this);
    var button = form.find('[type="submit"]');
    button.hide();
    var url = form.attr("action");
      var enctype = form.attr("enctype");
    var form_data = form.serialize();
    var form_response = form.find(".form-response");
    if(form_response.length == 0){
      form.prepend('<div class="form-response"></div>');
    }
    form_response.html('<div class="alert alert-info">Processing request..</div>');
    form.parents(".modal").css("opacity","0.8");
    
    $.post(url,form_data,function(data){
      data = $.parseJSON(data);
      if(data.response_type == 'success'){
        //form_response.html('<div class="alert alert-success">Success</div>');
        form.parents(".modal").trigger("hide.bs.modal");
        form.parents(".modal").modal('hide');
        toastr.success("Operation successfull");
        button.show();
        setTimeout(
          function(){
            location.reload(); 
          },
          300
        );
         
        
      }
      else if(data.response_type == 'error'){
        var err_html = '';
        err_html +='<div class="alert alert-danger">'; 
        err_html += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        $.each(data.message,function(index,item){
          err_html += '<p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '+item+'</p>';
        });
        err_html +='</div>';
        form_response.html(err_html);
        button.parent("div").append('<p class="text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Form error</p>');
        form.parents(".modal").css("opacity","1");
        button.show();
      }
      else{
        console.log(data);
      }
    });
  
  });
  
  
  $("#reminder-modal").on('hidden.bs.modal',function(){
       location.reload();
  });
  
  
  
  
  // delete from table
  $(".ajax-table-row-delete").on("click",function(e){
    var self = $(this);
    var url = self.attr("href");
    var row = self.parents("tr");
    confirm("This can not be undone, are you sure to delete")
    $.get(url,function(data){
      row.remove();
      toastr.success('Delete Successfull!')
    });
        
    e.preventDefault();
  });
  

  
  
// reset data on modal close  
$('.crud-modal').on('hidden.bs.modal',function(){
  var modal = $(this);
  var id_field = modal.find("#update-id");
  var form_response = modal.find("form").find(".form-response");
  var error_element = modal.find("form").find(".error");
  id_field.remove();
  form_response.html('');
  error_element.next("label").remove();
  error_element.removeClass("error");
  modal.find("form").trigger("reset");
  modal.find("option").removeAttr("selected");
  modal.find(".select2-selection__choice").remove();
      
});
  
  
  
  
  
  
  
  
}); // end of document ready