<!-- BULLET LIST BEGIN -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>

        @foreach (dyn_recipient_trait(recipient_keys(), $recipient) as $translation_key => $value)
            <tr>
                <td align="center" valign="top" class="bullet">•</td>
                <td align="left" valign="top" class="list">
                    <small>{{ translate($translation_key) }}</small><br>
                    <strong>{{ $value }}</strong>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
<!-- BULLET LIST END -->

<br>