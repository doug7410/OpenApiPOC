<?php

namespace App\Dropshipping\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DropshipOpenApiEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;
    public string $topic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $topic, array $data)
    {
        $this->data = $data;
        $this->topic = $topic;
    }

    public function handle(): void
    {
        $routes = $this->routes();

        if(!array_key_exists($this->topic, $routes)) {
            dump('The "' . $this->topic . '" event route does not exist.');
            dump(['data' => $this->data]);
            return;
        }

        $routes[$this->topic]($this->data);
    }

    private function routes(): array
    {
        return [
            'errors' => function($data) {
                dump('received an error event');
                dump(['data' => $data]);
            },
            'create/order' => function($data) {
                dump('received an order event');
                dump(['data' => $data]);
            }
        ];
    }
}
