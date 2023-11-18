<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/scss/style.scss', 'resources/css/animations.css', 'resources/scss/icons.scss'])

    </head>
    <body>
        <header>
        <nav>     
            <div id="dropdown">
                <div class="dropdown_btn">
                    <span>{{ app()->getLocale() != 'en' && app()->getLocale() != 'nl' ? __('language') : app()->getLocale() }}</span>
                    <i class="gg-chevron-down"></i>
                </div>
                <ul class="dropdown_options">
                    <li class="dropdown_option">
                        <a href="{{ url('locale/nl') }}">
                        <img src="https://www.worldometers.info/img/flags/nl-flag.gif" alt="{{__('dutch_plural')}} {{__('flag')}}" class="dropdown_option_flag">
                        <span>NL</span>
                        </a>
                    </li>
                    <li class="dropdown_option">
                        <a href="{{ url('locale/en') }}">
                        <img src="https://www.worldometers.info/img/flags/uk-flag.gif" alt="{{__('english_plural')}} {{__('flag')}}" class="dropdown_option_flag">
                        <span>EN</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        </header>
        <section>
            <article id="login">
                <header class="login_header">
                    <div class="login_icon">
                        <i class="gg-user"></i>
                    </div>
                    <h1>Login</h1>
                </header>
                <Form class="login_form">
                    <input type="text" name="email" id="email" placeholder="E-mail">
                    <input type="password" name="password" id="password" placeholder="{{__('password')}}">
                    <a href="#" class="button">Login</a>
                    <a href="#" class="link">{{__('forgot_password')}}</a>
                </Form>
            </article>
        </section>

    </body>
    <script src="{{ mix('resources/js/dropdown.js') }}"></script>
</html>
