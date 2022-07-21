<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\RoleHasMenuModel;

use Session;
use URL;

class AuthRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->isMethod('get')){
            $user = Session::get('user');
            $menulist = RoleHasMenuModel::with(['menuData'])->where('menu_role_id', $user->role)->get();

            $urlData = [];
            $access = false;

            foreach($menulist as $v){
                $_state = strpos($request->url(), $v->menuData->menu_url);
                array_push($urlData, $_state);
                if($_state !== false){
                    $access = true;
                    break;
                }
            }

            if($access){
                return $next($request);
            }else{
                return redirect()->route('dashboard.logoutProcess');
            }
        }

        return $next($request);
    }
}
