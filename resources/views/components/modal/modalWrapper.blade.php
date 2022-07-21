@php
$random = rand();
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="modalWrapperDashboard" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div id="contentDashboard{{ $random }}" class="w-100">
            @if(isset($modalContent))
            {{ $modalContent }}
            @endif
        </div>
    </div>
</div>

@if(isset($editScripts))
<script>
    $(document).ready(function() {

        const reActivateClose = () => {
            $(`.close`).on('click', function() {
                setTimeout(function() {
                    $(this).closest('.modal-content').remove();
                }, 200)
            })
        }
        $('.editFile').on('click', function(e) {
            Loading();
            e.preventDefault();
            const _ = $(this);
            const urlGet = _.data('url');
            $.ajax({
                type: 'GET'
                , url: urlGet
                , success: function(res) {
                    LoadingDestroy();
                    $('#contentDashboard{{ $random }}').html(res);
                    $('#{{ $modalId }}').modal('show')
                    reActivateClose();
                }
                , error: function(err) {
                    // console.log('err', err)
                    LoadingDestroy();
                    Swal.fire({
                        icon: 'error'
                        , title: 'Gagal'
                        , text: 'Gagal memuat Data'
                    })
                }
            })
        })

    })

</script>
@endif
