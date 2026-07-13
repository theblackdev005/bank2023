@extends('emails.includes.layout')


@section('content')
    
    <h1 style="margin: 0px 0px 48px 0px;">
        {{ $subject }}
    </h1>

    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ $credentials['name'] }},
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate(731) }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('731v1') }}
    </p>
    <p style="margin: 0px 0px 12px 0px;" class="copy-16">
        {{ translate('731v2') }}
    </p>

    <!-- BULLET LIST BEGIN -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    {{ translate(827) }}: 
                    <strong>{{ $credentials['name'] }}</strong>
                </td>
            </tr>
            <tr> 
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    {{ translate(733) }}: 
                    <strong>{{ $credentials['username'] }}</strong>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    {{ translate(170) }}: 
                    <strong>{{ $credentials['email'] }}</strong>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    {{ translate(185) }}: 
                    <strong>{{ $credentials['password'] }}</strong>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- BULLET LIST END -->

    @include('emails.includes.single_warning')
@endsection