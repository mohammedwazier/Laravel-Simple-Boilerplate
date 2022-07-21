@extends('layout.dashboard', ['title' => 'Setting Default List'])
@section('content-dashboard')
<div class="mb-4">
    <h1 class="h3 mb-2 text-gray-800">Setting List</h3>
        <p class="mb-4">Pengaturan untuk menambahkan Pengaturan Bawaan, mengubah Pengaturan Bawaan dan menghapus Pengaturan Bawaan</p>
</div>

<div>
    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalWrapper">Tambah Menu</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped w-100">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Key</td>
                            <td>Value</td>
                            <td>Type</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($setting as $key => $st)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $st->st_key }}</td>
                            <td>{{ $st->st_value }}</td>
                            <td>{{ $st->st_type }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning editFile" data-url="{{ route('dashboard.config.setting.edit', ['setting' => $st->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button>
                                <a href="{{ route('dashboard.config.setting.destroy', ['id' => $st->id]) }}" class="destroy"><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>No</td>
                            <td>Key</td>
                            <td>Value</td>
                            <td>Type</td>
                            <td>Actions</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>

@component('components.modal.modalWrapper', ['modalId' => 'modalWrapper'])
@slot('modalContent')
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Setting Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.config.setting.store') }}" onsubmit="Loading();">
            @csrf
            <div class="form-group">
                <label>Key Setting</label>
                <input type="text" name="key" class="form-control" placeholder="Input Key Setting" required>
                <small class="text-warning">Key tidak boleh Duplikat</small>
            </div>

            <div class="form-group">
                <label for="menuNama">Value Setting</label>
                <input type="text" name="value" class="form-control" placeholder="Input Value Setting" required>
            </div>

            <div class="form-group">
                <label>Type Setting</label>
                <select class="form-control" name="type" required>
                    <option value="">Pilih Tipe Setting</option>
                    @foreach(Main::ListSettingType() as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">Tambah Setting Baru</button>
            </div>
        </form>

    </div>
</div>
@endslot
@endcomponent

@include('components.modal.modalWrapper', ['modalId' => 'modalEditWrapper', 'editScripts' => true])

@endsection
