@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $parameter['title'] }}
    </h1>

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {!! nl2br($parameter['message']) !!}
    </p>
    
    @include('emails.includes.customer-ip-ua')
@endsection