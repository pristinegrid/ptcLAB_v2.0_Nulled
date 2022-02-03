
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
										<th scope="col">@lang('Title')</th>
										<th scope="col">@lang('Action')</th>
									</tr>
								</thead>
								<tbody class="list">
									@forelse($ads as $data)
									@if(!in_array($data->id, $viewed))
									<tr>
										<td data-label="@lang('Title')">{{ __($data->title) }}</td>
										<td data-label="@lang('Action')">
											<a href="{{ route('user.ptc.show',Crypt::encryptString($data->id.'|'.auth()->user()->id)) }}" class="btn btn-primary" target="_blank">@lang('View Now')</a>
										</td>
									</tr>
									@endif
									@empty
									<tr>
										<td class="text-center" colspan="100%">{{ __($empty_message) }}</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>
              		</div>
              	</div>
			</div>
		</div>
	</div>
</section>
@endsection