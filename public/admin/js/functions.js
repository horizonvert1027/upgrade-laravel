$("#addSub").click(function(e){
	
	e.preventDefault();
	
	var saveHtml    = $('#addSub').html();
	$('#addSub').attr({'disabled' : 'true'}).html('<i class="fa fa-cog fa-spin fa-1x fa-fw fa-loader"></i>');

/* beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },*/
       
    $.ajax({
        url: URL_BASE + "/panel/admin/subcategories/add",
        type:"POST",
        data: $('#addSubForm').serialize(),
        success:function(data){
            window.location.reload();
        },error:function(data){
           var errors =data.responseJSON;

		     var errorsHtml = '';
		
		    $.each(errors['errors'], function(index, value) {
		        errorsHtml += '<li><i class="glyphicon glyphicon-remove myicon-right"></i> ' + value + '</li>';
		        });
		   
					$('#errorsAlert').html(errorsHtml);
					$('#boxErrors').fadeIn();
					$('#addSub').removeAttr('disabled').html(saveHtml);
		        }
    }); //end of ajax
});