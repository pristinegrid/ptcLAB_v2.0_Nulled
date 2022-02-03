<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="shortcut icon" type="image/png"
          href="{{ asset(imagePath()['logoIcon']['path'] .'/favicon.png') }}"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <!-- bootstrap -->
        @php
            $activeTemplateTrue = activeTemplate(true);
        @endphp
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/bootstrap.min.css') }}">
        <script src="{{ asset($activeTemplateTrue.'/js/vendor/jquery-3.5.1.min.js') }}"></script>
        <title>{{ $general->sitename(__($page_title) ?? '') }}</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' /> 
<script>
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') {
            document.body.innerHTML = `
                       <div class="d-flex flex-wrap justify-content-center align-items-center clear-msg">
                            <h3 class="text-danger text-center">@lang('Sorry you can\'t go anywhere from this tab while viewing an ad')</h3>
                        </div>
                    `;
        }
    });
</script>
        <style>
            #myProgress {
                width: 100%;
                background-color: #ddd;
            }
            #myBar {
                width: 10%;
                height: 30px;
                background-color: #00bcd4;
                text-align: center;
                line-height: 30px;
                color: white;
            }
            #confirm{
                color:white;
                font-weight: 600;
            }
            .inputcaptcha{
                width:60px;
            }
            .btn{
                margin-top: -4px;
            }
            @media (max-width: 767px) {
                ul.nav.navbar-nav.navbar-right {
                    margin-top: 15px;
                }
                .container{
                    display: flex !important;
                    justify-content: center !important;
                }
            }
            @media (max-width: 320px) {
                .row{
                    display: flex;
                    justify-content: center;
                }
                .btn{
                    margin-top: 5px;

                }
            }
            .adFram{
                border: 0; 
                position:absolute; top: 14%; 
                left:0; 
                right:0; 
                bottom:0; 
                width:100%; 
                height:100%
            }
            .adBody{
                position:absolute;
                top:30%;
                left:40%;
            }
            @media (max-width: 400px) {
                .advertise-wrapper iframe{
                    margin-top: 43px;
                }
            }

            .iframe-container{
                position: absolute;
                width: 60%;
                padding-bottom: 56.25%;
                display: flex;
                justify-content: center;
            }
            .iframe-container iframe{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-dark bg-primary p-4">
            <div class="container">
                <div class="col-md-4">
                    <div id="myProgress">
                        <div id="myBar">0%</div>
                    </div>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active row">
                        <span id="inputcaptchahidden" class="d-none">
                        <input  name="num1" id="cap_number_1" class="inputcaptcha"  value="{{ rand(0,9) }}" type="text" readonly>
                        <label for="exampleInputEmail2 text-white"> + </label>
                        <input  name="num2" id="cap_number_2" class="inputcaptcha" value="{{ rand(0,9) }}" type="text"   readonly>
                        <label for="exampleInputEmail2 text-white">=</label>
                        <input name="result" type="number" class="inputcaptcha" id="cap_result" required>&nbsp;
                        </span>
                        <a type="button" id="confirm" class="btn btn-danger btn-md" disabled>
                            @lang('Loading Ads')
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <script>
            (function ($,document) {
                "use strict";
                $('#cap_result').on('input',function(){
                     var val1 = document.getElementById("cap_number_1").value;
                     var val2 = document.getElementById("cap_number_2").value;
                     var val3 = document.getElementById("cap_result").value;
                     var sum = parseInt(+val1 + +val2);
                     if(sum==val3){
                        var confirmButton = document.getElementById("confirm");
                        confirmButton.removeAttribute('disabled');
                        confirmButton.className = "btn btn-success";
                        confirmButton.setAttribute('href', '{{route('user.ptc.confirm',Crypt::encryptString($ptc->id.'|'.auth()->user()->id))}}');
                     }else{
                         var confirmButton = document.getElementById("confirm");
                         confirmButton.setAttribute('disabled','');
                         confirmButton.className = "btn btn-danger";
                         confirmButton.removeAttribute('href', '#');
                     }
                });
            function move() {
            var elem = document.getElementById("myBar");
                var width = 0;
                var id = setInterval(frame, {{$ptc->duration * 10}});
                function frame() {
                if (width >= 100) {
                var confirmButton = document.getElementById("confirm");
                        confirmButton.className = "btn btn-danger";
                        confirmButton.innerHTML = "Confirm Earn";
                var captchaInputHidden =  document.getElementById("inputcaptchahidden");
                        captchaInputHidden.classList.remove("d-none");
                        clearInterval(id);
                } else {
                width++;
                        elem.style.width = width + '%';
                        elem.innerHTML = width + '%';
                }
                }
            }
            window.onload = move;    
            })(jQuery,document);
        </script>
            
        <div class="advertise-wrapper">
            @if($ptc->ads_type==1)
                <iframe src="{{ $ptc->ads_body }}" class="adFram"></iframe>
            @elseif($ptc->ads_type==2)
            <div class="container mt-5">
            <img  src="{{ asset('assets/images/ptcimages/'.$ptc->ads_body) }}" class="w-100">
            </div>
            @elseif($ptc->ads_type==2)
            <div class="adBody">
            @php echo $ptc->ads_body @endphp
            </div>
            @else
            <div class="d-flex justify-content-center">
                <div class="iframe-container">
                    <iframe src="{{ $ptc->ads_body }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            @endif
        </div>
    <script src="{{asset($activeTemplateTrue .'/js/bootstrap.bundle.min.js')}}"></script>
    </body>

</html>