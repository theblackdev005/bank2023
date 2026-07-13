<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Installation | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ site_favicon() }}">

    <meta name="robots" content="noindex">
    <meta name="description" content="Découvrez notre script Laravel de gestion de banque en ligne, offrant des fonctionnalités avancées pour une expérience bancaire moderne et sécurisée. Optimisez vos opérations financières avec notre solution fiable et flexible.">
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset_css('common.css') }}" />
    <style type="text/css">
        .form-label {
            font-weight: bold !important;
        }

        /*CONTROL SWITCH*/
        /* for sm */

        .custom-switch.custom-switch-sm .custom-control-label {
            padding-left: 1rem;
            padding-bottom: 1rem;
        }

        .custom-switch.custom-switch-sm .custom-control-label::before {
            height: 1rem;
            width: calc(1rem + 0.75rem);
            border-radius: 2rem;
        }

        .custom-switch.custom-switch-sm .custom-control-label::after {
            width: calc(1rem - 4px);
            height: calc(1rem - 4px);
            border-radius: calc(1rem - (1rem / 2));
        }

        .custom-switch.custom-switch-sm .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(calc(1rem - 0.25rem));
        }

        /* for md */

        .custom-switch.custom-switch-md .custom-control-label {
            padding-left: 2rem;
            padding-bottom: 1.5rem;
        }

        .custom-switch.custom-switch-md .custom-control-label::before {
            height: 1.5rem;
            width: calc(2rem + 0.75rem);
            border-radius: 3rem;
        }

        .custom-switch.custom-switch-md .custom-control-label::after {
            width: calc(1.5rem - 4px);
            height: calc(1.5rem - 4px);
            border-radius: calc(2rem - (1.5rem / 2));
        }

        .custom-switch.custom-switch-md .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(calc(1.5rem - 0.25rem));
        }

        /* for lg */

        .custom-switch.custom-switch-lg .custom-control-label {
            padding-left: 3rem;
            padding-bottom: 2rem;
        }

        .custom-switch.custom-switch-lg .custom-control-label::before {
            height: 2rem;
            width: calc(3rem + 0.75rem);
            border-radius: 4rem;
        }

        .custom-switch.custom-switch-lg .custom-control-label::after {
            width: calc(2rem - 4px);
            height: calc(2rem - 4px);
            border-radius: calc(3rem - (2rem / 2));
        }

        .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(calc(2rem - 0.25rem));
        }

        /* for xl */

        .custom-switch.custom-switch-xl .custom-control-label {
            padding-left: 4rem;
            padding-bottom: 2.5rem;
        }

        .custom-switch.custom-switch-xl .custom-control-label::before {
            height: 2.5rem;
            width: calc(4rem + 0.75rem);
            border-radius: 5rem;
        }

        .custom-switch.custom-switch-xl .custom-control-label::after {
            width: calc(2.5rem - 4px);
            height: calc(2.5rem - 4px);
            border-radius: calc(4rem - (2.5rem / 2));
        }

        .custom-switch.custom-switch-xl .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(calc(2.5rem - 0.25rem));
        }

        .text-cmd {
            color: #08E600 !important;
        }

        button[disabled] {
            background: #e0e0e0 !important;
            color: #a0a0a0 !important;
            pointer-events: none !important;
            border-color: #e0e0e0 !important;
        }

        .btn {
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .bg-dark {
            background: #14212b !important;
        }
    </style>

    @livewireStyles
</head>
<body class="bg-light">
    <div class="py-5">
        {{ $slot }}
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    @livewireScripts
    @yield('script')
</body>
</html>