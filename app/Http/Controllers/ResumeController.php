<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Resume;
use App\Jobs\resumeJob;


class ResumeController extends Controller
{
   public function createResume (Request $request) {

        $data = $request->input();

        if( $request->all()['image'] !== 'null' ) {
          $file = $request->file('image');
     		  $name = uniqid().$file->getClientOriginalName();
          $destinationPath = public_path().'/uploads/images/';
          $file->move($destinationPath, $name);       

          $data['destinationPath'] = public_path().'/uploads/images/'.$name;
        }
        else {
          $data['destinationPath'] = public_path().'/uploads/default/default.png';
        }

        resumeJob::dispatch($data)->delay(now()->addMinutes(1));
        
        return "success";
   }

   public function myResumes(Request $request) {
       $resumes = Resume::where('user_id',$request->user_id)->get()->toArray();
       return($resumes);
   }

   public function downloadPdf($file) {

   		$file = $file.".pdf";

   	   return response()->download(public_path("uploads/".$file));

   }
}
