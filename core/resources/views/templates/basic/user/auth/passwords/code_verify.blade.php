
@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')
    <div class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
    
                <div class="col-md-6">
                    <div class="password-area">
                        <h6 class="text-center mb-3">@lang('Enter Verification Code')</h6>
                        <form class="contact-form" action="{{ route('user.password.verify-code') }}" method="post" onsubmit="return submitUserForm();">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="form-group">
                                <label>@lang('Verification Code')</label>
                                <input type="text" name="code" id="code" class="form-control">
                            </div>
                            <div class="form-group text-center">
                              <button type="submit" class="cmn-btn rounded-0 w-100">@lang('Submit')</button>
                              <p class="mt-20"> <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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