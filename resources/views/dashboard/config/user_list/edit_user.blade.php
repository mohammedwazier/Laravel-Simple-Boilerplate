<div class="modal-content w-100">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit User <b>{{ $user->name }}</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.config.user.update', ['user' => $user->id]) }}" onsubmit="Loading();">
            @method('PUT')
            @csrf
            <input type="hidden" name="type" value="editUser" />
            <div class="form-group">
                <label>Edit Nama User</label>
                <input type="text" name="nama" class="form-control" placeholder="Input nama user" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label>Edit Username User</label>
                <input type="text" name="username" class="form-control" placeholder="Input usernamne user" value="{{ $user->username }}" required>
            </div>

            <div class="form-group">
                <label>Edit Email User</label>
                <input type="email" name="email" class="form-control" placeholder="Input email user" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label>Edit Password User</label>
                <input type="password" name="password" class="form-control" placeholder="Input password baru">
            </div>

            <div class="form-group">
                <label>Pilih Role</label>
                <select class="form-control" name="role">
                    <option value="">Pilih Role</option>
                    @foreach ($role as $r)
                    <option value="{{ $r->id }}" {{ (int)$r->id === (int)$user->role ? 'selected' : '' }}>{{ $r->role_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit">Edit User</button>
            </div>
        </form>
    </div>
</div>
