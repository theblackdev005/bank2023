<div wire:init="init">

    @section('style')
        <style type="text/css">
            .text-small {
                font-size: 12px !important;
            }
        </style>
    @endsection
    
    <div class="p-3 shadow-sm bg-light rounded border mb-3">
        <div>
            <label class="form-label">Fichier de configuration</label>
            <div>
                <button type="button" @disabled($disable_generate_btn) wire:click.prevent="create_theme_file" class="btn font-weight-bold btn-success">
                    <span class="fa fa-check-circle"></span>
                    <span>Generate</span>
                </button>
                <button type="button" @disabled(!$disable_generate_btn) wire:click.prevent="delete_theme_file" class="btn font-weight-bold btn-danger">
                    <span class="fa fa-remove"></span>
                    <span>Delete</span>
                </button>
            </div>
        </div>
        <div class="pt-3">
            <label class="form-label">Convertir Hex en RGB</label>
            <div>
                <a target="_blank" href="https://www.rapidtables.com/convert/color/hex-to-rgb.html" class="btn font-weight-bold btn-info">
                    <span class="fa fa-link"></span>
                    <span>Hex to rgb</span>
                </a>
            </div>
        </div>
    </div>

    <div class="p-3 shadow-sm bg-light rounded border mb-3">
        <div>
            <label for="current_preset" class="form-label">Themes pré-enrégistrés.</label>
            <div class="form-group">
                <select class="form-control" wire:model.defer="current_preset" wire:change="change_theme_using_preset" name="current_preset" id="current_preset">
                    <option value=""></option>
                    @foreach ($preset_themes as $preset)
                        <option value="{{ $preset }}">{{ ucfirst(str_ireplace('.json', '', $preset)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @if ( $themeConfigFileData )
        {{-- <x-sweet-alert /> --}}
        <h4 class="border py-2 text-center m-0 bg-light mb-3">Couleurs détectées : {{ count($themeConfigFileData) }}</h4>
        <form action="" wire:submit.prevent="submit" method="post">

            <div class="row">
                @php
                    $index = 0;
                @endphp
                @foreach ($themeConfigFileData as $fromColor => $toColor)
                    <div class="col-6 col-md-4">
                        <div class="form-group overflow-hidden {{ ($SITE_PRIMARY_COLOR_POSITION == $index) ? 'bg-warning' : 'bg-light'}} p-2 rounded shadow0-sm border">
                            <label for="" class="form-label m-0">{{ $fromColor }}</label>
                            <p class="m-0 text-small d-flex align-items-center justify-content-between text-muted" style="font-size: 12px;">
                                <label for="spr__{{ $index }}" wire:click="submit_default_color('{{ !empty($theming[$index]) ? $theming[$index] : $fromColor }}', {{ $index }})" class="m-0">
                                    <input type="radio" id="spr__{{ $index }}" name="SITE_PRIMARY_COLOR">
                                    <span>Défaut</span>
                                </label>
                                <a class="text-danger" href="" wire:click.prevent="delete_color('{{ $fromColor }}')">Delete</a>
                            </p>
                            <input type="text" style="background: {{ !empty($theming[$index]) ? $theming[$index] : $fromColor }};" wire:model.lazy="theming.{{ $index }}" class="form-control font-weight-bold">
                        </div>
                    </div>

                    @php
                        $index++;
                    @endphp
                @endforeach
            </div>

            <button type="submit" class="btn font-weight-bold btn-success">
                <span class="fa fa-check-circle"></span>
                <span>Générer les css</span>
            </button>
        </form>
    @endif
    
</div>