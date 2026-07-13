<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">
    <page_footer>
       <hr class="bg-hr mb-1" />
       <p>{!! site_copyright() !!}</p>
    </page_footer>

    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }
        .mb-5 {
            margin-bottom: 50px;
        }
        .mb-3 {
            margin-bottom: 30px;
        }
        table { 
            width: 100%; 
            color: #717375; 
            font-family: helvetica;
            line-height: 5mm; 
            border-collapse: collapse;
            vertical-align: middle;
        }

        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-theme {
            color: {{ SITE_PRIMARY_COLOR }};
        }
        .text-success {
            color: #00cc00;
        }
        .text-warning {
            color: #cccc00;
        }
        .text-danger {
            color: #cc0000;
        }
        .text-light {
            color: #c0c0c0;
        }
        .bg-hr {
            border: none;
            border-top: 1px solid #CFD1D2;
        }

        .border td {
            border-bottom: 1px solid #CFD1D2;
            padding: 5px 10px;
        }
        .thead th {
            background: #717375;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 14px;
            color: #ffffff;
            border: 1px solid #CFD1D2;
        }
        .no-border {
            border-right: 1px solid #CFD1D2;
            border-left: none;
            border-top: none;
            border-bottom: none;
        }
        .no-border-full {
            border-right: none;
            border-left: none;
            border-top: none;
            border-bottom: none;
        }
     
        .10p { width: 10%; }
        .15p { width: 15%; }
        .25p { width: 25%; }
        .50p { width: 50%; }
        .40p { width: 40%; }
        .60p { width: 60%; }
        .75p { width: 75%; }
        .100p { width: 100%; }
        .title {
            font-size: 18px;
            margin: 0;
            margin-bottom: 10px;
            color: #717375;
        }
        .mb-1 {
            margin-bottom: 10px;
        }
        #logo {
            height: 35px;
        }
        #favicon {
            max-height: 50px;
            max-width: 50px;
        }
    </style>
    
    <table>
        <tr>
            <td class="50p text-left">

                @php
                    $inLocal = app()->environment('local');
                @endphp

                @if ( ($file = asset_img_exists('logo.png')) && !$inLocal )
                    <img src="{{ asset_img($file) }}" id="logo">
                @elseif ( ($file = asset_img_exists('icons/favicon.png')) && !$inLocal )
                    <img src="{{ asset_img($file) }}" id="favicon">
                @else
                    <h1>{{ SITE_NAME }}</h1>
                @endif

            </td>
            <td class="50p text-right">
                <p>{{ translate(713) }}</p>
                <h1 class="text-theme">#{{ $reference }}</h1>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <hr class="bg-hr"/>
            </td>
        </tr>
    </table>

    @yield('content')
</page>