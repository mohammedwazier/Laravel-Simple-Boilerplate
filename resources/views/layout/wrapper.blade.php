<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @stack('meta')
    <title>{{ $title }} - {{ Main::GetSetting('title') }}</title>
    @include('components.css')
    @stack('css')

    <script src="{{ asset('public/assets/vendor/jquery/jquery.min.js') }}"></script>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/fc-4.1.0/fh-3.2.4/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/datatables.min.js"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script>
        const Loading = () => Swal.fire({
            title: 'Please Wait !'
            , allowOutsideClick: false
            , onBeforeOpen: () => {
                Swal.showLoading()
            }
        , });
        const LoadingDestroy = () => Swal.close();

        $(document).ready(function() {
            $('.destroy, .up, .down').on('click', function(e) {
                e.preventDefault();
                const _ = $(this);
                const textData = {
                    destroy: 'Apakah anda yakin akan menghapus Data ini?'
                    , up: 'Apakah anda akan Mengubah Posisi Data ini?'
                    , down: 'Apakah anda akan Mengubah Posisi Data ini?'
                , }

                Swal.fire({
                        icon: 'question'
                        , title: 'Confirm!'
                        , text: textData[`${this.className}`]
                        , showCancelButton: true
                    , })
                    .then(function({
                        isConfirmed
                    }) {
                        if (isConfirmed) {
                            Loading();
                            window.location.href = _.attr('href')
                        }
                    })
            })
        })

    </script>
</head>

<body class="{{ $classBody }} min-vh-100">
    @yield('content-wrapper')
    @include('components.js')
    @stack('js')
</body>
</html>
