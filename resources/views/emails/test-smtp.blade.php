<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Mail</title>
</head>
<body>

    <table width="100" style="width: 100%;">
        <tr>
            <td>
                <h1 style="margin: 0px 0px 48px 0px;">
                    {{ $parameter['title'] }}
                </h1>

                <p style="margin: 0px 0px 24px 0px;" class="copy-16">
                    {!! nl2br($parameter['message']) !!}
                </p>
            </td>
        </tr>
    </table>
    
</body>
</html>