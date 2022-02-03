@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">

                <form role="form" method="POST" action="{{ route("admin.ptc.store") }}" enctype="multipart/form-data">
                    @csrf


                    <div class="row">

                       <div class="form-group col-md-8">
                        <label>@lang('Title of the Ad') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title') }}" placeholder="@lang('Title')" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>@lang('Amount') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="amount" class="form-control form-control-lg" value="{{ old('amount') }}" placeholder="@lang('User will get ...')" required>
                            <div class="input-group-append">
                                <div class="input-group-text"> {{ $general->cur_text }} </div>
                            </div>
                        </div>
                    </div>  


                    <div class="form-group col-md-4">
                        <label>@lang('Duration') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="duration" class="form-control form-control-lg" value="{{ old('duration') }}" placeholder="@lang('Duration')" required>
                            <div class="input-group-append">
                                <div class="input-group-text">@lang('SECONDS')</div>
                            </div>
                        </div>
                    </div>  

                    <div class="form-group col-md-4">
                        <label>@lang('Maximum Show') <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="max_show" class="form-control form-control-lg" value="{{ old('max_show') }}" placeholder="@lang('Maximum Show') " required>
                            <div class="input-group-append">
                                <div class="input-group-text">@lang('Times')</div>
                            </div>
                        </div>
                    </div>  




                    <div class="form-group col-md-4">
                        <label>@lang('Status')</label>
                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Active" data-off="Inactive" name="status">
                    </div>
                </div>






                <div class="row pt-5 mt-5 border-top">

                    <div class="form-group col-md-4">
                        <label for="ads_type">@lang('Advertisement Type')</label>
                        <select class="form-control form-control-lg" id="ads_type" onchange="onChange(this.value)" name="ads_type" >
                            <option value="1" {{ old('ads_type')==1?'selected':'' }}>@lang('Link / URL')</option>
                            <option value="2" {{ old('ads_type')==2?'selected':'' }}>@lang('Banner / Image')</option>
                            <option value="3" {{ old('ads_type')==3?'selected':'' }}>@lang('Script / Code')</option>
                            <option value="4" {{ old('ads_type')==4?'selected':'' }}>@lang('Youtube Embeded Link')</option>
                        </select>
                    </div>
                    <div class="form-group col-md-8" id="websiteLink">
                        <label>@lang('Link') <span class="text-danger">*</span></label>
                        <input type="text" name="website_link" class="form-control form-control-lg" value="{{ old('website_link') }}" placeholder="@lang('http://example.com')">
                    </div>
                    <div class="form-group col-md-8" id="youtube">
                        <label>@lang('Youtube Embeded Link') <span class="text-danger">*</span></label>
                        <input type="text" name="youtube" class="form-control form-control-lg" value="{{ old('youtube') }}" placeholder="@lang('https://www.youtube.com/embed/your_code')">
                    </div>
                    <div class="form-group col-md-8 d-none" id="bannerImage">
                        <label>@lang('Banner') <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-lg"  name="banner_image">
                    </div>
                    <div class="form-group col-md-8 d-none" id="script">
                        <label>@lang('Script') <span class="text-danger">*</span></label>
                        <textarea  name="script" class="form-control form-control-lg">{{ old('script') }}</textarea>
                    </div>
                </div>

                <div class="row pt-5 mt-5 border-top">
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.ptc.index') }}" class="icon-btn"><i class="fa fa-fw fa-backward"></i> @lang('Go Back') </a>
@endpush


@push('script')
<script>
    (function($){
        "use strict";
        $('#ads_type').change(function(){
            var adType = $(this).val();
            if (adType == 1) {
                $("#websiteLink").removeClass('d-none');
                $("#bannerImage").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
            } else if (adType == 2) {
                $("#bannerImage").removeClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").addClass('d-none');
            } else if(adType == 3) {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").removeClass('d-none');
                $("#youtube").addClass('d-none');
            } else {
                $("#bannerImage").addClass('d-none');
                $("#websiteLink").addClass('d-none');
                $("#script").addClass('d-none');
                $("#youtube").removeClass('d-none');
            }
        }).change();
    })(jQuery);
</script>
@endpush