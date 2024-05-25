<?php
namespace App\Jobs;

use App\Interfaces\SaveExternalDataInterface;
use App\Interfaces\SaveIntegrationDataInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exceptions\ApiValidationException;
use Illuminate\Support\Facades\Log;

class IntegrationProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $endpoint;
    protected string $token;
    protected array $body;
    protected int $page;
    private SaveIntegrationDataInterface $saveDataService;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $endpoint, string $token, array $body, int $page,SaveIntegrationDataInterface $saveDataService)
    {
        $this->endpoint = $endpoint;
        $this->token = $token;
        $this->body = $body;
        $this->page = $page;
        $this->saveDataService = $saveDataService;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws ApiValidationException
     */
    public function handle(SaveExternalDataInterface $saveExternalDataService)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');
        Log::channel('integration')->alert('Start integration process.');
        $saveExternalDataService
            ->reset()
            ->setBody($this->body)->setEndpoint($this->endpoint)->setToken($this->token)->setPage($this->page)
            ->save($this->saveDataService);
    }
}
