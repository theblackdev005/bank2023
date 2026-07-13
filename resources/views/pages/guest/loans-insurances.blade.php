@extends('layouts.guest')

@section('content')
	<div class="book-area py-5 bg-white">
	    <div class="container">
	        <div class="book-content text-center">
	            <h2>{{ translate(760) }}</h2>
	            <p>{{ translate(758) }} {{ translate(759) }}</p>
	        </div>
	    </div>
	</div>

	<section class="py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 mb-4">
					<div class="bg-white rounded p-3">
						<div class="w-100">
							<img src="{{ asset_img('insurances/'. $uri .'.jpg') }}" alt="" class="img-fluid border rounded mb-3 w-100">
						</div>
						
						<div class="py-3">
							<a href="#" class="mt-4 h2 text-dark">{{ translate($data[0]) }}</a>
							@foreach ($data[1] as $p)
								<p class="text-muted mt-2">{{ translate($p) }}</p>
							@endforeach
						</div>

					</div>
				</div>
				<div class="col-lg-5 ">
					<ul class="list-unstyled">

						@foreach ($data_service as $_uri => $value)
							<li class="row {{ ($_uri == $uri) ? 'bg-light' : 'bg-white' }} mb-2 shadow-sm py-3 rounded">
								<a href="{{ routeWithLocale('guest.insurance', $_uri) }}" class="col-3">
									<img src="{{ asset_img('insurances/'. $_uri .'.jpg') }}" alt="" class="img-fluid rounded">
								</a>
								<div class="col-9">
									<a href="{{ routeWithLocale('guest.insurance', $_uri) }}">
										<h6 class="mb-1 h5 text-dark">{{ translate($value[0]) }}</h6>
									</a>
									<div class="d-flex text-small">
										<span class="text-muted">{{ translate($value[1][0], 100) }}</span>
									</div>
								</div>
							</li>
						@endforeach

					</ul>
				</div>
			</div>
		</div>
	</section>
	<!--service-area end-->
@endsection