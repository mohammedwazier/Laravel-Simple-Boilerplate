@extends('layout.dashboard', ['title' => 'Menu List'])
@section('content-dashboard')
<div class="mb-4">
    <h1 class="h3 mb-2 text-gray-800">Menu List</h3>
        <p class="mb-4">Pengaturan untuk menambahkan Menu, menghapus Menu dan mengubah Menu</p>
</div>

<div>
    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalWrapper">Tambah Menu</button>
        </div>
        <div class="card-body">
            <div id="accordion">
                @foreach($data as $d)
                <div class="card">
                    <div class="card-header" id="heading{{ $d->id }}">
                        <div class="row">
                            <div class="col my-auto">
                                <button class="btn collapsed" style="outline:none;box-shadow:none;" data-toggle="collapse" data-target="#collapse{{ $d->id }}" aria-expanded="false" aria-controls="collapse{{ $d->id }}">
                                    <i class="{{ $d->menu_icon }}"></i>
                                    {{ $d->menu_title }} <b>{{ $d->subMenu ? '+' : '' }}</b>
                                </button>
                            </div>
                            <div class="col text-right my-auto">
                                <button class="btn btn-sm btn-warning editFile" data-url="{{ route('dashboard.config.menu.edit', ['menu' => $d->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button>
                                <a href="{{ route('dashboard.config.menu.destroy', ['id' => $d->id]) }}" class="destroy"><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button></a>
                                <a href="{{ route('dashboard.config.menu.up', ['id' => $d->id, 'target' => $d->menu_sort - 1]) }}" class="up"><button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Up"><i class="fas fa-angle-up"></i></button></a>
                                <a href="{{ route('dashboard.config.menu.down', ['id' => $d->id, 'target' => $d->menu_sort + 1]) }}" class="down"><button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Down"><i class="fas fa-angle-down"></i></button></a>
                            </div>
                        </div>
                    </div>

                    @if($d->subMenu)
                    <div id="collapse{{ $d->id }}" class="collapse" aria-labelledby="heading{{ $d->id }}" data-parent="#accordion">
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($d->subMenu as $subMenu)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col">
                                            <i class="{{ $subMenu->menu_icon }}"></i>
                                            {{ $subMenu->menu_title }}
                                        </div>
                                        <div class="col text-right">
                                            <button class="btn btn-sm btn-warning editFile" data-url="{{ route('dashboard.config.menu.edit', ['menu' => $subMenu->id]) }}"><i class="fas fa-edit"></i></button>
                                            <a href="{{ route('dashboard.config.menu.destroy', ['id' => $subMenu->id]) }}" class="destroy"><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                                            <a href="{{ route('dashboard.config.menu.up', ['id' => $subMenu->id, 'target' => $subMenu->menu_sort - 1]) }}" class="up"><button class="btn btn-sm btn-primary"><i class="fas fa-angle-up"></i></button></a>
                                            <a href="{{ route('dashboard.config.menu.down', ['id' => $subMenu->id, 'target' => $subMenu->menu_sort + 1]) }}" class="down"><button class="btn btn-sm btn-primary"><i class="fas fa-angle-down"></i></button></a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

@component('components.modal.modalWrapper', ['modalId' => 'modalWrapper'])
@slot('modalContent')
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Menu Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.config.menu.store') }}" onsubmit="Loading();">
            @csrf
            <div class="form-group">
                <label for="menuNama">Nama Menu</label>
                <input type="text" name="nama" class="form-control" placeholder="Input nama Menu" required>
            </div>

            <div class="form-group">
                <label for="menuNama">URL Menu</label>
                <input type="text" name="url" class="form-control" placeholder="Input URL Menu" required>
                <small class="text-warning">Please check the <b><a href="https://fontawesome.com/v5/search?q=icon&m=free" target="_blank">Fontawesome v5</a></b> to check the Class of the Icon</small>
            </div>

            <div class="form-group">
                <label for="menuNama">Icon Menu</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-grip-horizontal" id="changeIcon"></i>
                        </span>
                    </div>
                    <input type="text" name="icon" class="form-control" id="iconMenu" placeholder="Input Icon Menu">
                </div>
            </div>

            <div class="form-group">
                <label>Menu Type</label>
                <select class="form-control" id="typeMenu" name="type" required>
                    <option value="">Pilih Tipe Menu</option>
                    <option value="header">Header</option>
                    <option value="sub_link">Sub Menu</option>
                    <option value="link">Link</option>
                </select>
            </div>

            <div id="showListCode" class="form-group">
                <label>Parent Menu</label>
                <select class="form-control" name="parent_id">
                    <option value="">Pilih Parent</option>
                    @foreach ($data as $v)
                    <option value="{{ $v->id }}">{{ $v->menu_title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">Tambah Menu Baru</button>
            </div>
        </form>

    </div>
</div>
@endslot
@endcomponent

@include('components.modal.modalWrapper', ['modalId' => 'modalEditWrapper', 'editScripts' => true])

@endsection

@push('js')
<script>
    $(document).ready(function() {
        /* $('select').select2({
            theme: 'bootstrap'
            dropdownParent: $('#modalWrapper')
        }); */
        $('#showListCode').hide();
        $('#typeMenu').on('change', function(e) {
            const val = e.target.value;
            val === 'sub_link' ? $('#showListCode').show() : $('#showListCode').hide();
        })

        $('#iconMenu').on('keyup', function(e) {
            $('#changeIcon').attr('class', e.target.value);
        })
    })

</script>
@endpush
