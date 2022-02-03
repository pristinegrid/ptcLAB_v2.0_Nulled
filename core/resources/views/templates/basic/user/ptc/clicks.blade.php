
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
										<th scope="col">@lang('Date')</th>
			                            <th scope="col">@lang('Total Click')</th>
			                            <th scope="col">@lang('Total Earn')</th>
									</tr>
								</thead>
								<tbody class="list">
									 @forelse($viewads as $key => $data)
			                            <tr>
			                                <td data-label="@lang('Date')">{{ __($data['date']) }}</td>
			                                <td data-label="@lang('Total Click')">{{ $data['clicks'] }}
			                                <td data-label="@lang('Total Earn')">{{ __(showAmount($data['amount'])) }} {{ $general->cur_text }}
			                                </td>
			                            </tr>
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
              	{{$viewads->links($activeTemplate.'paginate')}}
			</div>
		</div>
	</div>
</section>
@endsection