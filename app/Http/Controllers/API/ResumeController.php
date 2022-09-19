<?php

namespace App\Http\Controllers\API;

use App\Models\Resume;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;

class ResumeController extends Controller
{
    public function uploadResume(ResumeRequest $request)
     {
        // panggil semua request data
        $data = $request->all();

        // simpan file pada kolom attachment di folder assets/resume
        $data['attachment'] = $request->file('attachment')->store('assets/resume', 'public');

        // resume berhasil dibuat
        Resume::create($data);

        // kembalikan response
        return ResponseFormatter::success($data,'Resume berhasil diupload');

     }

     public function fetch()
     {
        // cari resume
         $resume = Resume::all();

         // kembalikan respponse successs
         return ResponseFormatter::success($resume,'Data list resume berhasil diambil');
     }
}
