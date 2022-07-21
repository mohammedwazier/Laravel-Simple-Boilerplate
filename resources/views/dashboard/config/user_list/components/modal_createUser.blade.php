@component('components.modal.modalWrapper', ['modalId' => 'createUserModal'])
@slot('modalContent')
<div class="modal-content w-100">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah User Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.config.user.store') }}" onsubmit="Loading();">
            @csrf
            <input type="hidden" name="type" value="createUser" />
            <div class="form-group">
                <label>Nama User</label>
                <input type="text" name="nama" class="form-control" placeholder="Input nama user" required>
            </div>

            <div class="form-group">
                <label>Username User</label>
                <input type="text" name="username" class="form-control" placeholder="Input usernamne user" required>
            </div>

            <div class="form-group">
                <label>Email User</label>
                <input type="email" name="email" class="form-control" placeholder="Input email user" required>
            </div>

            <div class="form-group">
                <label>Password User</label>
                <input type="password" name="password" class="form-control" placeholder="Input password user" required>
            </div>

            <div class="form-group">
                <label>Pilih Role</label>
                <select class="form-control" name="role">
                    <option value="">Pilih Role</option>
                    @foreach ($role as $r)
                    <option value="{{ $r->id }}">{{ $r->role_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit">Tambah User</button>
            </div>
        </form>
    </div>
</div>
@endslot
@endcomponent
