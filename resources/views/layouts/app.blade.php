<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"
          integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/assets/css/font-awesome.min.css"
          integrity="sha512-ZJnaOJE/ubZSSmW2y0+3ePK/XSbxXPZbN4HAoT2X3wRu5OkGi76ae8Rx7b/PV19GL4xclSovNxGEa9NSPGXkzw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"
            integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Scripts -->
    @stack('css')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @include('layouts.messages')
        </div>
        @yield('content')
    </main>
</div>
<script>
    window.sendForm = (form, formData, submitButton = undefined, submitButtonText = "", success = undefined, fail = undefined) => {
        var url = form.attr('action'); // Get the form action URL

        var method = form.attr('method') ? form.attr('method').toUpperCase() : 'GET';

        // var formData = (method === 'POST') ? new FormData(this) : form.serialize();

        $.ajax({
            url: url,
            type: method, // Use the form's method or GET if not provided
            data: formData,
            contentType: method === 'POST' ? false : 'application/x-www-form-urlencoded', // Only for POST methods
            processData: method === 'POST' ? false : true, // Only for POST methods
            success: function (response) {
                if (success) success(response);
                if (response.message) {
                    toastr.success(response.message)
                }
                // Handle success (e.g., show a success message, reset form, etc.)
                // form[0].reset(); // Optionally reset the form
            },
            error: function (xhr) {
                if (fail) fail(xhr.responseJSON);
                if (xhr.responseJSON.message)
                    toastr.error(xhr.responseJSON.message)

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, errorMessages) {
                        var input = form.find('[name="' + key + '"]'); // Find the input by name
                        input.addClass('is-invalid'); // Add Bootstrap 'is-invalid' class
                        input.closest('div').append('<p class="invalid-feedback error-message">' + errorMessages[0] + ' </p>');
                    });
                } else {
                    // Handle other types of errors (e.g., server errors)
                    alert('Something went wrong. Please try again.');
                }
            },
            complete: function () {
                if (submitButton) {
                    $(submitButton).prop('disabled', false).text(submitButtonText);
                }
            }
        });

    }
</script>
@stack('js')
</body>
</html>
