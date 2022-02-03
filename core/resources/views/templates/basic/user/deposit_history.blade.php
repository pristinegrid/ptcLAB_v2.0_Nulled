@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-30">
                <div class="card table-card">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">@lang('Transaction ID')</th>
                                    <th scope="col">@lang('Gateway')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Time')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($logs) >0)
                                    @foreach($logs as $k=>$data)
                                        <tr>
                                            <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                            <td data-label="@lang('Gateway')">{{ $data->gateway->name   }}</td>
                                            <td data-label="@lang('Amount')">
                                                <strong>{{showAmount($data->amount)}} {{$general->cur_text}}</strong>
                                            </td>
                                            <td data-label="status">
                                                @if($data->status == 1)
                                                    <span class="badge badge-success">@lang('Complete')</span>
                                                @elseif($data->status == 2)
                                                    <span class="badge badge-warning">@lang('Pending')</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge badge-danger">@lang('Cancel')</span>

                                                @endif

                                            </td>
                                            <td data-label="@lang('Time')">
                                                <i class="fa fa-calendar"></i> {{date(' d M, Y ', strtotime($data->created_at))}}
                                                <i class="fa fa-clock-o pl-1"></i> {{date('h:i A', strtotime($data->created_at))}}
                                            </td>
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
