@extends('emails.includes.layout')


@section('content')
    
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ translate(702) }}
    </h1>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(703) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {!! translate(704) !!}
    </p>

    @include('emails.includes.single_warning')
@endsection