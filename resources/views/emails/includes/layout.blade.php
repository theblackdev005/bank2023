<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ SITE_NAME }}</title>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting"> <!--[if !mso]><!-->
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700');
    </style>

    @php
        $emailBgColor = '#f2f2f2';
    @endphp

    <!--<![endif]-->
    <style type="text/css">
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%
        }

        a, a.link, body a {
            color: {{ SITE_PRIMARY_COLOR }} !important;
            text-decoration: none;
        }

        table, td {
            mso-table-lspace: 0;
            mso-table-rspace: 0
        }

        img {
            -ms-interpolation-mode: bicubic
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: 0;
            text-decoration: none
        }

        table {
            border-collapse: collapse !important
        }

        body {
            height: 100% !important;
            margin: 0 auto !important;
            padding: 0 !important;
            width: 100% !important
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important
        }

        #MessageViewBody a {
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-family: inherit;
            font-weight: inherit;
            line-height: inherit
        }

        img + div {
            display: none
        }

        #modBrowser {
            color: #a4a4a4;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 21px;
            font-weight: 400;
            text-align: right;
            padding: 12px 32px 12px 32px
        }

        #modBrowser .link {
            color: {{ SITE_PRIMARY_COLOR }};
            text-decoration: none
        }

        #modLogo {
            padding: 42px 56px 56px 56px
        }

        #modLogo .logo {
            color: {{ SITE_PRIMARY_COLOR }};
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            font-size: 16px;
            display: block;
            text-align: left
        }

        #modBody {
            color: #6d6f70;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            text-align: left;
            padding: 0 56px 56px 56px
        }

        #modBody .link {
            color: {{ SITE_PRIMARY_COLOR }};
            text-decoration: none
        }

        #modBody h1 {
            color: #4a4a4a;
            font-size: 32px;
            font-weight: 700;
            line-height: 38px
        }

        #modBody .copy-20 {
            color: #4a4a4a;
            font-size: 20px;
            font-weight: 700;
            line-height: 30px
        }

        #modBody .copy-18 {
            color: #4a4a4a;
            font-size: 18px;
            font-weight: 700;
            line-height: 28px
        }

        #modBody .copy-16 {
            font-size: 16px;
            font-weight: 400;
            line-height: 24px
        }

        #modBody .list {
            color: #6d6f70;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            font-size: 16px;
            line-height: 24px;
            padding: 0 0 15px 0
        }

        #modBody .list-lt {
            color: #6d6f70;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            font-size: 16px;
            line-height: 24px;
            padding: 0 0 30px 0
        }

        #modBody .list-tc {
            color: #6d6f70;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 18px;
            padding: 0 0 48px 0
        }

        #modBody .bullet {
            color: {{ SITE_PRIMARY_COLOR }};
            font-family: Arial, sans-serif;
            width: 50px;
            font-size: 30px;
            line-height: 23px;
            text-align: center
        }

        #modFooter {
            color: #807a79;
            padding: 48px 20px 48px 20px;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif
        }

        #modFooter .ghost-link {
            color: #807a79;
            text-decoration: none
        }

        #modFooter .copy-14 {
            font-size: 14px;
            line-height: 21px
        }

        #modFooter .copy-12 {
            font-size: 12px;
            line-height: 18px
        }

        #modFooter .icann {
            color: #807a79;
            display: block;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            font-size: 14px
        }

        @media screen and (max-width: 480px) {
            .wrapper {
                width: 100% !important;
                max-width: 100% !important
            }

            .fluid {
                width: 100% !important
            }

            .img-max {
                max-width: 100% !important;
                height: auto !important
            }

            .mobile-hide {
                display: none !important
            }

            .no-padding {
                padding: 0 0 0 0 !important
            }

            .logo {
                max-width: 200px !important;
                height: auto !important
            }

            .a-cn {
                text-align: center !important
            }

            .a-lt {
                text-align: left !important
            }

            .a-rt {
                text-align: right !important
            }

            h1 {
                font-size: 26px !important;
                line-height: 32px !important
            }

            .pad-modLogo {
                padding: 40px 24px 10px 24px !important
            }

            .pad-modBody {
                padding: 40px 24px 48px 24px !important
            }
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important
        }
    </style>
    <!--[if (mso)|(mso 16)]>
    <style type="text/css">a {
        text-decoration: none
    }</style><![endif]-->
</head>
<body style="margin: 0 !important; padding: 0 !important; background-color: {{ $emailBgColor }};" bgcolor="{{ $emailBgColor }}">
    <!--[if !mso]><!-->
    <div style="display: none; max-height: 0px; overflow: hidden;"> &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;</div>
    <!--<![endif]-->
    <table bgcolor="{{ $emailBgColor }}" width="100%" border="0" cellspacing="0" cellpadding="0" class="wrapper" role="presentation">
        <tbody>
            <tr>
                <td align="center" bgcolor="{{ $emailBgColor }}" style="padding: 12px 24px 0px 24px;" class="no-padding">
                    <table width="640" border="0" align="center" cellpadding="0" cellspacing="0" style="width: 640px;" class="fluid" role="presentation">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                        <tbody>
                                            <tr>
                                                <td align="right" id="modBrowser" class="a-cn">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td bgcolor="#FFFFFF" style="border: 1px solid #E8E8E8;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-shadow: 0px 3px 1px #EEEEEE; border: 1px solid #E8E8E8;" role="presentation">
                                        <tbody>
                                            <tr>
                                                <td align="left" valign="top" id="modLogo" class="pad-modLogo">
                                                    <a href="{{ routeWithLocale('guest.index') }}" target="_blank">
                                                        <img src="{{ asset_img('logo.png') }}" alt="{{ SITE_NAME }}" width="172" height="32" border="0" class="logo">
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top" class="pad-modBody" id="modBody">

                                                    @yield('content')

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <!-- FOOTER BEGIN -->
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%" role="presentation">
                                        <tbody>
                                            <tr>
                                                <td align="center" class="pad-modFooter" id="modFooter">
                                                    {{-- <p style="margin: 0px 0px 0px 0px;" class="copy-14">
                                                        <a href="" target="_blank" class="ghost-link">
                                                            {{ SITE_ADDRESS }}
                                                        </a>
                                                    </p> --}}
                                                    <p style="margin: 0px 0px 32px 0px;" class="copy-14">
                                                        {!! site_copyright() !!}
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>