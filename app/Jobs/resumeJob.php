<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use PDF;
use Illuminate\Support\Facades\Storage;
use App\Resume;
use File; 

class resumeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', '100000');

        $data = $this->request;

        $user_id = $data['user_id'];

        unset($data['user_id']);

        $pdf = PDF::loadView('pdf_view', $data);

        $pdfName = "/".uniqid()."user_resume.pdf";

        if(!Storage::disk('public_uploads')->put($pdfName, $pdf->output())) {
            return "error";
        }

        if(File::exists($data['destinationPath'])) {
            File::delete($data['destinationPath']);
        }

        Resume::create([
            "user_id" => $user_id,
            "resume_path" => $pdfName
        ]);
    }
}
