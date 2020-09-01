<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/app.js', App::environment() == 'production' ) . '?v='. md5(microtime()) }}"></script>

@stack('scripts')