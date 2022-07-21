@extends('layout.dashboard', ['title' => 'User List'])
@section('content-dashboard')
<h1 class="h3 mb-2 text-gray-800">Roles</h1>
<p class="mb-2">Manajemen Role dan Manajemen User</p>

<div class="row" id="tableData">
    <div class="col-md-7 col-sm-12 my-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">Tambah User</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped w-100">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Last Login</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $key => $usr)
                            {{-- {{ dd($usr->role) }} --}}
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $usr->name }}</td>
                                <td>{{ $usr->username }}</td>
                                <td>{{ $usr->email }}</td>
                                <td>{{ $usr->getRole->role_name }}</td>
                                <td>{{ $usr->last_login }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning editFile" data-url="{{ route('dashboard.config.user.edit', ['id' => $usr->id, 'type' => 'user']) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button>
                                    <a href="{{ route('dashboard.config.user.destroy', ['id' => $usr->id, 'type' => 'user']) }}" class="destroy"><button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Last Login</td>
                                <td>Actions</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 col-sm-12 my-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#createRoleModal">Tambah Role</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped w-100">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Role</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role as $key => $r)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $r->role_name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning editFile" data-url="{{ route('dashboard.config.user.edit', ['id' => $r->id, 'type' => 'role']) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button>
                                    <a href="{{ route('dashboard.config.user.destroy', ['id' => $r->id, 'type' => 'role']) }}" class="destroy"><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>No</td>
                                <td>Nama Role</td>
                                <td>Actions</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.modal.modalWrapper', ['modalId' => 'modalEditWrapper', 'editScripts' => true])

@include('dashboard.config.user_list.components.modal_createUser', ['role' => $role])
@include('dashboard.config.user_list.components.modal_createRole', ['menu' => $menu])


@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#tableData table').DataTable()
    })

</script>
@endpush
