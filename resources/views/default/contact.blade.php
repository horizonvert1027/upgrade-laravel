@extends('layouts.multi')

@section('OwnCss')
<link rel="stylesheet" type="text/css" href="/public/jscss/form.css">
@endsection

{!! ReCaptcha::htmlScriptTagJsApi(['version' => 'invisible']) !!}

@section('content') 
    <div class="container">
           <section>
            <div class="col-md-12">
                <div class="formcenter">
                <div class="mt20 mb35 forms">
                    <div class="login-rgister">
                        <form method="post" id="contact_form" action="{{ url('contact') }}">
                            @csrf
                                <input type="text" name="status" value="contact" style="display: none;">

                                <h1 style="font-size:20px">Contact</h1>
                                 <h5 style="font-size: 16px;text-align: -webkit-center;margin: 0px 0px 6px 0px;">Drop Us a Message
                                 </h5>

                                        @if(session()->has('message'))
                                            <div class="success_message">
                                                <div role="alert">
                                                    <p>
                                                        <strong>Success! </strong>Your message has been sent successfully...
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($errors->any())
                                             <div class="alert alert-danger">
                                                  <ul class="list-unstyled">
                                                         @foreach ($errors->all() as $error)
                                                               <li>{{ $error }}</li>
                                                         @endforeach
                                                  </ul>
                                              </div>
                                         @endif
                                
                                    <input type="text" required="required" name="txtName" class="form-control login" placeholder="Your Name *" value="" />
                                
                                    <input type="text" required="required" name="txtEmail" class="form-control login" placeholder="Your Email *" value="" />
                                
                                    <input type="text" required="required" name="txtSubject" class="form-control login" placeholder="Subject *" value="" />
                                
                                    
                                    <select name="purpose" class="containerform">
                                        <option name="0" value="0">--Select Purpose-- *</option>
                                        <option name="txtads" value="advertisement">Advertisment</option>
                                        <option name="txthelp" value="wantToWork">Career</option>
                                        <option name="txtwork" value="Help">Help</option>
                                    </select>
                                
                                    <textarea name="txtMsg" required="required" class="form-control login" placeholder="Your Message *" style="width: 100%; height: 150px;">
                                    </textarea>

                              

                                   {!! ReCaptcha::htmlFormButton('Send Message',[
                                        'class' => 'btnContact formbtn',
                                        'name' => 'btnSubmit',
                                    ]) !!}
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
        </script>


@endsection
