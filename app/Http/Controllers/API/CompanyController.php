<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $nama = $request->input('nama');
        $show_job = $request->input('show_job');


        if ($id) {
            // ambil data berdasarkan id
            $company = Company::with(['jobs'])->find($id);

            if ($company) {
                return ResponseFormatter::success(
                    $company,
                    'Data company berhasil diambil'
                );
            }
            else {
                return ResponseFormatter::error(
                    null,
                    'Data company kosong', 404
                );
            }
        }

        // ambil semua data dengan query kosong
        $company = Company::query();

        // filtering data
        if ($nama) {
            $company->where('nama', 'like', '%' . $nama . '%' );
        }

        if($show_job) {
            $company->with('jobs');
        }

        return ResponseFormatter::success(
            $company->paginate($limit),
            'Data list company berhasil diambil'
        );
    }
}
