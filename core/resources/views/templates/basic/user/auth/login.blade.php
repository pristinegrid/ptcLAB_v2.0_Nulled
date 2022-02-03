@php
    $loginCaption = getContent('login.content',true);
@endphp
@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')
    <section class="pt-120 pb-120">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="login-area">
              <h2 class="title mb-3">{{ __($loginCaption->data_values->heading) }}</h2>
              <p>{{ __($loginCaption->data_values->subheading) }}</p>
              <form class="action-form mt-50 loginForm" action="{{ route('user.login') }}" method="post">
                @csrf
                <div class="form-group">
                  <label>@lang('Username')</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="las la-user"></i></div>
                    </div>
                    <input type="username" name="username" class="form-control" placeholder="@lang('Username')">
                  </div>
                </div><!-- form-group end -->
                <div class="form-group">
                  <label>@lang('Password')</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="las la-key"></i></div>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="@lang('Password')">
                  </div>
                </div><!-- form-group end -->
                <div class="form-group d-flex justify-content-center">
                  @php echo recaptcha() @endphp
                </div><!-- form-group end -->
                @include('partials.custom-captcha')
                <div class="form-group text-center">
                  <button type="submit" class="cmn-btn rounded-0 w-100">@lang('Login Now')</button>
                  <p class="mt-20">@lang('Forget your password?') <a href="{{ route('user.password.request') }}">@lang('Reset password')</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection


@push('script')
    <script>
      (function ($,document) {
            "use strict";
            $('.loginForm').on('submit',function(){
              var response = grecaptcha.getResponse();
              if(response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">Captcha field is required.</span>';
                return false;
              }
              return true;
            });

              function verifyCaptcha() {
                  document.getElementById('g-recaptcha-error').innerHTML = '';
              }
        })(jQuery,document);
    </script>
@endpush
