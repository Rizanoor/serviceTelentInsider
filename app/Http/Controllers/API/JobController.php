<?php

namespace App\Http\Controllers\API;

use App\Models\Jobs;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use App\Helpers\ResponseFormatter;
use Illuminate\Contracts\Queue\Job;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $job_title = $request->input('job_title');
        // $location = $request->input('location');
        // $workspace_type = $request->input('workspace_type');
        // $min_salary = $request->input('min_salary');
        // $max_salary = $request->input('max_salary');
        // $company = $request->input('company');

        if ($id) {
            // ambil data berdasarkan id
            $job = Jobs::with(['user_jobs'])->find($id);

            if ($job) {
                return ResponseFormatter::success(
                    $job,
                    'Data job berhasil diambil'
                );
            }
            else {
                return ResponseFormatter::error(
                    null,
                    'Data job kosong', 404
                );
            }
        }

        // ambil semua data
        $job = Jobs::with(['user_jobs']);

        // filtering data
        if ($job_title) {
            $job->where('job_title', 'like', '%' . $job_title . '%' );
        }

        return ResponseFormatter::success(
            $job->paginate($limit),
            'Data job berhasil diambil'
        );
    }


    public function store(JobRequest $request)
    {
        $data = $request->all();

        Jobs::create($data);

        return ResponseFormatter::success($data, 'Job company berhasil dibuat');
    }

    public function update(JobRequest $request, $id)
    {
        $data = $request->all();

        $item = Jobs::find($id);

        $item->update($data);

        return ResponseFormatter::success($data, 'Job company berhasil diupdate');
    }
}
