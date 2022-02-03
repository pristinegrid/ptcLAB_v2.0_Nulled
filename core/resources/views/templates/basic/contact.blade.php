
@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')

	@php
		$infos = getContent('contact.element');
		$contact = getContent('contact.content',true);
	@endphp

    <section class="pt-150 pb-150">
      <div class="container">
        <div class="row mb-none-40">
          @foreach($infos as $info)
          <div class="col-lg-4 col-md-6 mb-40">
            <div class="contact-item">
              <div class="icon">
                @php echo $info->data_values->icon @endphp
              </div>
              <div class="content">
                <h3 class="title">{{ __($info->data_values->title) }}</h3>
                <p>{{ __($info->data_values->content) }}</p>
              </div>
            </div><!-- contact-item end -->
          </div>
          @endforeach
        </div>
        <div class="row justify-content-center mt-100">
          <div class="col-lg-9">
            <div class="contact-form-wrapper pl-5">
              <h3 class="title">{{ __($contact->data_values->heading) }}</h3>
              <p>{{ __($contact->data_values->subheading) }}</p>
              <form class="contact-form mt-50" id="contact_form_submit" method="post">
                @csrf
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <input type="text" name="name" id="contact-name" placeholder="@lang('Name')">
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="email" name="email" id="contact-email" placeholder="@lang('Email')">
                  </div>
                  <div class="form-group col-lg-12">
                    <input type="text" name="subject" id="contact-email" placeholder="@lang('Subject')">
                  </div>
                  <div class="form-group col-lg-12">
                    <textarea name="message" id="contact-message" placeholder="@lang('Write message')"></textarea>
                  </div>
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary">@lang('send message')</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>


    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection