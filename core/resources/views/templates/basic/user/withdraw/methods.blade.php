
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
        <div class="container ">
            <div class="row mb-60-80 justify-content-center">
                <div class="col-md-12 mb-30">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    @endif
                </div>

                @foreach($withdrawMethod as $data)

                    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="card card-deposit b-primary">
                        <div class="card-body card-body-deposit">
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image)}}" class="card-img-top w-100" alt="{{$data->name}}">
                                </div>
                                <div class="col-md-7 col-sm-12">
                                    <ul class="list-group text-center">
                                        <li class="list-group-item">
                                        {{__($data->name)}}</li>
                                        <li class="list-group-item">@lang('Limit')
                                            : {{showAmount($data->min_limit)}}
                                            - {{showAmount($data->max_limit)}} {{$general->cur_text}}</li>

                                        <li class="list-group-item"> @lang('Charge')
                                            - {{showAmount($data->fixed_charge)}} {{$general->cur_text}}
                                            + {{showAmount($data->percent_charge)}}%
                                        </li>

                                        <li class="list-group-item">
                                            <a href="javascript:void(0)"  data-id="{{$data->id}}"
                                               data-resource="{{$data}}"
                                               class="btn btn-block  cmn-btn deposit" data-toggle="modal" data-target="#exampleModal">
                                                @lang('Withdraw Now')</a>
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
    <!-- ========User-Panel-Section Ends Here ========-->



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel">@lang('Withdraw Amount')</strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <form action="{{route('user.withdraw.money')}}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="method_code" class="edit-method-code  form-control" value="">
                        </div>


                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg"
                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                       placeholder="0.00" required="" value="{{old('amount')}}">

                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text addon-bg">{{__($general->cur_text)}}</span>
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
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $('.deposit').on('click', function () {
                    var result = $(this).data('resource');

                    $('.method-name').text(`@lang('Withdraw Via ') ${result.name}`);


                    $('.edit-method-code').val(result.id);
                });
            });
        })(jQuery);
    </script>
@endpush
