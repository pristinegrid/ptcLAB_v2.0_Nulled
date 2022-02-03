<link rel="stylesheet" href="{{ asset('assets/global/css/iziToast.min.css') }}">
<script src="{{ asset('assets/global/js/iziToast.min.js') }}"></script>

<script type="text/javascript">
    (function($,document){
        "use strict";
        @if(session()->has('notify'))
            @foreach(session('notify') as $msg)
                iziToast.{{ $msg[0] }}({message:"{{ $msg[1] }}", position: "topRight"});
            @endforeach
        @endif
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        iziToast.error({
            message: '{{ $error }}',
            position: "topRight"
        });
        @endforeach
        @endif
        function notify(status,message) {
            iziToast[status]({
                message: message,
                position: "topRight"
            });
        }
    })(jQuery);
</script>

