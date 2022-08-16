<!DOCTYPE html>
<html lang="en" class="h-full font-sans">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ Nova::name() }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('app.css', 'vendor/nova') }}">

    <style>
        body {
            font-family: "Montserrat", sans-serif !important;
        }

        .btn,
        .form-input,
        .rounded-lg {
            border-radius: 0 !important;
        }
    </style>
    <script>
        function checkAutoSubmit(el) {
            if (el.value.length === 6) {
                document.getElementById('authenticate_form').submit();
            }
        }
    </script>
</head>

<body class="bg-40 text-black h-full">
<div class="h-full">
    <div class="px-view py-view mx-auto">
        <div class="mx-auto py-8 max-w-sm text-center text-90">
            @include('nova::partials.logo')
        </div>

        <form id="authenticate_form" class="bg-white shadow rounded-lg p-8 max-w-xl mx-auto" method="POST" action="/2fa/authenticate">
            @csrf
            <h2 class="p-2">Recovery</h2>

            <p class="p-2"><strong>Enter one of your recovery codes. If you don't have any, please contact the system administrator.</strong></p>

            <div class="text-center pt-3">
                <div class="mb-6 w-1/2" style="display:inline-block">
                    <div>
                        <label class="block font-bold mb-2" for="co">Recovery code</label>
                        <input class="form-control form-input form-input-bordered w-full" id="recover" type="text" name="recover" value="" autofocus="">
                    </div>
                    @if (isset($error))
                        <p id="error_text" class="text-center font-semibold text-danger my-3">
                            {{ $error }}
                        </p>
                    @endif
                </div>
                <button class="w-1/2 btn btn-default btn-primary hover:bg-primary-dark" type="submit">
                    Check
                </button>
                <br>
                <a href="{{ $authenticationUrl }}">Try again with a One Time Password</a>
            </div>
        </form>
    </div>
</div>
</body>

</html>