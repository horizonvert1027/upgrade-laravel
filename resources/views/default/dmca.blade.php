@extends('layouts.multi')
@section('content')
{!! ReCaptcha::htmlScriptTagJsApi(['version' => 'invisible']) !!}
<link rel="stylesheet" type="text/css" href="/public/jscss/form.css">
<style>
    @media (min-width:  520px){
    input.form-control.login{
    min-width: 500px;
}
}
@media (min-width: 800px){
    .col-md-4 {
        width: 50%;
    }
    .col-md-8 {
        width: 50%;
    }
    .login-rgister {
        margin-top: 0%;
    }
    .login-rgister {
        border: none;
        padding: 30px;
    }

    .mt20.mb35.forms{
    padding: 1em;
    border-radius: 10px;
    margin: 20px 0;
    }
    .mt20.mb35.forms {
        padding: 1em;
    border-radius: 10px;
    margin: 5px 0px 0px;
    }
}
.ibox.mt20 {
    text-align: initial;
}

@media (max-width: 800px){
.mt20.mb35.forms {
    padding: inherit;
    border: none;
}}
</style>
<div class="container">
    <section>

        <div class="col-md-8">
            <div class="formcenter">
                <div class="ibox mt20">
                        <?php use App\Models\Pages;
                        $data = Pages::where('id','6')->get();
                        ?>
                        <?php echo html_entity_decode($data[0]->content) ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="formcenter">
                <div class="mt20 mb35 forms">
                    <div class="login-rgister">
                        @csrf

                        <form method="post" id="contact_form" action="{{ url('dmcago') }}">
                            @csrf
                            <input type="text" name="status" value="contact" style="display: none;">

                            <h1>DMCA Infringement</h1>
                            <br> @if(session()->has('message'))
                            <div style="width: 50%;margin-top: 20px;">
                                <div class="success aligncenter" role="alert">
                                    <p><strong>Success!</strong> Your Message Has Been Sent Successfully...</p>
                                </div>
                            </div>
                            @endif @if(session()->has('error'))
                            <div style="width: 50%;margin-top: 20px;">
                                <div class="danger aligncenter" role="alert">
                                    <p><strong>Error!</strong> Please check the required fields and try again...</p>
                                </div>
                            </div>
                            @endif

                            <div class="dmcainput">
                                <h2>File you own</h2>
                                <label>URL of the file to be removed</label>
                                <input type="url" required="required" name="link" class="form-control login" placeholder="Link of the file *" value="" />
                            </div>


                            <div class="dmcainput">
                                <h2>Identification</h2>
                                <label>Proof of your ownership</label>
                                <input type="text" required="required" name="txtSubject" class="form-control login" placeholder="Link to your ownership *" value="" />
                            </div>

                            <div class="dmcainput">
                                <h2>Details</h2>
                                <label>Reason</label>
                                <textarea name="txtMsg" required="required" class="form-control login" placeholder="Details*" value="" style="width: 100%; height: 150px;"></textarea>
                            </div>


                            <h2>Contact Information</h2>
                            <div class="dmcainputu">
                                <label>Name</label>
                                <input type="text" required="required" name="txtName" class="form-control login" placeholder="Name *" value="" />
                            </div>

                            <div class="dmcainputu">
                                <label>Email</label>
                                <input type="text" required="required" name="txtEmail" class="form-control login" placeholder="Email *" value="" />
                            </div>

                            <div class="dmcainputu">
                                <label>Contact Number</label>
                                <input type="tel" required="required" name="number" class="form-control login" placeholder="Number with Country Code *" value="" />
                            </div>

                            <div class="dmcainputu">
                                <label>Address</label>
                                <input type="text" required="required" name="address" class="form-control login" placeholder="Address *" value="" />
                            </div>



                            <div class="checkd" onclick="selectRow(this)">
                                <input type="checkbox" name="checkbox" value="check" class="checkbox" />
                                <p class="check" style="max-width:500px">
                                    I agree and state under penalty of perjury that I am the owner, or on behalf of the owner, of the content under the copyright that is allegedly infringed and if false accusations is found for the above, a prosecution shall be initiated.</p>
                            </div>



                            {!! ReCaptcha::htmlFormButton('Send Message',[ 'class' => 'btnContact formbtn', 'name' => 'btnSubmit', ]) !!}
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </section>
</div>

