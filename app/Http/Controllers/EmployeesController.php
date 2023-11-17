<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Employees;

class EmployeesController extends Controller
{
    //membuat method index
    public function index()
    {
        //mengambil data dari tabel employees
        $employees = Employees::all();
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Data is Empty',
                'data' => []
            ];
            return response()->json($data, 204);
        }
        //mengirim data ke view employees
        $data = [
            'message' => 'Get All Resource',
            'data' => $employees
        ];
        // kirim Data dan response code
        return response()->json($data, 200);
    }

    //membuat method show
    public function show($id)
    {
        //mengambil data dari tabel employees
        $employees = Employees::find($id);
        if (is_null($employees)) {
            $data = [
                'message' => 'Resource Not Found',
                'data' => []
            ];
            return response()->json($data, 404);
        }
        //mengirim data ke view employees
        $data = [
            'message' => 'Get Resource By ID',
            'data' => $employees
        ];
        // kirim Data dan response code
        return response()->json($data, 200);
    }

    //membuat method store
    public function store(Request $request)
    {
        //validasi data yang diinputkan
        $this->validate($request, [
            'name' => 'required|min:3|max:65',
            'gender' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'email' => 'required|unique:employees|email',
            'status' => 'required|numeric',
            'hired_on' => 'required|date'
        ]);

        $input = [
            'name' => $request->name,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'status' => $request->status,
            'hired_on' => $request->hired_on
        ];

        // insert data ke database
        $employees = Employees::create($input);

        // buat response data
        $data = [
            'message' => 'Resource Created',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 201);
    }

    // membuat method update
    public function update(Request $request, $id)
    {
        // cari resource berdasarkan id
        $employees = Employees::find($id);
        if (is_null($employees)) {
            $data = [
                'message' => 'Resource Not Found',
                'data' => []
            ];
            return response()->json($data, 404);
        }

        $employees->update([
            'name' => $request->name ? $request->name : $employees->name,
            'gender' => $request->gender ? $request->gender : $employees->gender,
            'phone' => $request->phone ? $request->phone : $employees->phone,
            'address' => $request->address ? $request->address : $employees->address,
            'email' => $request->email ? $request->email : $employees->email,
            'status' => $request->status ? $request->status : $employees->status,
            'hired_on' => $request->hired_on ? $request->hired_on : $employees->hired_on
        ]);
        // buat response data
        $data = [
            'message' => 'Resource Updated',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 200);
    }
    // membuat method destroy
    public function destroy($id)
    {
        // cari resource berdasarkan id
        $employees = Employees::find($id);
        if (is_null($employees)) {
            $data = [
                'message' => 'Resource Not Found',
                'data' => []
            ];
            return response()->json($data, 404);
        }
        // hapus resource
        $employees->delete();
        // buat response data
        $data = [
            'message' => 'Resource Deleted',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 200);
    }
}
