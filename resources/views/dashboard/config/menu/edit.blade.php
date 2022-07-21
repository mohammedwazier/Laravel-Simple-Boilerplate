<div class="modal-content" id="wrapperModalData">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Menu Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.config.menu.update', ['menu' => $menu->id]) }}" onsubmit="Loading();">
            @method("PUT")
            @csrf
            <input type="hidden" name="menu_sort" value="{{ $menu->menu_sort }}" />
            <div class="form-group">
                <label for="menuNama">Nama Menu</label>
                <input type="text" name="nama" class="form-control" placeholder="Edit nama Menu" value="{{ $menu->menu_title }}" required>
            </div>

            <div class="form-group">
                <label for="menuNama">URL Menu</label>
                <input type="text" name="url" class="form-control" placeholder="Input URL Menu" value="{{ $menu->menu_url }}" required>
                <small class="text-warning">Please check the <b><a href="https://fontawesome.com/v5/search?q=icon&m=free" target="_blank">Fontawesome v5</a></b> to check the Class of the Icon</small>
            </div>

            <div class="form-group">
                <label for="menuNama">Icon Menu</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="{{ $menu->menu_icon }}" id="changeIcon"></i>
                        </span>
                    </div>
                    <input type="text" name="icon" class="form-control" id="iconMenu" placeholder="Input Icon Menu" value="{{ $menu->menu_icon }}">
                </div>
            </div>

            <div class="form-group">
                <label>Menu Type</label>
                <select class="form-control" id="typeMenu" name="type" required>
                    <option value="">Pilih Tipe Menu</option>
                    <option value="header" {{ $menu->menu_type === 'header' ? 'selected' : '' }}>Header</option>
                    <option value="sub_link" {{ $menu->menu_type === 'sub_link' ? 'selected' : '' }}>Sub Menu</option>
                    <option value="link" {{ $menu->menu_type === 'link' ? 'selected' : '' }}>Link</option>
                </select>
            </div>

            <div id="showListCode" class="form-group">
                <label>Parent Menu</label>
                <select class="form-control" name="parent_id">
                    <option value="0" {{ $menu->menu_parent === 0 ? 'selected' : '' }}>Pilih Parent</option>
                    @foreach ($data as $v)
                    <option value="{{ $v->id }}" {{ $menu->menu_parent !== 0 && $menu->menu_type === 'sub_link' && $menu->menu_parent === $v->id ? 'selected' : '' }}>{{ $v->menu_title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">Tambah Menu Baru</button>
            </div>
        </form>

    </div>
    <script>
        $(document).ready(function() {
            const wrapId = `#wrapperModalData`;
            $(wrapId).ready(function() {
                if ($(`${wrapId} #typeMenu`).val() !== 'sub_link') {
                    $(`${wrapId} #showListCode`).hide();
                }
                $(`${wrapId} #typeMenu`).on('change', function(e) {
                    const val = e.target.value;
                    val === 'sub_link' ? $(`${wrapId} #showListCode`).show() : $(`${wrapId} #showListCode`).hide();
                })

                $(`${wrapId} #iconMenu`).on('keyup', function(e) {
                    $('#wrapperModalData #changeIcon').attr('class', e.target.value);
                })
            })
        })

    </script>
</div>
