<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class MateriController extends Controller
{
    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('materi.index', compact('token', 'session'));
    }

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'mata_kuliah_kode' => 'required|string|max:10',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Materi::create([
            'nama' => $request['nama'],
            'deskripsi' => $request['deskripsi'],
            'mata_kuliah_kode' => $request['mata_kuliah_kode'],
        ]);

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function showData()
    {
        $data = Materi::all();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function getData($guid)
    {
        $data = Materi::where('guid', '=', $guid)->first();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'guid' => 'required|string|max:36',
            'deskripsi' => 'required|string',
            'mata_kuliah_kode' => 'required|string|max:10',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $data = Materi::where('guid', '=', $request['guid'])->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        /// UPDATE DATA
        $data->nama = $request['nama'];
        $data->deskripsi = $request['deskripsi'];
        $data->mata_kuliah_kode = $request['mata_kuliah_kode'];
        $data->save();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($guid)
    {
        $data = Materi::where('guid', '=', $guid)->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
