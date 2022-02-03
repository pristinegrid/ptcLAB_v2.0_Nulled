
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')

<section class="cmn-section">
    <div class="container">
        <div class="row cmn-text">
            <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-dollar-sign overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="fas fa-dollar-sign"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="bal">{{ showAmount($user->balance) }} {{ $general->cur_text }}</h2>
                <p>@lang('My Balance') <a href="{{ route('user.withdraw') }}" class="btn cmn-btn">@lang('Withdraw Now')<i class="fas fa-arrow-circle-right"></i></a></p>
              </div>
            </div><!-- widget-two end -->
          </div>
            <div class="col-md-6 mb-30">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
              <i class="fas fa-tags overlay-icon text--primary"></i>
              <div class="widget-two__icon b-radius--5 bg--primary">
                <i class="fas fa-tags"></i>
              </div>
              <div class="widget-two__content">
                <h2 class="">{{ __($user->plan ? $user->plan->name : 'No Plan') }}</h2>
                <p>@lang('My Plan') <a href="{{ route('user.plans') }}" class="btn cmn-btn">@lang('Upgrade Now')<i class="fas fa-arrow-circle-right"></i></a></p>
              </div>
            </div><!-- widget-two end -->
          </div>
            <div class="col-lg-8 col-md-12 mb-30">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">@lang('Click & Earn Report')</h5>
                <div id="apex-bar-chart"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 mb-30">
              <div class="row">
                  <div class="col-lg-12 col-md-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                      <div class="widget-three__icon b-radius--rounded bg--primary">
                        <i class="far fa-credit-card"></i>
                      </div>
                      <div class="widget-three__content">
                        <h2 class="">{{ $user->deposits->sum('amount') + 0 }} {{ $general->cur_text }}</h2>
                        <p>@lang('Total Deposit')</p>
                        <a href="{{ route('user.deposit.history') }}" class="btn cmn-btn mt-2">@lang('Deposit History ')<i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                </div>
                  <div class="col-lg-12 col-md-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                      <div class="widget-three__icon b-radius--rounded bg--primary">
                        <i class="far fa-credit-card"></i>
                      </div>
                      <div class="widget-three__content">
                        <h2 class="">{{ showAmount($user->withdrawals->where('status',1)->sum('amount')) }} {{ $general->cur_text }}</h2>
                        <p>@lang('Total Withdraw')</p>
                        <a href="{{ route('user.withdraw.history') }}" class="btn cmn-btn mt-2">@lang('Withdraw History ')<i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                </div>
              </div>
          </div>
          <a href="{{ route('user.ptc.clicks') }}" class="col-lg-6 col-md-12 mb-30">
              <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
              <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-mouse-pointer"></i></div>
              <div class="widget__content">
                <p class="text-uppercase text-muted mb-0">@lang('Total Clicks')</p>
                <h2 class="text--success font-weight-bold">{{ $user->clicks->count() }}</h2>
              </div>
              <div class="widget__arrow">
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
          </a>
          <a href="{{ route('user.ptc.index') }}" class="col-lg-6 col-md-12 mb-30">
              <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
              <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-calendar-alt"></i></div>
              <div class="widget__content">
                <p class="text-uppercase text-muted mb-0">@lang('Remain clicks for today')</p>
                <h2 class="text--success font-weight-bold">{{ $user->dpl - $user->clicks->where('vdt',Date('Y-m-d'))->count() }}</h2>
              </div>
              <div class="widget__arrow">
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
          </a>
          <a href="{{ route('user.ptc.clicks') }}" class="col-lg-6 col-md-12 mb-30">
              <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
              <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-mouse-pointer"></i></div>
              <div class="widget__content">
                <p class="text-uppercase text-muted mb-0">@lang("Today's Clicks")</p>
                <h2 class="text--success font-weight-bold">{{ $user->clicks->where('vdt',Date('Y-m-d'))->count() }}</h2>
              </div>
              <div class="widget__arrow">
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
          </a>
          <a href="javascript:void(0)" class="col-lg-6 col-md-12 mb-30">
              <div class="widget bb--3 border--success b-radius--10 bg--white p-4 box--shadow2">
              <div class="widget__icon b-radius--rounded bg--success"><i class="fas fa-stopwatch"></i></div>
              <div class="widget__content">
                <p class="text-uppercase text-muted mb-0">@lang('Next Reminder')</p>
                <h2 class="text--success font-weight-bold timer" id="counter"></h2>
              </div>
              <div class="widget__arrow">
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
          </a>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
(function ($) {
    "use strict";
    // apex-bar-chart js
    var options = {
      series: [{
      name: 'Clicks',
      data: [
        @foreach($chart['click'] as $key => $click)
            {{ $click }},
        @endforeach
      ]
    }, {
      name: 'Earn Amount',
      data: [
            @foreach($chart['amount'] as $key => $amount)
                {{ $amount }},
            @endforeach
      ]
    }],
      chart: {
      type: 'bar',
      height: 580,
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: [
      @foreach($chart['amount'] as $key => $amount)
                '{{ $key }}',
            @endforeach
    ],
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val
        }
      }
    }
    };
    var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
    chart.render();
        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms*1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML =days+"d: "+ hours + "h "+ minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
                }
                tms--;
            }, 1000);
        }
      createCountDown('counter', {{\Carbon\Carbon::tomorrow()->diffInSeconds()}});
})(jQuery);
</script>
@endpush