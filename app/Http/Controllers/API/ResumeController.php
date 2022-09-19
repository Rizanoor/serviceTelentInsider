<?php

namespace App\Http\Controllers\API;

use App\Models\Resume;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function uploadResume(ResumeRequest $request)
     {
        // panggil semua request data
        $data = $request->all();

        // simpan file pada kolom attachment di folder assets/resume
        $data['attachment'] = $request->file('attachment')->store('assets/resume', 'public');

        Resume::create($data);

        return ResponseFormatter::success($data,'Resume has been uploaded');

     }


}
