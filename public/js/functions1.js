 $(document).ready(function () {
 /*= Like =*/
	$(".likeButton").on('click',function(e){
	var element     = $(this);
	var id          = element.attr("data-id");
	var like        = element.attr('data-like');
	var like_active = element.attr('data-unlike');
	var data        = 'id=' + id;

	e.preventDefault();

	element.blur();

	element.find('i').addClass('icon-spinner2 fa-spin');

	if( element.hasClass( 'active' ) ) {
		   	  element.removeClass('active');
		   	  element.find('i').removeClass('fa fa-heart').addClass('fa fa-heart-o');
		   	  element.find('.textLike').html(like);

		} else {
			element.addClass('active');
		   	  element.find('i').removeClass('fa fa-heart-o').addClass('fa fa-heart');
		   	  element.find('.textLike').html(like_active);

		}

		 $.ajax({
		 	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
		   type: "POST",
		   url: URL_BASE+"/ajax/like",
		   data: data,
		   success: function( result ){

		   	if( result == '') {
			   	  window.location.reload();
			   	  element.removeClass('likeButton');
			   	  element.removeClass('active');
		   	} else {
		   		//element.parents('.actions').find('.like_count').html( result );
		   		element.find('i').removeClass('icon-spinner2 fa-spin');
		   		$('#countLikes').html(result);
		   	}
		 }//<-- RESULT
	   });//<--- AJAX


});//<----- CLICK


 /*= Add collection  =*/
	$("#addCollection").on('click',function(e){
	var element     = $(this);

	e.preventDefault();
	element.blur();

	element.attr({'disabled' : 'true'});

	$('.wrap-loader').hide();

		 $.ajax({
		 	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
		   type: "POST",
		   url: URL_BASE+"/collection/store",
		   dataType: 'json',
		   data: $("#addCollectionForm").serialize(),
		   success: function( result ){

		   	if( result.success == true ){
		   		$('.wrap-loader').hide();
		   		$( result.data ).hide().appendTo('.collectionsData').slideDown( 1 );


		   		$('.no-collections').remove();
		   		$("#titleCollection").val('');

		   		element.removeAttr('disabled');

		   		addImageCollection();

		   	} else {
		   		$('.wrap-loader').hide();

		   		var error = '';
	            for( $key in result.errors ){
	            	error += '<li><i class="glyphicon glyphicon-remove myicon-right"></i> ' + result.errors[$key] + '</li>';
	                //error += '<div class="btn-block"><strong>* ' + result.errors[$key] + '</strong></div>';
	            }

				$('#showErrors').html(error);
				$('#dangerAlert').fadeIn(500)

				element.removeAttr('disabled');


		   		//$('#collectionsData').html(result);
		   	}
		 }//<-- RESULT
	   });//<--- AJAX
});//<----- CLICK



// ====== FOLLOW HOVER BUTTONS SMALL ============
    $(document).on('mouseenter', '.btnFollowActive' ,function(){

	var following = $(this).attr('data-following');

	// Unfollow
	$(this).html( '<i class="glyphicon glyphicon-remove myicon-right"></i> ' + following);
	$(this).addClass('btn-danger').removeClass('btn-info');
	 })

	$(document).on('mouseleave', '.btnFollowActive' ,function() {
		var following = $(this).attr('data-following');
	 	$(this).html( '<i class="glyphicon glyphicon-ok myicon-right"></i> ' + following);
	 });

/*========= FOLLOW BUTTONS SMALL =============*/
	$(document).on('click',".btnFollow",function(){
	var element    = $(this);
	var id         = element.attr("data-id");
	var _follow    = element.attr("data-follow");
	var _following = element.attr("data-following");
	var info       = 'id=' + id;

	element.removeClass( 'btnFollow' );

	if( element.hasClass( 'btnFollowActive' ) ) {
		element.addClass( 'btnFollow' );
		   	element.removeClass( 'btnFollowActive' );
		   element.html( '<i class="glyphicon glyphicon-plus myicon-right"></i> ' + _follow );
		   element.blur();

		}
		else {

			element.addClass( 'btnFollow' );
		   	  element.removeClass( 'btnFollowActive' );
		   	    element.addClass( 'btnFollow' );
		   	   element.addClass( 'btnFollowActive' );
		   	  element.html( '<i class="glyphicon glyphicon-ok myicon-right"></i> ' + _following );
		   	  element.blur();
		}


		 $.ajax({
		 	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
		   type: "POST",
		   url: URL_BASE+"/ajax/follow",
		   dataType: 'json',
		   data: info,
		   success: function( result ){

		   	if( result.status == false ) {
		   		element.addClass( 'btnFollow' );
			   	  element.removeClass( 'btnFollowActive followBtn' );
			   	   element.html( '<i class="glyphicon glyphicon-plus myicon-right"></i> ' + _follow );
			   	  element.html( type );
			   	  window.location.reload();
			   	  element.blur();
		   	}
		 }//<-- RESULT
	   });//<--- AJAX
});//<----- CLICK


//<----*********** addImageCollection ************------>
function addImageCollection() {

	$(".addImageCollection").click(function(){
		var _element = $(this);
		var imageID  = _element.attr("data-image-id");
		var collectionID  = _element.attr("data-collection-id");

		$.ajax({
			headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
		   type: "GET",
		   url: URL_BASE+'/collection/'+collectionID+'/i/'+imageID,
		   dataType: 'json',
		   data: null,
		   success: function( response ) {
				 $('#collections').modal('hide');
		    $('.popout').addClass('alert-success').html(response.data).fadeIn(500).delay(5000).fadeOut();
		   }

	   });
	});
}//<----*********** Click addImageCollection ************------>

addImageCollection();


 $(document).on('click','.pagination a', function(){
	$('ul.pagination').html('<div class="col-md-12"><div class="spinner"></div></div>');
});

$('.hovercard').hover(

   function () {
	  $(this).find('.hover-content').fadeIn();
   },

   function () {
	  $(this).find('.hover-content').fadeOut();
   }
);

$('.btn-collection').hover(

   function () {
	  $(this).find('i').removeClass('fa fa-folder-open-o').addClass('fa fa-folder-open');
   },

   function () {
	  $(this).find('i').removeClass('fa fa-folder-open').addClass('fa fa-folder-open-o');
   }
);

$('.btnLike').hover(

   function () {
	if( $(this).hasClass( 'active' ) ) {
		  $(this).find('i').removeClass('fa fa-heart').addClass('fa fa-heart-o');

	} else {
		  $(this).find('i').removeClass('fa fa-heart-o').addClass('fa fa-heart');

	}
   },

   function () {
	  if( $(this).hasClass( 'active' ) ) {
		  $(this).find('i').removeClass('fa fa-heart-o').addClass('fa fa-heart');

	} else {
		  $(this).find('i').removeClass('fa fa-heart').addClass('fa fa-heart-o');

	}
   }
);
 


//Mouse Button press

$('.disableRightClick').click(function(event) {
event.preventDefault();
switch (event.which) {
case 1:
alert('See Download Button Below! ðŸ‘‡');
break;
case 2:
alert('See Download Button Below! ðŸ‘‡');
break;
case 3:
alert('See Download Button Below! ðŸ‘‡');
break;
default:
alert('See Download Button Below! ðŸ‘‡');
}
})
$('.disableRightClick').on('contextmenu', function(event){
event.preventDefault();

});









 });
 
 
