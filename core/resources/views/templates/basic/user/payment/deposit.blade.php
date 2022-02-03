
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif
            </div>


            @foreach($gatewayCurrency as $data)
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body b-primary">
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <img src="{{$data->methodImage()}}" class="card-img-top w-100" alt="{{$data->name}}">
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <ul class="list-group text-center">


                                        <li class="list-group-item">
                                            {{__($data->name)}}</li>

                                        <li class="list-group-item">@lang('Limit')
                                            : {{showAmount($data->min_amount)}}
                                            - {{showAmount($data->max_amount)}} {{$general->cur_text}}</li>

                                        <li class="list-group-item"> @lang('Charge')
                                            - {{showAmount($data->fixed_charge)}} {{$general->cur_text}}
                                            + {{showAmount($data->percent_charge)}}%
                                        </li>

                                        <li class="list-group-item">
                                            <button type="button"  data-id="{{$data->id}}" data-resource="{{$data}}"
                                            data-base_symbol="{{$data->baseSymbol()}}"
                                            class=" btn deposit cmn-btn w-100" data-toggle="modal" data-target="#exampleModal">
                                        @lang('Deposit')</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</section>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel"></strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="currency" class="edit-currency" value="">
                            <input type="hidden" name="method_code" class="edit-method-code" value="">
                        </div>
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text currency-addon addon-bg">{{$general->cur_text}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop



@push('script')
    <script>
        (function ($,document) {
            "use strict";
            $(document).ready(function(){

                $('.deposit').on('click', function () {
                    var id = $(this).data('id');
                    var result = $(this).data('resource');
                    var baseSymbol = "{{$general->cur_text}}";
                    // var baseSymbol = $(this).data('base_symbol');

                    $('.method-name').text(`@lang('Payment By ') ${result.name}`);
                    // $('.currency-addon').text(`${result.currency}`);
                    $('.currency-addon').text(baseSymbol);


                    $('.edit-currency').val(result.currency);
                    $('.edit-method-code').val(result.method_code);

                });
            });
        })(jQuery,document);
    </script>
@endpush
