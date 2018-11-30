<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestWs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't:ws';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    static $domain = '127.0.0.1';

    static $port = '80';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        extension_loaded('swoole');
        $cli = new \swoole_http_client(self::$domain, self::$port);
        $cli->on('message', function ($_cli, $frame) {
            echo '-----accept message ------' . PHP_EOL;
            echo $frame->data . PHP_EOL;
            if ($frame->data == 'Welcome to LaravelS') {
                $_cli->push('send message');
            }
            if ($frame->data) {
                sleep(2);
                $_cli->push('send message2');
            }
        });
        $cli->upgrade('/ws', function ($cli) {
            echo "-----build success-----\n";
        } );
        $cli->on('close', function ($cli) {
            echo "---------close connect------\n";
        });
    }
}
