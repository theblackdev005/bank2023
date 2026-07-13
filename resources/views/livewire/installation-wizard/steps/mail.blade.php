<div wire:init="init">
    <form action="" wire:submit.prevent="submit" method="post">
        <x-alert />
        
        <div class="row">
            @foreach ($data as $key => $value)
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="form-label">{{ $key }}</label>
                        <input 
                            type="text" 
                            autocomplete="nope" 
                            wire:model.lazy="{{ $key }}" 
                            class="form-control @error($key) is-invalid @enderror"/>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn font-weight-bold btn-success">
            <span class="fa fa-check-circle"></span>
            <span>Modifier les informations</span>
        </button>
    </form>
</div>