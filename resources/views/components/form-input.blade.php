@section('style')
    <style type="text/css">
        .form-control.is-invalid {
            background-color: #F8D7DA !important;
        }
    </style>
@endsection

@php
    $wireModel = $wiremodel ? 'wire:model='. $wiremodel : '';
@endphp

@if ( $type === 'file' )
    @if ( !empty($label) )
        <label for="" class="form-label">{{ $label }}</label>
    @endif
    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" {{ $wireModel }} class="custom-file-input @error($old) is-invalid @enderror" name="{{ $name }}">
            <label class="custom-file-label" for="">{{ $placeholder }}</label>
        </div>
    </div>
@else
    
    @if ( !$addons )
        <div class="form-group">
            @if ( !empty($label) )
                <label for="" class="form-label">{{ $label }}</label>
            @endif
            {{ $slot }}
            <input step="{{ $step ?? 1 }}" type="{{ $type ?? 'text' }}" {{ $wireModel }} placeholder="{{ $placeholder }}" autocomplete="nope" value="{{ ( $type === 'password' ) ? null : (old( $old ) ?? $value) }}" name="{{ $name }}" class="form-control @error($old) is-invalid @enderror" @required(!$optional)>
        </div>
    @else
        <div class="input-group">
            <input step="{{ $step ?? 1 }}" type="{{ $type ?? 'text' }}" {{ $wireModel }} placeholder="{{ $placeholder }}" autocomplete="nope" value="{{ old( $old ) ?? $value }}" name="{{ $name }}" class="form-control rounded @error($old) is-invalid @enderror">
            <span class="border-0 bg-transparent input-group-text">
                {!! $addons !!}
            </span>
        </div>
    @endif

@endif
