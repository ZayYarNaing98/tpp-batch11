<?php

namespace App\Services;

use App\Repositories\Batch\BatchRepositoryInterface;

class BatchService
{
    protected $batchRepository;
    public function __construct(BatchRepositoryInterface $batchRepository)
    {
        $this->batchRepository = $batchRepository;
    }


    public function batchTotal()
    {
        $batches = $this->batchRepository->index();

        return $batches->count();
    }
}
