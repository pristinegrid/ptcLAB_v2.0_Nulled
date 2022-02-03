
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row mb-60-80">
            <div class="col-md-12 mb-30">
                <div class="card table-card">
                    <div class="card-body p-0">
                        
                        <div class="table-responsive--sm">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">@lang('Transaction ID')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Remaining Balance')</th>
                                    <th scope="col">@lang('Details')</th>
                                    <th scope="col">@lang('Date')</th>

                                </tr>
                                </thead>
                                <tbody>
                                @if(count($logs) >0)
                                    @foreach($logs as $k=>$data)
                                        <tr>
                                            <td data-label="@lang('Transaction Id')">{{$data->trx}}</td>
                                            <td data-label="@lang('Amount')">
                                                <strong @if($data->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($data->trx_type == '+') ? '+':'-'}} {{showAmount($data->amount)}} {{$general->cur_text}}</strong>
                                            </td>
                                            <td data-label="@lang('Remaining Balance')">
                                                <strong class="text-info">{{showAmount($data->post_balance)}} {{__($general->cur_text)}}</strong>
                                            </td>
                                            <td data-label="@lang('Details')">{{__($data->details)}}</td>
                                            <td data-label="@lang('Date')">{{date('d M, Y', strtotime($data->created_at))}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="100%" class="text-center"> @lang('No results found')!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{$logs->links($activeTemplate.'paginate')}}
            </div>
        </div>
    </div>
    </section>
@endsection
