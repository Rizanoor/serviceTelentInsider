<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Storage;

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
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data company kosong',
                    404
                );
            }
        }

        // ambil semua data dengan query kosong
        $company = Company::query();

        // filtering data
        if ($nama) {
            $company->where('nama', 'like', '%' . $nama . '%');
        }

        if ($show_job) {
            $company->with('jobs');
        }

        return ResponseFormatter::success(
            $company->paginate($limit),
            'Data list company berhasil diambil'
        );
    }

    public function store(CompanyRequest $request)
    {
        $data = $request->all();

        // validasi upload logo
        $logo = $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg|file|max:1024',
        ]);

        // jika validasi logo memenuhi maka name foto akan tergenerate
        // dan masuk ke folder Storage/app/public/imageLogo
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = time() . '.' . $logo->getClientOriginalExtension();
            Storage::putFileAs('public/assets/imageLogo', $logo, $filename);

            $data['logo'] = $filename;
        }


        Company::create($data);

        return ResponseFormatter::success($data, 'Company berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        // simpan data user
        $data = $request->all();

        // ambil data user yang sedang login
        $company = Company::find($id);

            // validasi upload logo
            $logo = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg|file|max:1024',
            ]);

            // jika validasi logo memenuhi maka name foto akan tergenerate
            // dan masuk ke folder Storage/app/public/imageLogo
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $filename = time() . '.' . $logo->getClientOriginalExtension();
                Storage::putFileAs('public/assets/logo', $logo, $filename);

                $data['logo'] = $filename;
            }

        // data company diupdate
        $company->update($data);

        // jalankan response dan kembalikan sukses bersama dengan pesannya
        return ResponseFormatter::success($company, 'Profile company is updated');
    }
}
