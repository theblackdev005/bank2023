<div wire:init="init">
	<form action="" wire:submit.prevent="submit" method="post">
	    <x-alert />

		@foreach ($data as $key => $value)
			<div class="form-group mb-2">
				<div class="bg-light border py-2 shadow-sm rounded px-3" wire:ignore>
				    <label for="" class="form-label">{{ $key }}</label>

				    @if ( ! empty($data_input_radio[$key]) )
				    	<div>
				    		@foreach ($data_input_radio[$key] as $radio)
				    			<label for="{{ $key }}__{{ $radio }}" class="mr-2">
				    			    <input 
				    			        type="radio" 
				    			        id="{{ $key }}__{{ $radio }}" 
				    			        name="{{ $key }}" 
				    			        wire:model.defer="{{ $key }}" 
				    			        value="{{ $radio }}"> {{ $radio }}
				    			</label>
				    		@endforeach
				    	</div>
				    @else
				    	<input 
				    		type="text" 
				    		autocomplete="nope" 
				    		wire:model.defer="{{ $key }}" 
				    		class="form-control @error($key) is-invalid @enderror"/>
				    @endif
				    
			    </div>
			</div>
		@endforeach

		<button type="submit" class="btn font-weight-bold btn-success">
		    <span class="fa fa-check-circle"></span>
		    <span>Modifier les informations</span>
		</button>
	</form>
</div>