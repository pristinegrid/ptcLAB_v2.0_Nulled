
@extends($activeTemplate .'layouts.master')
@section('content')
@include($activeTemplate.'breadcrumb')
    <div class="ptb-150">
        <div class="container">
        	<div class="row">
        		<div class="col-md-12">
        			@php echo $item->data_values->content @endphp
        		</div>
        	</div>
        </div>
    </div>
@endsection