@endsection



@section('javascript')
<script src="{{ asset('public/plugins/jquery.counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('public/plugins/jquery.counterup/waypoints.min.js') }}"></script>
<script src="{{ asset('public/js/lazyload.min.js') }}"></script>

<script type="text/javascript">

    var captcha_a = Math.ceil( Math.random() * 8 );
    var captcha_b = Math.ceil( Math.random() * 8 );
    var captcha_c = Math.ceil( Math.random() * 8 );
    var itr = Math.random() * 8;
    var captcha_e = 0;
    var captcha_text = "";
    if( itr > 6 )
    {
        captcha_e = ( captcha_a + captcha_b ) - captcha_c;
        captcha_text = captcha_a + " + " + captcha_b + " - " + captcha_c + " = ";
    }
    else if( itr > 3 )
    {
        captcha_e = ( captcha_a - captcha_b ) + captcha_c;
        captcha_text = captcha_a + " - " + captcha_b + " + " + captcha_c + " = ";
    }
    else
    {
        captcha_e = ( captcha_a + captcha_b ) + captcha_c;
        captcha_text = captcha_a + " + " + captcha_b + " + " + captcha_c + " = ";
    }

    function generate_captcha( id ) 
    {
        var id = ( id ) ? id : 'lcaptcha';
        $("#" + id ).html( captcha_text).attr({'placeholder' : captcha_text });
    }

    generate_captcha('lcaptcha');

    $('.btnContact').click(function(e)
    {
        e.preventDefault();
        var captcha        = $("#lcaptcha").val();
        if( captcha != captcha_e ){
            var error = true;
            $("#errorCaptcha").fadeIn(500);
            $('#lcaptcha').focus();
            return false;
         } else {
           $('#contact_form').submit();
        }
    });

        function downloadJSAtOnload() {
        var element = document.createElement("script");
        element.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js";
        document.body.appendChild(element);
        }
        if (window.addEventListener)
        window.addEventListener("load", downloadJSAtOnload, false);
        else if (window.attachEvent)
        window.attachEvent("onload", downloadJSAtOnload);
        else window.onload = downloadJSAtOnload;
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", yall);
     $('#imagesFlex').flexImages({ rowHeight: 240, maxRows: 8, truncate: true });
        
    </script>
        <script type="text/javascript">
            $(document).ready(function (){
            $('.counter').counterUp({
            delay: 10, // the delay time in ms
            time: 1000 // the speed time in ms
            });
         @if (session('success_verify'))
            swal({
                title: "{{ trans('misc.welcome') }}",
                text: "{{ trans('users.account_validated') }}",
                type: "success",
                confirmButtonText: "{{ trans('users.ok') }}"
                });
         @endif

         @if (session('error_verify'))
            swal({
                title: "{{ trans('misc.error_oops') }}",
                text: "{{ trans('users.code_not_valid') }}",
                type: "error",
                confirmButtonText: "{{ trans('users.ok') }}"
                });
         @endif

// JS for Automatic Popup
  window.onload = function (){
    $(".bts-popup").delay(2000).addClass('is-visible');
    }
  
    //open popup
    $('.bts-popup-trigger').on('click', function(event){
        event.preventDefault();
        $('.bts-popup').addClass('is-visible');
    });
    
    //close popup
    $('.bts-popup').on('click', function(event){
        if( $(event.target).is('.bts-popup-close') || $(event.target).is('.bts-popup') ) {
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
            $('.bts-popup').removeClass('is-visible');
        }
    });

});

        </script>
@endsection
