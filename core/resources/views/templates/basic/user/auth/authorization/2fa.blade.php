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
              <h2 class="title mb-3">@lang('2FA Verification')</h2>
              <form class="action-form mt-50 loginForm" action="{{route('user.go2fa.verify')}}" method="post">
                @csrf
                <div class="form-group">
                  <label>@lang('Verification Code')</label>
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="las la-code"></i></div>
                    </div>
                    <input type="text" name="code" id="code" class="form-control" placeholder="@lang('Verification Code')">
                  </div>
                </div>
                <div class="form-group text-center">
                  <button type="submit" class="cmn-btn rounded-0 w-100">@lang('Submit')</button>
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
    (function($){
        "use strict";
        $('#code').on('input change', function () {
          var xx = document.getElementById('code').value;
          
              $(this).val(function (index, value) {
                 value = value.substr(0,7);
                  return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
              });
          
      });
    })(jQuery)
</script>
@endpush