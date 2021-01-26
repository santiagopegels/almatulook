<script async type="text/javascript" src="{{ asset('js/app.js', App::environment() == 'production' ) . '?v='. md5(microtime()) }}"></script>

@stack('scripts')
