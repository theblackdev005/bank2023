@extends('layouts.admin')

@section('content')
	<section class="container-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 p-5 bg-white">
					<h1 class="mb-5">Différentes configurations du site</h1>

					<form action="" method="post">
						@csrf

						@foreach ($configs as $id => $config)

							<div class="form-group mb-4">
							    <div class="well">
							        <label class="form-label m-0">
							        	<span class="badge bg-primary text-white">#{{ $id + 1 }}</span>
							        	<span>{{ $config->name }}</span>
							        </label>
							        <p class="text-muted m-0 mb-1">{{ $config->comment }}</p>

							        @if ( $config->input_type === 'textarea' )
							        	<textarea class="form-control bg-white" name="config[{{ $config->name }}]">{{ $config->value }}</textarea>
							        @elseif ( $config->input_type === 'boolean' )
							        	<x-admin-custom-switch name="config.{{ $config->name }}" checked="{{ $config->value }}" />
							        @else
							        	<input type="{{ $config->input_type }}" class="form-control bg-white" autocomplete="nope" name="config[{{ $config->name }}]" value="{{ $config->value }}">
							        @endif

							    </div>
							</div>
							
						@endforeach

						<div class="form-group">
							<button type="submit" name="submit" class="btn font-weight-bold btn-xs btn-success">
								<i class="fa fa-check-circle"></i> 
								<span>Mettre à jour les configurations</span>
							</button>
						</div>

					</form>

				</div>
			</div>
		</div>
	</section>
@endsection