
@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')
<!-- blog section start -->
    <section class="ptb-150">
      <div class="container">
        <div class="row mb-none-30 justify-content-center">
        @foreach($blogs as $blog)
          <div class="col-lg-4 col-md-6 mb-30 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
            <div class="blog-post hover--effect-1 has-link">
              <a href="{{ route('blogDetail',$blog->id) }}" class="item-link"></a>
              <div class="blog-post__thumb">
                <img src="{{ get_image('assets/images/frontend/blog/'.$blog->data_values->image) }}" alt="image" class="w-100">
              </div>
              <div class="blog-post__content">
                <h4 class="blog-post__title">{{ __($blog->data_values->title) }}</h4>
                <p>{{ __($blog->data_values->preview) }}</p>
                <i class="blog-post__icon las la-arrow-right"></i>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="row">
            {{ $blogs->links($activeTemplate.'paginate') }}
        </div>
      </div>
    </section>
    <!-- blog section end -->
    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
@section('load-js')
    <script src="{{asset('assets/templates/minimul/js/chart.js')}}"></script>
@stop