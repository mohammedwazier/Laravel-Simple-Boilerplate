<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuModel;

use Carbon\Carbon;
use Alert;

class MenuListCT extends Controller
{
    public function index()
    {
        $menu = MenuModel::where('menu_parent', 0)->whereIn('menu_type', ['link', 'header'])->orderBy('menu_sort', 'ASC')->get();
        foreach($menu as $k => $val){
            $subMenu = MenuModel::where('menu_parent', $val->id)->orderBy('menu_sort', 'ASC')->get();
            if(count($subMenu) > 0){
                $val->subMenu = $subMenu;
            }
        }
        return view('dashboard.config.menu.index', ['data' => $menu]);
    }

    public function store(Request $request)
    {
        $sort = MenuModel::where('menu_parent', 0)->orderBy('menu_sort', 'DESC')->first()->menu_sort;
        $parent = 0;
        if($request->parent_id && $request->type == "sub_link"){
            // There are Parent ID
            $sort = MenuModel::where('menu_parent', $request->parent_id)->orderBy('menu_sort', 'DESC')->first()->menu_sort;
            $parent = $request->parent_id;
        }

        $menu = new MenuModel;
        $menu->menu_url = $request->url;
        $menu->menu_title = $request->nama;
        $menu->menu_icon = $request->icon;
        $menu->menu_type = $request->type;
        $menu->menu_parent = $parent;
        $menu->menu_sort = $sort;
        $menu->created_at = Carbon::now('Asia/Jakarta');
        $menu->save();

        Alert::success("Sukses", "Sukses menambahkan Menu Baru");

        return redirect()->route('dashboard.config.menu.index');
    }

    public function edit($id)
    {
        $menu = MenuModel::findOrFail($id);
        $menuData = MenuModel::where('menu_parent', 0)->orderBy('menu_sort', 'ASC')->get();
        return view('dashboard.config.menu.edit', ['data' => $menuData, 'menu' => $menu]);
    }

    public function update(Request $request, $id)
    {
        $menu = MenuModel::findOrFail($id);
        $menu->menu_title = $request->nama;
        $menu->menu_url = $request->url;
        $menu->menu_icon = $request->icon;
        $menu->menu_type = $request->type;

        $parent_before = $menu->menu_parent;

        if((int)$request->parent_id !== $menu->menu_parent){
            $sort = MenuModel::where('menu_parent', $request->parent_id)->orderBy('menu_sort', 'DESC')->first()->menu_sort;
            $parent = $request->parent_id;

            $menu->menu_parent = $parent;
            $menu->menu_sort = $sort;
        }

        $menu->save();

        // Re Sorting the Parent Before after saving the Current Edit data
        $reSort = MenuModel::where('menu_parent', $parent_before)->orderBy('menu_sort', 'ASC')->get();
        $sortNew = 1;
        foreach($reSort as $r){
            $r->menu_sort = $sortNew;
            $r->save();
            $sortNew++;
        }

        Alert::success("Sukses", "Sukses mengubah Menu");
        return redirect()->route('dashboard.config.menu.index');
    }

    public function destroy($id)
    {
        MenuModel::findOrFail($id)->delete();
        Alert::success("Sukses", "Sukses menghapus Menu");
        return redirect()->route('dashboard.config.menu.index');
    }

    public function changeMenu($id, $target)
    {
        $menu = MenuModel::findOrFail($id);
        if((int)$target === 0){
            Alert::error("Gagal", "Menu sudah paling Atas");
            return redirect()->route('dashboard.config.menu.index');
        }

        $changeMenu = MenuModel::where('menu_parent', $menu->menu_parent)->where('menu_sort', $target)->first();
        if(!$changeMenu){
            Alert::error("Gagal", "Menu sudah paling Bawah");
            return redirect()->route('dashboard.config.menu.index');
        }
        $changeMenu->menu_sort = $menu->menu_sort;
        $changeMenu->save();

        $menu->menu_sort = $target;
        $menu->save();

        $reSort = MenuModel::where('menu_parent', $menu->menu_parent)->orderBy('menu_sort', 'ASC')->get();
        $sortNew = 1;
        foreach($reSort as $r){
            $r->menu_sort = $sortNew;
            $r->save();
            $sortNew++;
        }

        Alert::success("Sukses", "Sukses Mengubah Posisi Menu");
        return redirect()->route('dashboard.config.menu.index');
    }
}
