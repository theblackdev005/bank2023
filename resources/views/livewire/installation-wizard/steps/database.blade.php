<div wire:init="init">
	<form action="" wire:submit.prevent="submit" method="post">
		<x-alert />

		<div class="alert bg-light" wire:poll.keep-alive="db_connexion_checker">
		    <span>Vérification : </span>
		    <span class="badge badge-{{ $dbIsConnected ? 'success' : 'danger' }}">
		    	{{ $dbIsConnected ? 'Réussie !' : 'Echec !' }}
		    </span>
		</div>

		@if ( $console_output )
			<div class="bg-secondary rounded p-2 mb-2">
				<p class="m-0 font-weight-bold text-cmd">{!! nl2br($console_output) !!}</p>
			</div>
		@endif
		
		<div class="row">
			@foreach ($data as $key => $value)
				<div class="col-lg-6">
					<div class="form-group">
					    <label for="" class="form-label">{{ $key }}</label>
					    <input 
					    	type="text" 
					    	autocomplete="nope" 
					    	wire:model.defer="{{ $key }}" 
					    	class="form-control @error($key) is-invalid @enderror"/>
					</div>
				</div>
			@endforeach
		</div>

		<button type="submit" class="btn font-weight-bold btn-success">
			<span class="fa fa-check-circle"></span>
			<span>Configurer la BDD</span>
		</button>
		<a href="javascript:;" @disabled(!$dbIsConnected) wire:click.prevent="migrate" class="btn font-weight-bold btn-dark">
			<span class="fa fa-upload"></span>
			<span>Migration</span>
		</a>
	</form>
</div>