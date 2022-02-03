
@extends($activeTemplate .'layouts.user')
@section('content')
    @include($activeTemplate.'breadcrumb')
    <section class="cmn-section">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="col-md-12 mb-30">
                    <ul class="right">
                        <li>
                            <a href="{{route('ticket') }}" class="btn float-right cmn-btn" data-toggle="tooltip" data-placement="top" title="@lang('My Support Ticket')">
                                <i class="fa fa-eye"></i> @lang('See All')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-60-80">
                    <div class="col-md-12 mb-30">
                        <form action="{{route('ticket.store')}}" role="form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row ">
                                <div class="form-group col-md-6">
                                    <label for="name">@lang('Name')</label>
                                    <input type="text"  name="name" value="{{$user->firstname . ' '.$user->lastname}}" class="form-control form-control-lg" placeholder="@lang('Enter Name')" required readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">@lang('Email address')</label>
                                    <input type="email"  name="email" value="{{$user->email}}" class="form-control form-control-lg" placeholder="@lang('Enter your Email')" required readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="website">@lang('Subject')</label>
                                    <input type="text" name="subject" value="{{old('subject')}}" class="form-control form-control-lg" placeholder="@lang('Subject')" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="priority">@lang('Priority')</label>
                                    <select name="priority" class="form-control form-control-lg">
                                        <option value="3">@lang('High')</option>
                                        <option value="2">@lang('Medium')</option>
                                        <option value="1">@lang('Low')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="inputMessage">@lang('Message')</label>
                                    <textarea name="message" id="inputMessage" rows="12" class="form-control">{{old('message')}}</textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-12">
                                    <label for="inputAttachments">@lang('Attachments')</label>
                                </div>
                                <div class="col-9 file-upload">
                                    <input type="file" name="attachments[]" id="inputAttachments" class="form-control form-control" />
                                    <div id="fileUploadsContainer"></div>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn cmn-btn extraTicketAttachment">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="col-sm-12 ticket-attachments-message text-muted">
                                    @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx")
                                </div>
                            </div>
                            <div class="row form-group justify-content-center">
                                <div class="col-md-12">
                                    <button class="btn cmn-btn w-100 bg-3  text-center mt-3" type="submit" id="recaptcha" >&nbsp;@lang('Submit Now')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('style')
    <style>
        .editor-statusbar{
            display: none;
        }
        .text-xs-center {
            text-align: center;
        }

        .g-recaptcha {
            display: inline-block;
        }
    </style>
@endpush
@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.extraTicketAttachment').click(function(){
                $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control form-control mt-2" required />')
            });
        })(jQuery);

    </script>
@endpush
