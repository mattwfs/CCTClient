$(function(){

        var location_count = 1;

        $(".modal").on("hide.bs.modal",function(e){
                $(this).find("form").trigger("reset");
                $(this).find("form").find(".form-response").html("");
        });
        
        $('.modal-ajax-form').on('submit',function(e){
                var form = $(this);
                var btn =form.find('[type="submit"]');
                btn.hide();
                var response_div = form.find(".form-response");
                if(response_div.length == 0){
                        form.prepend('<div class="form-response"></div>');
                }
                var response_div = form.find(".form-response");
                response_div.html('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Processing request</div>');
                var url = form.attr("action");
                var form_data = form.serialize();
                var html ='';
                
                $.post(
                        url,
                        form_data,
                        function(data){
                                var res = $.parseJSON(data);
                                if( res.response_type == 'success'){
                                     html +='<div class="alert alert-success">';
                                     html += '<p>'+res.message+'</p>';
                                     html +='</div>';
                                     form.trigger("reset");
                                }
                                else if(res.response_type=='error'){
                                html +='<div class="alert alert-danger">'; 
                                html += '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                                     $.each(res.message,function(index,item){
                                             html += '<p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> '+item+'</p>';
                                     });
                                     html +='</div>'; 
                                }
                                else{
                                        html +='<div class="alert alert-warning">';  
                                             html += '<p>Unexpected Error!! Account creating failed.</p>';
                                        html +='</div>';
                                        
                                }
                                
                                response_div.html(html);
                                btn.show();
                                if(res.redirect){
                                        window.location.href=res.redirect;
                                }
                        }
                );
                e.preventDefault();
        });
        
        
        $(".select2-field").select2();
        $(".form").validate();
        $('.date_picker').datepicker();
        
        
        
        
        //live search on table
        $('[data-filter="table"]').on('keyup',function(){
                var target_element = $(this).attr("data-target");
                var searchTerm = $(this).val().toLowerCase();
                $(target_element+' tbody tr').each(function(){
                    var lineStr = $(this).text().toLowerCase();
                    if(lineStr.indexOf(searchTerm) === -1){
                        $(this).hide();
                    }else{
                        $(this).show();
                    }
                });
        });
        
       
        
        /*$('#application_status_change').on("change",function(){
                //$(this).attr("readonly",true);
                var url = $(this).attr("data-link");
                var selected_text = $(this).find(":selected").text();
                var selected_value = $(this).find(":selected").val();
                $.post(
                        url,
                        {
                        'application_id':$(this).attr("data-update-id"),
                        'status':selected_value,
                        '_token':$(this).attr("data-token")
                        },
                        function(data){
                           toastr.success("Status updated to "+selected_text);     
                        }
                );
                
        });*/
        
        
        $(".delete-admin-confirmation").on("click",function(e){
                e.preventDefault();
                
        });
        
        $("#admin_confirmation_btn").on("click",function(e){
                
                e.preventDefault();
                var button = $(this);
                var form = button.parents("form");
                var form_response = form.find('.form_response');
                var redirect_url = form.find('[name="redirect"]').val();
                var initialBtnText = button.text();
                var  form_url = form.attr("action");
                
                button.addClass("disabled");
                button.attr("disabled",true);
                button.text('Wait...');
                
                $.post(
                        form_url,
                        form.serialize(),
                        function(data){
                                if(data=='success'){
                                       window.location.replace(redirect_url);
                                }else{
                                  form.find('.form-response').html(data);      
                                }
                                
                                button.removeClass("disabled");
                                button.attr("disabled",false);
                                button.text(initialBtnText);
                        }
                );
                
        });
        
        
        $("#admin_confirmation").on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var form = $(this).find("form");
                var url = button.attr("data-url");
                var delete_id = button.attr("data-id");
                
                form.attr("action",url);
                form.find('[name="delete_id"]').val(delete_id);
        });
        
        $("#admin_confirmation").on('hide.bs.modal', function (event) {
                var modal = $(this);
                var form = $(this).find("form");
                form.attr("action",'');
                form.find('[name="delete_id"]').val('');
        });

        $("#add_location").on("click", function(event){
                location_count++;
                event.preventDefault();
                $(".primary_location").show();
                $("#last_location").after('<tr class="location_'+location_count+'"><th colspan="2">Location #'+location_count+'</th></tr><tr class="location_'+location_count+'"><th>Location #'+location_count+' Street address</th><td><input type="text" name="street_address_'+location_count+'" class="form-control" required/></td></tr><tr class="location_'+location_count+'"><th>Location #'+location_count+' City</th><td><input type="text" name="city_'+location_count+'" class="form-control" required/></td></tr><tr class="location_'+location_count+'"><th>Location #'+location_count+' State</th><select class="form-control select2-field select2-hidden-accessible" name="state" required="" tabindex="-1" aria-hidden="true" aria-required="true"><option value="AK">Alaska</option><option value="AL">Alabama</option><option value="AR">Arkansas</option><option value="AS">American Samoa</option><option value="AZ">Arizona</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DC">District of Columbia</option><option value="DE">Delaware</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="GU">Guam</option><option value="HI">Hawaii</option><option value="IA">Iowa</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="MA">Massachusetts</option><option value="MD">Maryland</option><option value="ME">Maine</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MO">Missouri</option><option value="MS">Mississippi</option><option value="MT">Montana</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="NE">Nebraska</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NV" selected="">Nevada</option><option value="NY">New York</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="PR">Puerto Rico</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VA">Virginia</option><option value="VI">Virgin Islands</option><option value="VT">Vermont</option><option value="WA">Washington</option><option value="WI">Wisconsin</option><option value="WV">West Virginia</option><option value="WY">Wyoming</option></select></td></tr><tr class="location_'+location_count+'"><th>Location #'+location_count+' Postal code</th><td><input type="text" name="postcode" class="form-control" required/></td></tr><tr class="location_'+location_count+'"><th>Location #'+location_count+' Phone</th><td><input type="text" name="phone" class="form-control" required/></td></tr><tr class="location_'+location_count+'" id="last_location"><th>Location #'+location_count+' Fax</th><td><input type="text" name="fax" class="form-control" required/></td></tr>');
                $("#last_location").first().attr("id","");
        });

        $("#remove_location").on("click", function(event){
                event.preventDefault();
        });


});

$(window).scroll(function(){
		if($(window).scrollTop()>$("#main-header").height()){
	       $("#main-header").addClass("fixed");
			}
		else{
		//$(".main-header").css({'position':'static'});
		$("#main-header").removeClass("fixed");
			}
	
});