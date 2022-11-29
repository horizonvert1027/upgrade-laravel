        $(document).ready(function () {
// JS for Popping up Modal Box on Download Button
// JS for Popping up Modal Box on Download Button

// Get the modal
            var modal = document.getElementById('myModal');

// Get the button that opens the modal
            var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
            btn.onclick = function () {
                modal.style.display = "block";
                window.dispatchEvent(new Event('resize'));
            }

// When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

// When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }


// Copy button for Description
            $("#cpy").click(function () {
                var range = document.createRange();
                range.selectNode(document.getElementById('description'));
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand("copy");
                window.getSelection().removeAllRanges();
                alert("Copied to clipboard");
            })
// Copy button for Description
// Copy button for Description


// JS for Flex Images (Similar Images)
// JS for Flex Images (Similar Images)
            $('#imagesFlex').flexImages({rowHeight: 220});
            $('#imagesFlex1').flexImages({rowHeight: 220});
// JS for Flex Images (Similar Images)

// JS Reporting an image
            $('#btnFormPP').click(function (e) {
                $('#form_pp').submit();
            });
            $('input').iCheck({
                radioClass: 'iradio_flat-green',
                checkboxClass: 'icheckbox_square-green',
            });
            @if (session('noty_error'))
            swal({
                title: "{{ trans('misc.error_oops') }}",
                text: "{{ trans('misc.already_sent_report') }}",
                type: "error",
                confirmButtonText: "{{ trans('users.ok') }}"
            });
            @endif
            @if (session('noty_success'))
            swal({
                title: "{{ trans('misc.thanks') }}",
                text: "{{ trans('misc.send_success') }}",
                type: "success",
                confirmButtonText: "{{ trans('users.ok') }}"
            });
            @endif
            @if( Auth::check() )
            $("#reportPhoto").click(function (e) {
                var element = $(this);
                e.preventDefault();
                element.attr({'disabled': 'true'});
                $('#formReport').submit();
            });
// JS Reporting an image

// JS Comments Delete
            $(document).on('click', '.deleteComment', function () {
                var $id = $(this).data('id');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                swal(
                    {
                        title: "{{trans('misc.delete_confirm')}}",
                        type: "warning",
                        showLoaderOnConfirm: true,
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans('misc.yes_confirm')}}",
                        cancelButtonText: "{{trans('misc.cancel_confirm')}}",
                        closeOnConfirm: false,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            element = $(this);
                            element.removeClass('deleteComment');
                            $.post("{{url('comment/delete')}}",
                                {comment_id: $id},
                                function (data) {
                                    if (data.success == true) {
                                        window.location.reload();
                                    } else {
                                        //bootbox.alert(data.error);
                                        //window.location.reload();
                                    }
                                }, 'json');
                        }
                    });
            });
// JS Comments Delete

// JS for Likes Comments
            $(document).on('click', '.likeComment', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                element = $(this);
                element.html('<i class="fa fa-spinner fa-spin"></i>');
                $.post("{{url('comment/like')}}",
                    {
                        comment_id: $(this).data('id')
                    }, function (data) {
                        if (data.success == true) {
                            if (data.type == 'like') {
                                element.html('<i class="fa fa-heart myicon-right"></i>');
                                element.parent('.btn-block').find('.count').html(data.count).fadeIn();
                                element.parent('.btn-block').find('.like-small').fadeIn();
                                element.blur();

                            } else if (data.type == 'unlike') {
                                element.html('<i class="fa fa-heart-o myicon-right"></i>');

                                if (data.count == 0) {
                                    element.parent('.btn-block').find('.count').html(data.count).fadeOut();
                                    element.parent('.btn-block').find('.like-small').fadeOut();
                                } else {
                                    element.parent('.btn-block').find('.count').html(data.count).fadeIn();
                                    element.parent('.btn-block').find('.like-small').fadeIn();
                                }
                                element.blur();
                            }
                        } else {
                            bootbox.alert(data.error);
                            window.location.reload();
                        }
                        if (data.session_null) {
                            window.location.reload();
                        }
                    }, 'json');
            });
            @endif
            // JS for Likes Comments

// JS for Comments Likes
            $(document).on('click', '.comments-likes', function () {
                element = $(this);
                var id = element.attr("data-id");
                var info = 'comment_id=' + id;
                element.removeClass('comments-likes');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ url('comments/likes') }}",
                    data: info,
                    success: function (data) {
                        $('#collapse' + id).html(data);
                        $('[data-toggle="tooltip"]').tooltip();
                        if (data == '') {
                            $('#collapse' + id).html("{{trans('misc.error')}}");
                        }
                    }//<-- $data
                });
            });
// JS for Comments Likes

// JS Delete Photo
            @if( Auth::check() && Auth::user()->id == $response->user()->id )
            $("#deletePhoto").click(function (e) {
                e.preventDefault();
                var element = $(this);
                var url = element.attr('data-url');
                element.blur();
                swal(
                    {
                        title: "{{trans('misc.delete_confirm')}}",
                        type: "warning",
                        showLoaderOnConfirm: true,
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans('misc.yes_confirm')}}",
                        cancelButtonText: "{{trans('misc.cancel_confirm')}}",
                        closeOnConfirm: false,
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = url;
                        }
                    });
            });
            @endif
            // JS Delete Photo

//<<---- JS PAGINATION AJAX
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url("/") }}/ajax/comments?photo={{$response->id}}&page=' + page


                }).done(function (data) {
                    if (data) {

                        scrollElement('#gridComments');

                        $('.gridComments').html(data);

                        jQuery(".timeAgo").timeago();

                        $('[data-toggle="tooltip"]').tooltip();
                    } else {
                        sweetAlert("{{trans('misc.error_oops')}}", "{{trans('misc.error')}}", "error");
                    }
                    //<**** - Tooltip
                });

            });
//<<---- JS PAGINATION AJAX
//<<---- JS PAGINATION AJAX

// JS for count down
// JS for count down

        });
        /*
        jQuery(document).ready(function() {
        var sec = 10
        var timer = setInterval(function() {
           $("#mdtimer span").text(sec--);
           if (sec == 0) {
        $("#makingdifferenttimer").delay(1000).fadeIn(1000);
        $("#mdtimer").hide(1000) .fadeOut(fast);}
        },500);
        });
        
        */
        // JS for count down
        // JS for count down
