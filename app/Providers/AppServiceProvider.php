<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //


        require_once app_path('helpers.php');


        Schema::defaultStringLength(191);
        Paginator::defaultView("simple-default");
        Paginator::defaultSimpleView("simple-default");
        $data=DB::table("users")->first();

        //转换成标准对象
        $data=(object)$data;
        $data->starttime=microtime(true);

        $data->art_count=DB::table('articles')->get()->count();
        $data->cat_count=DB::table('categories')->get()->count();
        //随机十篇
        $data->hot_art10=DB::table('articles')->orderByDesc("views")->take(10)->get();
        $data->all_tags=DB::table('tags')->select("name")->distinct()->get();

        view()->composer('*', function ($view) use($data) {
            $view->with('data',$data);
        });
    }
}
