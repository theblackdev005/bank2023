@php
    $currency = $loan->customer->currency;
@endphp

<!-- BULLET LIST BEGIN -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>

        <tr>
            <td align="center" valign="top" class="bullet">•</td>
            <td align="left" valign="top" class="list">
                <small>{{ translate(713) }}</small><br>
                <strong>#{{ $loan->uniqid }}</strong>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top" class="bullet">•</td>
            <td align="left" valign="top" class="list">
                <small>{{ translate(353) }}</small><br>
                <strong>{{ setCurrency($loan->currency, $loan->amount) }}</strong>
            </td>
        </tr>

        @if ( $loan->isApproved() )
            
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    <small>{{ translate(342) }}</small><br>
                    <strong>{{ $loan->teag }}%</strong>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    <small>{{ translate(343) }}</small><br>
                    <strong>{{ setCurrency($loan->currency, $loan->monthly_payment) }}</strong>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    <small>{{ translate(349) }}</small><br>
                    <strong>{{ dateFormat($loan->start_at) }}</strong>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    <small>{{ translate(727) }}</small><br>
                    <strong>{{ setCurrency($loan->currency, $loan->total_interest) }}</strong>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    <small>{{ translate(859) }}</small><br>
                    <strong>{{ setCurrency($loan->currency, $loan->total_mpayment) }}</strong>
                </td>
            </tr>

        @endif

        <tr>
            <td align="center" valign="top" class="bullet">•</td>
            <td align="left" valign="top" class="list">
                <small>{{ translate(60) }}</small><br>
                <span>{!! nl2br($loan->goal) !!}</span>
            </td>
        </tr>

    </tbody>
</table>
<!-- BULLET LIST END -->

<br>