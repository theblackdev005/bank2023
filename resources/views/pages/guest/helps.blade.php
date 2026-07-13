@extends('layouts.guest')

@php
	$faqs = array(
		[262, [263]],
		[264, [265], true],
		[266, [267]],
		[268, [269]],
		[270, [271]],
		[272, [273]],

		[795, [
				789,
				[790, 791, 792, 793],
				794,
			]
		],

		[861, [862]],
		[863, [864]],
		[865, [866]],
		[867, [868]],
		[869, [870]],
		[871, [872]],
		[873, [874]],
		[875, [876]],
		[877, [878]],
		[879, [880]],
		[881, [882]],
		[883, [884]],
		[885, [886]],
		[887, [888]],
		[889, [890]],
		[891, [892]],
		[893, [894]],
		[895, [896]],
		[897, [898]],
		[899, [900]],
		[901, [902]],
	);
@endphp

@section('content')
	<!--service-area start-->
	<div class="service-area default-pd">
		<div class="container">

			<div class="row">
				<div class="col-md-4">
					<div class="section-title">
						<h2 class="title">{{ translate(261) }}</h2>
						<div class="text-muted">{{ translate(796) }}</div>
					</div>
					<a href="{{ routeWithLocale('guest.contact') }}" class="btn btn-primary btn-sm">{{ translate(147) }}</a>
				</div>
				<div class="col-md-8">
					<div class="faq-container" id="accordion">

						@foreach ($faqs as $index => $faq)
							<div class="card border-0 border-bottom">
								<div class="card-header py-2 bg-transparent" id="heading--{{ $index }}">
									<h5 class="btn btn-link font-weight-bold text-dark p-0 {{ empty($faq[2]) ? 'collapsed' : '' }}" data-toggle="collapse" data-target="#collapse-{{ $index }}" aria-expanded="{{ !empty($faq[2]) ? 'true' : 'false' }}" aria-controls="collapse-{{ $index }}">
										» {{ translate($faq[0]) }}
									</h5>
								</div>

								<div id="collapse-{{ $index }}" class="collapse{{ !empty($faq[2]) ? ' show' : '' }}" aria-labelledby="heading--{{ $index }}" data-parent="#accordion">
									<div class="card-body">
										@foreach ($faq[1] as $paragraph)
											@if ( is_int($paragraph) )
												<p class="text-muted">{{ translate($paragraph) }}</p>
											@elseif ( is_array($paragraph) )
												<ul>
													@foreach ($paragraph as $li)
														<li class="text-muted">{{ translate($li) }}</li>
													@endforeach
												</ul>
											@endif
										@endforeach
									</div>
								</div>
							</div>
						@endforeach

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--service-area end-->
@endsection

@section('script')
	<script type="text/javascript">
		$('.collapse').collapse();
	</script>
@endsection