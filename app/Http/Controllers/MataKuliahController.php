<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class MataKuliahController extends Controller
{
    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('mata_kuliah.index', compact('token', 'session'));
    }

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10',
            'deskripsi' => 'required|string',
            'kelas' => 'required|string|max:3',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = MataKuliah::create([
            'kode' => $request['kode'],
            'nama' => $request['nama'],
            'deskripsi' => $request['deskripsi'],
            'kelas' => $request['kelas'],
        ]);

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function showData()
    {
        $data = MataKuliah::all();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function getData($kode)
    {
        $data = MataKuliah::where('kode', '=', $kode)->first();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:10',
            'deskripsi' => 'required|string',
            'kelas' => 'required|string|max:3',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $data = MataKuliah::where('kode', '=', $request['kode'])->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        /// UPDATE DATA
        $data->kode = $request['kode'];
        $data->nama = $request['nama'];
        $data->deskripsi = $request['deskripsi'];
        $data->kelas = $request['kelas'];
        $data->save();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($kode)
    {
        $data = MataKuliah::where('kode', '=', $kode)->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
