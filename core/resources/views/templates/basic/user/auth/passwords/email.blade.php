@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')
    <div class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
    
                <div class="col-md-6">
                    <div class="password-area">
                        <form class="contact-form" action="{{ route('user.password.email') }}" method="post" onsubmit="return submitUserForm();">
                            @csrf
                            <div class="form-group">
                              <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="las la-envelope"></i></div>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="@lang('Email')">
                              </div>
                            </div><!-- form-group end -->
                            <div class="form-group text-center">
                              <button type="submit" class="cmn-btn rounded-0 w-100">@lang('Submit')</button>
                              <p class="mt-20"> <a href="{{ route('user.login') }}">@lang('Back to login')</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
