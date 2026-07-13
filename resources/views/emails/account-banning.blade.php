@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>

    @if ( $customer->isBanned() )
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate('709v1') }}
        </p>
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {!! translate('709v2', false, $customer->admin->email) !!}
        </p>
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate('709v3') }}
        </p>
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate('709v4') }}
        </p>
    @else
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate(711) }}
        </p>
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate('711v1') }}
        </p>
        <p style="margin: 0px 0px 24px 0px;" class="copy-16">
            {{ translate('711v2') }}
        </p>
    @endif

    @include('emails.includes.single_warning')
@endsection