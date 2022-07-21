<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuModel;
use App\Models\RoleModel;
use App\Models\SettingModel;
use App\Models\RoleHasMenuModel;

use Session;

class MainCT extends Controller
{

    public static function generateRandomString($length = 10, $type = 'normal') {
        if($type === 'normal'){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }else{
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    public static function encodeId($value){
        return Self::generateRandomString(20).bin2hex($value);
    }

    public static function md5($string)
    {
        return md5($string);
    }

    public static function decodeId($value){
        try {
            return hex2bin(substr($value, 20));
        } catch (\Throwable $th) {
            abort(404);
        }
    }


    public static function GetListManu()
    {
        $role = RoleModel::find(Session::get('user')->role);

        if($role->role_name === 'SUPERADMIN'){
            $menu = MenuModel::where('menu_parent', 0)->orderBy('menu_sort', 'ASC')->get();
            foreach($menu as $k => $val){
                $subMenu = MenuModel::where('menu_parent', $val->id)->orderBy('menu_sort', 'ASC')->get();
                if(count($subMenu) > 0){
                    $val->subMenu = $subMenu;
                }
            }
            return $menu;
        }

        $menuHasRole = RoleHasMenuModel::where('menu_role_id', $role->id)->get();

        $arrData = [];

        foreach($menuHasRole as $k => $v){
            array_push($arrData, $v->menu_menu_id);
        }

        $menu = MenuModel::where('menu_parent', 0)->whereIn('id', $arrData)->orderBy('menu_sort', 'ASC')->get();
        foreach($menu as $k => $val){
            $subMenu = MenuModel::where('menu_parent', $val->id)->whereIn('id', $arrData)->orderBy('menu_sort', 'ASC')->get();
            if(count($subMenu) > 0){
                $val->subMenu = $subMenu;
            }
        }

        return $menu;
    }

    public static function SerializeSetting($data, $type)
    {
        $CONSTANT = [
            'string' => function($value){
                return strval($value);
            },
            'integer' => function($value){
                return intval($value);
            },
            'boolean' => function($value){
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        ];

        return $CONSTANT[$type]($data);
    }

    public static function ListSettingType()
    {
        return ['string', 'integer', 'boolean'];
    }

    public static function GetSetting($key)
    {
        $setting = SettingModel::where('st_key', $key)->first();
        $serialize = Self::SerializeSetting($setting->st_value, $setting->st_type);
        return $serialize;
    }
}
