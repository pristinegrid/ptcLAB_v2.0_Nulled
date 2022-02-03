@extends('admin.layouts.app')

@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive--sm">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Name')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Limit/Day')</th>
                            <th scope="col">@lang('Referral Commission')</th>
                            <th scope="col">@lang('status')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr>
                            <td data-label="@lang('Name')">{{$plan->name}}</td>
                            <td data-label="@lang('Price')" class="font-weight-bold">{{ $plan->price+0 }} {{$general->cur_text}}</td>     

                            <td data-label="@lang('Limit/Day')">{{ $plan->daily_limit}} @lang('PTC')</td>
                            <td data-label="@lang('Referral Commission')">@lang('up to') <span class="font-weight-bold text-primary px-3">{{ $plan->ref_level }} </span>@lang('level')</td>
                            <td data-label="@lang('Status')">
                                    @if($plan->status == 1)
                                <span class="badge badge--success font-weight-normal text--small">
                                    @lang('active')
                                </span>
                                    @else
                                    <span class="badge badge--danger font-weight-normal text--small">
                                    @lang('inactive')
                                </span>

                                    @endif
                                </span>
                            </td>
                            <td data-label="@lang('Action')"> 
                                <button class="icon-btn editBtn" data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-price="{{ $plan->price+0 }}" data-daily_limit="{{ $plan->daily_limit }}"  data-status="{{ $plan->status }}" data-ref_level="{{ $plan->ref_level}}" data-act="Edit">
                                    <i class="la la-pencil"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-4">
                <nav aria-label="...">
                    {{ $plans->links('admin.partials.paginate') }}
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- EDIT/ADD MODAL --}}
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="act"></span> @lang('Membership Plan')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.plan.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name"><strong>@lang('Name') :</strong> </label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Plan Name')" required>
                    </div>
                    <div class="form-group">
                        <label for="price"><strong>@lang('Price') :</strong> </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control has-append" name="price" placeholder="@lang('Price of Plan')" required>
                            <div class="input-group-append">
                                <div class="input-group-text">{{ $general->cur_text }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="daily_limit"><strong>@lang('Daily Ad Limit') :</strong></label>
                        <input type="number" class="form-control" name="daily_limit" placeholder="@lang('Daily Ad Limit')" required>
                    </div>
                    <div class="form-group">
                        <label for="details"><strong>@lang('Referral Commission') :</strong> </label>
                        <select name="ref_level" class="form-control" required>
                            <option value="0"> @lang('NO Referral Commission')</option>
                            @foreach($refs as $v)
                            <option value="{{$v->level}}"> @lang('Up to') {{$v->level}}  @lang('Level')</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="status"><strong>@lang('Status :')</strong> </label>
                        <input type="checkbox" data-height="46" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Inactive" data-width="100%"  data-toggle="toggle" name="status">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('breadcrumb-plugins')
<button class="icon-btn editBtn" data-id="0" data-act="Add"><i class="fa fa-fw fa-plus"></i>Add New</button>
@endpush


@push('script')
<script>
    (function($){
        "use strict";
        $('.editBtn').on('click', function() {
            var modal = $('#editModal');
            modal.find('.act').text($(this).data('act'));
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=price]').val($(this).data('price'));
            modal.find('input[name=daily_limit]').val($(this).data('daily_limit'));
            modal.find('input[name=status]').bootstrapToggle($(this).data('status') == 1 ? 'on' : 'off');
            modal.find('select[name=ref_level]').val($(this).data('ref_level'));
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush