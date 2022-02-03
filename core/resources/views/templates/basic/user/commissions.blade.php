
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
                                    <th>@lang('Commission From')</th>
                                    <th>@lang('Commission Level')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Transaction')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($commissions) >0)
                                    @forelse($commissions as $log)
                                    <tr>
                                        <td data-label="@lang('Commission From')">{{ __($log->userFrom->username) }}</td>
                                        <td data-label="@lang('Level')">{{ __($log->level) }}</td>
                                        <td data-label="@lang('Amount')">{{ showAmount($log->amount) }} {{ __($general->cur_text) }}</td>
                                        <td data-label="@lang('Title')">{{ __($log->title) }}</td>
                                        <td data-label="@lang('Transaction')">{{ $log->trx }}</td>
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
                {{$commissions->links($activeTemplate.'paginate')}}
            </div>
        </div>
    </div>
</section>
@endsection