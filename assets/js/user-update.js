$(function(){
        if($("body").find("#user-update").length==1){
                
                var update_div = $("body").find("#user-update");
               
                if(update_div.length == 1){
                        
                        var base_url = $("#baseurl").attr("content");
                        setInterval(function(){

                                $.ajax({
                                        type : 'get',
                                        url : base_url+'/user/get-updated',
                                        dataType: 'html',
                                        success:function(response){
                                          update_div.html(response);      
                                        }
                                });


                        },90000);
                }
        }
});





/*function ajax_update()
{
    
    $.ajax({
               type : this_form.attr("method"),
               url : this_form.attr( 'action' ),
               data : this_form.serialize(),
               dataType: 'html',
               success: function(response)
               {
                    container.html(response);
                    container.prepend('<h1 class="page-title">Filter result</h1>');
               },
               complete:function()
               {
                    loader.hide();
                    btn.show();
               }
          });
    
}*/