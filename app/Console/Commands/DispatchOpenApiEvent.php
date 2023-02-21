<?php

namespace App\Console\Commands;

use App\Dropshipping\Jobs\DropshipOpenApiEvent;
use Illuminate\Console\Command;

class DispatchOpenApiEvent extends Command
{

    protected $signature = 'openApi:dispatchEvent';
    protected $description = 'Dispatch an Open API event so the CommentSold monolith can pick it up.';

    public function handle()
    {
        $this->info('Dispatching DropshipOpenApiEvent');
        DropshipOpenApiEvent::dispatch('create/product', ['some' => 'data bar'])->onQueue('open-api');
        DropshipOpenApiEvent::dispatch('create/order', ['order number' => 123456, 'name' => 'Foo'])->onQueue('open-api');
        DropshipOpenApiEvent::dispatch('unknown/route', ['some' => 'data bar'])->onQueue('open-api');
    }
}
