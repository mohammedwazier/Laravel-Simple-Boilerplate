@php
$rand = rand();
@endphp
<div class="modal-content w-100" id="editRoleModal{{ $rand }}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Setting <b>{{ $setting->st_key }}</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.config.setting.update', ['setting' => $setting->id]) }}" onsubmit="Loading();">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label>Key Setting</label>
                <input type="text" name="key" class="form-control" placeholder="Input Key Setting" value="{{ $setting->st_key }}" disabled>
                <small class="text-warning">Key tidak boleh Diubah</small>
            </div>

            <div class="form-group">
                <label for="menuNama">Value Setting</label>
                <input type="text" name="value" class="form-control" placeholder="Input Value Setting" value="{{ $setting->st_value }}" required>
            </div>

            <div class="form-group">
                <label>Type Setting</label>
                <select class="form-control" name="type" required>
                    <option value="">Pilih Tipe Setting</option>
                    @foreach(Main::ListSettingType() as $v)
                    <option value="{{ $v }}" {{ $setting->st_type === $v ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">Ubah Setting</button>
            </div>
        </form>
    </div>
</div>
