@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 0px 0px 14px 0px;" class="copy-16">
        {{ $customer->fullname() }},
    </p>

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {!! translate(807) !!}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(808) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(809) }}
    </p>

    <!-- BULLET LIST BEGIN -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>

            @foreach (rib_keys() as $key => $name)
                @if ( ! empty($rib->$key) )
                    <tr>
                        <td align="center" valign="top" class="bullet">•</td>
                        <td align="left" valign="top" class="list">
                            <small>{{ translate($name) }}</small><br>
                            <strong>{{ $rib->$key }}</strong>
                        </td>
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>
    <!-- BULLET LIST END -->

    <br>

    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(810) }}
    </p>
    <p style="margin: 0px 0px 24px 0px;" class="copy-16">
        {{ translate(811) }}
    </p>

    @include('emails.includes.single_warning')
@endsection