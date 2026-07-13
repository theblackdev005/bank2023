@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>

    @if ( $rib->amount <= 0 )
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate('782v1') }}
        </p>
    @else
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {!! translate(782, false, $amount) !!}
        </p>
    @endif

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(783) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(784) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(785) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(787) }}
    </p>

    @include('emails.includes.single_warning')
@endsection