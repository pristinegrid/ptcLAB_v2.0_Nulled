@php
    $howWorkCaption = getContent('how_work.content',true);
    $works = getContent('how_work.element');
@endphp
<!-- how it works begin-->
        <div class="how-it-works">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-8">
                        <div class="section-title">
                            <h2>{{ __($howWorkCaption->data_values->heading) }}</h2>
                            <p>{{ __($howWorkCaption->data_values->subheading) }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($works as $work)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="single-works">
                            <div class="part-icon">
                                @php echo $work->data_values->icon @endphp
                            </div>
                            <div class="part-text">
                                <h3>{{ __($work->data_values->title) }}</h3>
                                <p>{{ __($work->data_values->content) }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- how it works end -->