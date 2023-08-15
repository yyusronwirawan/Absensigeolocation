<script src="{{ asset('template/admin') }}/js/bootstrap.js"></script>
<script src="{{ asset('template/admin') }}/js/app.js"></script>
<script src="{{ asset('template/admin') }}/extensions/jquery/jquery.min.js"></script>
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
@stack('js')
