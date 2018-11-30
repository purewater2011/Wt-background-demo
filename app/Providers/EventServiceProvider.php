<?php

namespace App\Providers;

use App\Listeners\RelationToggledListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Overtrue\LaravelFollow\Events\RelationToggled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RelationToggled::class => [
            RelationToggledListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
        // 如果变量$events不存在，你也可以通过Facade调用\Event::listen()。
        \Event::listen('laravels.received_request', function (\Illuminate\Http\Request $req, $app) {
            $req->query->set('get_key', 'hhxsv5');// 修改querystring
            $req->request->set('post_key', 'hhxsv5'); // 修改post body
        });
        \Event::listen('laravels.generated_response', function (\Illuminate\Http\Request $req, \Symfony\Component\HttpFoundation\Response $rsp, $app) {
            $rsp->headers->set('header-key', 'hhxsv5');// 修改header
        });
    }
}
