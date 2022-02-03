<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <title>{{ $general->sitename(@$page_title??$pageTitle) }}</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">

            <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="shortcut icon" type="image/png" href="{{ asset(imagePath()['logoIcon']['path'] .'/favicon.png') }}"/>
        <!-- bootstrap 4  -->
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/bootstrap.min.css') }}">
      <!-- fontawesome 5  -->
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/all.min.css') }}">
      <!-- line-awesome webfont -->
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/line-awesome.min.css') }}">
      <!-- image and videos view on page plugin -->
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/lightcase.css') }}">
      
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/animate.min.css') }}">
      <!-- custom select css -->
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/nice-select.css') }}">
      <!-- slick slider css -->
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/vendor/slick.css') }}">
      <!-- dashdoard main css -->
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/main.css') }}">
      <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset(asset($activeTemplateTrue)."/css/color.php?color1=$general->base_color&color2=$general->secondary_color") }}">

    @include('partials.seo')
    @stack('style-lib')
    @stack('style')


</head>
<body>
@php echo fbcomment() @endphp
  <div class="preloader">
    <div class="dl">
      <div class="dl__container">
        <div class="dl__corner--top"></div>
        <div class="dl__corner--bottom"></div>
      </div>
      <div class="dl__square"></div>
    </div>
  </div>
  
  <!-- scroll-to-top start -->
  <div class="scroll-to-top">
    <span class="scroll-icon">
      <i class="fa fa-rocket" aria-hidden="true"></i>
    </span>
  </div>
  <!-- scroll-to-top end -->
  <div class="page-wrapper">
      <!-- header-section start  -->
  <header class="header">
    <div class="header__top">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <div class="left d-flex align-items-center">
              <div class="language">
                <i class="las la-globe-europe"></i>
                <select id="langSel" class="nic-select">
                  @php
                  $langs = App\Models\Language::all();
                  @endphp
                  @foreach($langs as $lang)
                  <option value="{{$lang->code}}" @if(Session::get('lang') === $lang->code) selected  @endif>{{ __($lang->name) }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="right text-sm-right text-center">
              @guest
              <a href="{{ route('user.login') }}"><i class="las la-sign-in-alt"></i> @lang('Login')</a>
              <a href="{{ route('user.register') }}"><i class="las la-user-plus"></i> @lang('Registration')</a>
              @else
              <a href="{{ route('user.home') }}"><i class="las la-user-plus"></i> @lang('Dashboard')</a>
              @endguest
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header__bottom">
      <div class="container">
        <nav class="navbar navbar-expand-xl p-0 align-items-center">
          <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="site-logo"><span class="logo-icon"><i class="flaticon-fire"></i></span></a>
          <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="menu-toggle"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav main-menu ml-auto">
              <li><a href="{{ route('home') }}">@lang('Home')</a></li>
              @foreach($pages as $page)
              @if($page->slug != 'home' && $page->slug != 'blog' && $page->slug != 'contact') 
              <li><a href="{{ route('home.pages',$page->slug) }}">{{ __($page->name) }}</a></li>
              @endif
              @endforeach
              <li><a href="{{ route('blog') }}">@lang('Blog')</a></li>
            </ul>
            <div class="nav-right">
              <a href="{{ route('contact') }}" class="cmn-btn style--three">@lang('Contact')</a>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>
  <!-- header-section end  -->
@yield('content')


@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp
@if(@$cookie->data_values->status && !session('cookie_accepted'))
<section class="cookie-policy bg-section">
    <div class="container">
        <div class="cookie-wrapper">
            <div class="cookie-cont">
                <span>
                    @php echo @$cookie->data_values->description @endphp
                </span>
                <a href="{{ @$cookie->data_values->link }}" class="text--base">@lang('Read more about cookies')</a>
            </div>
            <a href="javascript:void(0)" class="cmn-btn btn-sm cookie-close policy">@lang('Accept Policy')</a>
        </div>
    </div>
</section>
@endif


<!-- footer section start -->
<footer class="footer-section">
  <div class="footer-bottom">
    <div class="container">
      <hr>
      <div class="row">
        <div class="col-lg-8 col-md-6 text-md-left text-center">
          <p>{{ __(getContent('copyright.content',true)->data_values->copyright) }}</p>
        </div>
        <div class="col-lg-4 col-md-6 mt-md-0 mt-3">
          @php
            $links = getContent('footer_link.element');
          @endphp
          <ul class="link-list justify-content-md-end justify-content-center">
            @foreach($links as $link)
            <li><a href="{{ route('links',[$link->id,slug($link->data_values->title)]) }}">{{ __($link->data_values->title) }}</a></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- footer section end -->

  </div> <!-- page-wrapper end -->
    <!-- jQuery library -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/jquery-3.5.1.min.js') }}"></script>
  <!-- bootstrap js -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/bootstrap.bundle.min.js') }}"></script>
  <!-- lightcase plugin -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/lightcase.js') }}"></script>
  <!-- custom select js -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/jquery.nice-select.min.js') }}"></script>
  <!-- slick slider js -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/slick.min.js') }}"></script>
  <!-- scroll animation -->
  <script src="{{ asset($activeTemplateTrue.'/js/vendor/wow.min.js') }}"></script>
  <!-- dashboard custom js -->
  <script src="{{ asset($activeTemplateTrue.'/js/app.js')}}"></script>
  </body>

@stack('script-lib')


@include('admin.partials.notify')
@include('partials.plugins')
@stack('script')
<script type="text/javascript">
  (function($,document){
        "use strict";
        $(document).on('change', '#langSel', function () {
            var code = $(this).val();
            window.location.href = "{{url('/')}}/change-lang/"+code ;
        });

        $('.policy').on('click',function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get('{{route('cookie.accept')}}', function(response){
                iziToast.success({message: response, position: "topRight"});
                $('.cookie-policy').addClass('d-none');
            });
        });
            
    })(jQuery,document);
</script>
</body>
</html>
