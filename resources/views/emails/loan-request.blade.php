@extends('emails.includes.layout')

@section('content')
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ translate(339) }}
    </h1>

    <!-- BULLET LIST BEGIN -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>

            @foreach ($parameter['message'] as $key => $data)
                <tr>
                    <td align="center" valign="top" class="bullet">•</td>
                    <td align="left" valign="top" class="list">
                        {{ ucfirst(str_ireplace('_', ' ', $key)) }}: <strong>{{ $data }}</strong>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <!-- BULLET LIST END -->

    @include('emails.includes.customer-ip-ua')
@endsection