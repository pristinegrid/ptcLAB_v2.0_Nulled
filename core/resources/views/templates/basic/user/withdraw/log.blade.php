
@extends($activeTemplate .'layouts.user')
@section('content')
@include($activeTemplate.'breadcrumb')
<section class="cmn-section">
   <div class="container">
       <div class="row">
           <div class="col-md-12">
            <div class="card table-card">
              <div class="card-body p-o">
                   <div class="table-responsive--sm">
                       <table class="table table-striped">
                           <thead class="thead-dark">
                           <tr>
                               <th scope="col">@lang('Transaction ID')</th>
                               <th scope="col">@lang('Gateway')</th>
                               <th scope="col">@lang('Amount')</th>
                               <th scope="col">@lang('Charge')</th>
                               <th scope="col">@lang('After Charge')</th>
                               <th scope="col">@lang('Rate')</th>
                               <th scope="col">@lang('Receivable')</th>
                               <th scope="col">@lang('Status')</th>
                               <th scope="col">@lang('Time')</th>
                           </tr>
                           </thead>
                           <tbody>
                    
                               @forelse($withdraws as $k=>$data)
                                   <tr>
                                       <td data-label="@lang('Transaction Id')">{{$data->trx}}</td>
                                       <td data-label="@lang('Gateway')">{{ $data->method->name   }}</td>
                                       <td data-label="@lang('Amount')">
                                           <strong>{{showAmount($data->amount)}} {{$general->cur_text}}</strong>
                                       </td>
                                       <td data-label="@lang('Charge')" class="text-danger">
                                           {{showAmount($data->charge)}} {{$general->cur_text}}
                                       </td>
                                       <td data-label="@lang('After Charge')">
                                           {{showAmount($data->after_charge)}} {{$general->cur_text}}
                                       </td>
                                       <td data-label="@lang('Rate')">
                                           {{$data->rate +0}}
                                       </td>
                                       <td data-label="@lang('Receivable')"  class="text-success">
                                           <strong>{{showAmount($data->final_amount)}} {{$data->currency}}</strong>
                                       </td>
                                       <td data-label="@lang('Status')">
                                           @if($data->status == 2)
                                               <span class="badge badge-warning">@lang('Pending')</span>
                                           @elseif($data->status == 1)
                                               <span class="badge badge-success">@lang('Completed')</span>
                                               <button class="btn btn-sm btn-info infoBtn" data-info="{{ $data->admin_feedback }}">@lang('information')</button>
                                           @elseif($data->status == 3)
                                               <span class="badge badge-danger">@lang('Rejected')</span>
                                               <button class="btn btn-sm btn-info infoBtn" data-info="{{ $data->admin_feedback }}">@lang('information')</button>
                                           @endif

                                       </td>
                                       <td data-label="@lang('Time')">
                                           <i class="fa fa-calendar"></i> {{date('d M, Y ', strtotime($data->created_at))}}
                                           <span class="pl-1"></span> {{date('h:i A', strtotime($data->created_at))}}
                                       </td>
                                   </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">@lang('Data not found')</td>
                            </tr>
                            @endforelse
                           </tbody>
                       </table>
                   </div>
                
              </div>
            </div>

               {{$withdraws->links($activeTemplate.'paginate')}}
           </div>
       </div>
   </div>
</section>


<!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title method-name" id="exampleModalLabel">@lang('Information Modal')</strong>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                  <p></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script type="text/javascript">
  (function ($) {
     "use strict";
      $('.infoBtn').click(function(){
        var modal = $('#infoModal');
        modal.find('p').html($(this).data('info'));
        modal.modal('show');
      });
  })(jQuery);
</script>
@endpush
