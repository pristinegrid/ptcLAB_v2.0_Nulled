
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>@lang('Referral Link')</label>
                    <div class="input-group">
                        <input type="text" value="{{ route('user.refer.register',$user->username) }}"
                        class="form-control form-control-lg" id="referralURL"
                        readonly>
                        <div class="input-group-append copytextDiv">
                            <span class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-30">
                @if($user->plan)
                    <p class="text-center mb-2 font-weight-bold">@lang('Your Current Plan ')<span class="text-success">{{ __($user->plan->name) }}</span></p>
                    <p class="text-center mb-2 font-weight-bold">@lang('Referral Level Up To ')<span class="text-danger">{{ __($user->plan->ref_level) }} @lang('Level')</span></p>
                @else
                    <p class="text-center mb-2 font-weight-bold">@lang('You have no plan')</p>
                @endif
                @if($user->refBy)
                    <p class="text-center mb-2 font-weight-bold">@lang('My Referral ') <span class="text-primary">{{ __($user->refBy->username) }}</span></p>
                @endif
                <ul class="list-group">
                    @forelse($levels as $level)
                    <li class="list-group-item @if($user->plan && $user->plan->ref_level >= $level->level) bg-success-custom brd-success-custom @endif"><span class="float-left">@lang('#Level '){{ __($level->level) }}</span><strong class="float-right">{{ __($level->percent) }} %</strong></li>
                    @empty
                    <li class="list-group-item text-center">@lang('No level found')</li>
                    @endforelse
                </ul>
            </div>
            <div class="col-md-9 mb-30">
                <div class="card table-card">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>@lang('Full Name')</th>
                                    <th>@lang('User Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Plan')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($refUsers) >0)
                                    @forelse($refUsers as $log)
                                    <tr>
                                        <td data-label="@lang('Full Name')">{{ __($log->fullname) }}</td>
                                        <td data-label="@lang('User Name')">{{ __($log->username) }}</td>
                                        <td data-label="@lang('Email')">{{ $log->email }}</td>
                                        <td data-label="@lang('Phone')">{{ $log->mobile }}</td>
                                        <td data-label="@lang('Plan')">{{ __($log->plan ? $log->plan->name : "No Plan") }}</td>
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
                {{$refUsers->links($activeTemplate.'paginate')}}
            </div>
        </div>
    </div>
</section>
@endsection
@push('style')
<style type="text/css">
    .copytextDiv{
        border:1px solid #0000007a;
        cursor: pointer;
    }
    #referralURL{
        border-right: 1px solid #0000007a;
    }
    .bg-success-custom{
        background-color: #28a7456e!important;
    }
    .brd-success-custom{
        border: 1px dashed #28a745;   
    }
</style>
@endpush
@push('script')
<script type="text/javascript">
    (function ($) {
        "use strict";
        $('#copyBoard').click(function(){
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        });
    })(jQuery);
</script>
@endpush