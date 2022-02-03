
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-bg">@lang('Payment Preview')</div>
                    <div class="card-body text-center">
                        <h4> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{$data->currency}}</h4>
                        <h6>@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h6>
                        <img src="{{$data->img}}" alt="">
                        <h4 class="text-dark bold">@lang('SCAN TO SEND')</h4>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection
