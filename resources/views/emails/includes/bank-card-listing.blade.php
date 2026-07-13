<!-- BULLET LIST BEGIN -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>

        <tr>
            <td align="center" valign="top" class="bullet">•</td>
            <td align="left" valign="top" class="list">
                <small>{{ translate(614) }}</small><br>
                <strong>{{ $card->card_owner }}</strong>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top" class="bullet">•</td>
            <td align="left" valign="top" class="list">
                <small>{{ translate(611) }}</small><br>
                <strong>{{ hideCardNumber($card->number) }}</strong>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top" class="bullet">•</td>
            <td align="left" valign="top" class="list">
                <small>{{ translate(612) }}</small><br>
                <strong>{{ $card->expire }}</strong>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top" class="bullet">•</td>
            <td align="left" valign="top" class="list">
                <small>{{ translate(717) }}</small><br>
                <strong>{{ $card->brand_name }}</strong>
            </td>
        </tr>

    </tbody>
</table>
<!-- BULLET LIST END -->

<br>