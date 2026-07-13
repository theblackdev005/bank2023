@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {!! translate(834, false, $cost) !!}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(835) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(836) }}
    </p>

    @include('emails.includes.single_warning')
@endsection