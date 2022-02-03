@extends('admin.layouts.app')
@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive--sm">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th scope="col">@lang('Title')</th>
                            <th scope="col">@lang('Type')</th>
                            <th scope="col">@lang('Duration')</th>
                            <th scope="col">@lang('Maximum View')</th>
                            <th scope="col">@lang('Viewed')</th>
                            <th scope="col">@lang('Remain')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ptcs as $ptc)
                        <tr>
                            <td data-label="@lang('Title')">{{shortDescription($ptc->title,20)}}</td>
                            <td data-label="@lang('Type')">
                                    @if($ptc->ads_type == 1)
                                        <span class="font-weight-normal text--small badge badge--success"><i class="fa fa-link"></i> @lang('URL')</span>
                                    @elseif($ptc->ads_type == 2)
                                        <span class="font-weight-normal text--small badge badge--dark"><i class="fa fa-image"></i> @lang('Image')</span>
                                    @elseif($ptc->ads_type == 3)
                                        <span class="font-weight-normal text--small badge badge--primary"><i class="fa fa-code"></i> @lang('Script')</span>
                                    @else
                                        <span class="font-weight-normal text--small badge badge--primary"><i class="fa fa-code"></i> @lang('Youtube Link')</span>
                                    @endif
                            </td>
                            <td data-label="@lang('Duration')">{{$ptc->duration}} @lang('Sec')</td>
                            <td data-label="@lang('Maximum View')">{{$ptc->max_show}}</td>
                            <td data-label="@lang('Viewed')">{{$ptc->showed}}</td>
                            <td data-label="@lang('Remain')">{{$ptc->remain}}</td>


                            <td data-label="@lang('Amount')" class="font-weight-bold">{{ $ptc->amount+0 }} {{$general->cur_text}}</td>     

                            <td data-label="@lang('Status')">
                                @if($ptc->status == 1)
                                    <span class="font-weight-normal text--small badge badge--success">@lang('active')</span>
                                @else
                                    <span class="font-weight-normal text--small badge badge--warning">@lang('inactive')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Action')"><a class="icon-btn" href="{{route('admin.ptc.edit',$ptc->id)}}"><i class="la la-pen"></i></a></td>
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
                    {{ $ptcs->links('admin.partials.paginate') }}
                </nav>
            </div>
        </div>
    </div>
</div>


@endsection

@push('breadcrumb-plugins')
        <a class="icon-btn" href="{{route('admin.ptc.create')}}"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush

