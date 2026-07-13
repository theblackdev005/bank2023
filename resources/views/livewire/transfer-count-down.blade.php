<div id="countdown" wire:poll.1s>
    @php
        $diff = countDownTimer( $loadsection );
    @endphp

    @if ( $diff)
        <h1 class="d-inline" id="day">{{ $diff['day'] }}</h1>:
        <h1 class="d-inline" id="hour">{{ $diff['hour'] }}</h1>:
        <h1 class="d-inline" id="min">{{ $diff['min'] }}</h1>:
        <h1 class="d-inline" id="sec">{{ $diff['sec'] }}</h1>
    @else
        <a class="btn-link" wire:click="exitPage" href="">{{ translate(374) }}</a>
    @endif
    
</div>