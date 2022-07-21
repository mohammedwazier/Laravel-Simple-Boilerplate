@component('components.modal.modalWrapper', ['modalId' => 'createRoleModal'])
@slot('modalContent')
<div class="modal-content w-100">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Role Baru dan Hak Akses untuk Role Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.config.user.store') }}" onsubmit="Loading();">
            @csrf
            <input type="hidden" name="type" value="createRole" />
            <div class="form-group">
                <label>Nama Role</label>
                <input type="text" name="nama_role" class="form-control uppercase" placeholder="Input nama role" required>
            </div>
            <div class="form-group">
                <div class="my-2 font-weight-bold">Pilih Menu yang akan Diakses</div>
                <div class="table-responsive">
                    <table class="table table-striped w-100">
                        @foreach ($menu as $mn)
                        <tr>
                            <td>{{ $mn->menu_title }}</td>
                            <td style="width: 50px;" class="text-right">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="id[]" value="{{ $mn->id }}" class="custom-control-input parent" data-value="{{ $mn->id }}" data-uid="parent_{{ $mn->id }}" id="customSwitch{{ $mn->id }}">
                                    <label class="custom-control-label" for="customSwitch{{ $mn->id }}"></label>
                                </div>
                            </td>
                        </tr>
                        @if($mn->subMenu)
                        @foreach ($mn->subMenu as $sm)
                        <tr>
                            <td>&emsp;&emsp;{{ $sm->menu_title }}</td>
                            <td class="text-right">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="id[]" value="{{ $sm->id }}" class="custom-control-input child parent_{{ $mn->id }}" data-parent="{{ $mn->id }}" id="customSwitch{{ $sm->id }}">
                                    <label class="custom-control-label" for="customSwitch{{ $sm->id }}"></label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                    </table>
                </div>
                <div class="form-group">
                    <hr />
                    <button class="btn btn-success">Tambah Role baru</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const wrapId = `#createRoleModal`
        $(wrapId).ready(function() {
            $(`${wrapId} .parent`).on('change', function(e) {
                e.preventDefault();
                const id = $(this).data('value');
                const checked = $(this).prop('checked');
                const child = $(`${wrapId} .parent_${id}`);
                child.map(d => {
                    $(child[d]).prop('checked', checked)
                })
            })
            $(`${wrapId} .child`).on('change', function(e) {
                e.preventDefault();
                const parentId = $(this).data('parent');
                const checked = $(this).prop('checked');

                if (checked) {
                    $(`${wrapId} #customSwitch${parentId}`).prop('checked', checked);
                }
            })
            $(`${wrapId} .uppercase`).on('keyup', function(e) {
                e.preventDefault();
                $(this).val(e.target.value.toUpperCase());
            })
        })
    })

</script>
@endslot
@endcomponent
