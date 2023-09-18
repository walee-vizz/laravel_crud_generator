<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>SB Admin 2 - Dashboard</title> --}}
    <title> @yield('title')</title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('new_template/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"  crossorigin="anonymous">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('new_template/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .goog-te-banner-frame.skiptranslate,
        .goog-logo-link,
        #google_translate_element,
        .skiptranslate {
            display: none !important;
        }

        .selected-flag,
        .flags {
            width: 17px  !important;
        }

        .flags {
            cursor: pointer;
        }

        .za-nav-list {
            /* margin-bottom: 0;
            list-style: none; */
            position: relative;
            width: fit-content;
            /* top: 35%; */
            /* right: 4%; */
            z-index: 9999;
        }

        .za-nav-dropdown {
            display: none;
            list-style: none;
            position: absolute;
            top: 50px;
            left: 0;
            padding: 8px 14px;
            width: auto;
            background-color: white;
            box-shadow: 0 0 10px 0 #00000026;
            border-radius: 5px;
        }
    </style>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-7CY9W6WMF5');
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: "en",
                    includedLanguages: "en,fr,es,ru,hi,ta,zh-CN,de,it,JP,ar,nl,in,in,id,tl",
                    autoDisplay: false,
                },
                "google_translate_element1"
            );
        }

        function parseJSAtOnload() {
            var links = [
                    "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit",
                ],
                headElement = document.getElementsByTagName("head")[0],
                linkElement,
                i;
            for (i = 0; i < links.length; i++) {
                linkElement = document.createElement("script");
                linkElement.src = links[i];
                headElement.appendChild(linkElement);
            }
        }

        if (window.addEventListener) {
            window.addEventListener("load", parseJSAtOnload, false);
        } else if (window.attachEvent) {
            window.attachEvent("onload", parseJSAtOnload);
        } else {
            window.onload = parseJSAtOnload;
        }
    </script>


    @yield('styles')
</head>
