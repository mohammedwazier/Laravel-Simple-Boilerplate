<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\RoleModel;
use App\Models\MenuModel;
use App\Models\RoleHasMenuModel;

use Carbon\Carbon;
use Alert;
use Hash;

class UserListCT extends Controller
{
    public function index()
    {
        $user = User::with(['getRole'])->get();
        $role = RoleModel::all();

        $menu = MenuModel::where('menu_parent', 0)->whereIn('menu_type', ['link', 'header'])->orderBy('menu_sort', 'ASC')->get();
        foreach($menu as $k => $val){
            $subMenu = MenuModel::where('menu_parent', $val->id)->orderBy('menu_sort', 'ASC')->get();
            if(count($subMenu) > 0){
                $val->subMenu = $subMenu;
            }
        }

        return view('dashboard.config.user_list.index', [
            'user' => $user,
            'role' => $role,
            'menu' => $menu,
        ]);
    }

    /* public function create()
    {
        //
    } */

    public function store(Request $request)
    {
        if($request->type === "createUser"){
            // Create new User
            if(User::where('name', $request->name)->orWhere('email', $request->email)->first()){
                Alert::error('Gagal', 'Username atau Email telah digunakan, silahkan coba lagi!');
                return redirect()->route('dashboard.config.user.index');
            }
            $user = new User;
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();

            Alert::success("Sukses", "Sukses mendaftarkan User baru '{$request->nama}'");
        }
        if($request->type === "createRole"){
            $role = new RoleModel;
            $role->role_name = $request->nama_role;
            $role->save();

            if(isset($request->id)){
                foreach($request->id as $key => $value){
                    $menuHasRole = new RoleHasMenuModel;
                    $menuHasRole->menu_role_id = $role->id;
                    $menuHasRole->menu_menu_id = $value;
                    $menuHasRole->save();
                }
            }

            Alert::success("Sukses", "Sukses mendaftarkan Role baru '{$request->nama_role}'");
        }
        return redirect()->route('dashboard.config.user.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id, $type)
    {
        if($type === 'user'){
            $user = User::with(['getRole'])->findOrFail($id);
            $role = RoleModel::all();

            return view('dashboard.config.user_list.edit_user', [
                'user' => $user,
                'role' => $role,
            ]);
        }

        if($type === 'role'){
            $role = RoleModel::findOrFail($id);

            $menuHasRole = RoleHasMenuModel::where('menu_role_id', $role->id)->get();

            $arrData = [];

            foreach($menuHasRole as $k => $v){
                array_push($arrData, $v->menu_menu_id);
            }

            $menu = MenuModel::where('menu_parent', 0)->whereIn('menu_type', ['link', 'header'])->orderBy('menu_sort', 'ASC')->get();
            foreach($menu as $k => $val){
                $subMenu = MenuModel::where('menu_parent', $val->id)->orderBy('menu_sort', 'ASC')->get();
                if(count($subMenu) > 0){
                    $val->subMenu = $subMenu;
                }
            }

            return view('dashboard.config.user_list.edit_role', [
                'menu' => $menu,
                'role' => $role,
                'access' => $menuHasRole,
                'array_menu' => $arrData,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if($request->type === 'editUser'){
            $user = User::findOrFail($id);
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->username = $request->username;
            if((int)$user->role !== (int)$request->role){
                $user->role = $request->role;
            }
            if(!Hash::check($request->password, $user->password)){
                $user->password = Hash::make($request->password);
            }
            $user->save();

            Alert::success("Sukses", "Sukses mengubah data User");
        }

        if($request->type === 'editRole'){
            $role = RoleModel::findOrFail($id);
            $role->role_name = $request->nama_role;
            $role->save();

            $CurrentRole = RoleHasMenuModel::where('menu_role_id', $role->id)->each(function($cRole, $key){
                $cRole->delete();
            });

            if(isset($request->id)){
                foreach($request->id as $key => $value){
                    $menuHasRole = new RoleHasMenuModel;
                    $menuHasRole->menu_role_id = $role->id;
                    $menuHasRole->menu_menu_id = $value;
                    $menuHasRole->save();
                }
            }
            Alert::success("Sukses", "Sukses mengubah data Role");
        }

        return redirect()->route('dashboard.config.user.index');
    }

    public function destroy($id, $type)
    {
        if($type === 'user'){
            try {
                $user = User::findOrFail($id);
                $user->delete();

                Alert::success("Sukses", "Sukses menghapus User");
            } catch (\Throwable $th) {
                Alert::error("Gagal", "Gagal menghapus User");
            }
        }

        if($type === 'role'){
            try {
                $role = RoleModel::findOrFail($id);
                $role->delete();

                Alert::success("Sukses", "Sukses menghapus Role");
            } catch (\Throwable $th) {
                Alert::error("Gagal", "Gagal menghapus Role");
            }
        }

        return redirect()->route('dashboard.config.user.index');
    }
}
