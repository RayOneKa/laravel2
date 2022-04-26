<?php

namespace App\Jobs;

use App\Events\Counter;
use App\Events\ExportCategoriesFinished;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class exportCategoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $categories = Category::get();
        $fileName = "public/exportCategories_{$this->userId}.csv";
        Storage::delete($fileName);

        $count = $categories->count();

        $categories->each(function ($category, $idx) use ($fileName, $count) {
            Storage::append($fileName, collect($category)->implode(';'));
            $percent = round((($idx + 1) / $count) * 100, 2);
            Counter::dispatch($percent);
        });

        ExportCategoriesFinished::dispatch("exportCategories_{$this->userId}.csv");
    }
}
