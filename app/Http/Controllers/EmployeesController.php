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
            return response()->json($data, 200);
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
            'message' => 'Get Detail Resource',
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
            'message' => 'Resource is added successfully',
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
            'message' => 'Resource is Update successfully',
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
            'message' => 'Resource is Delete successfully',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 200);
    }

    // membuat method search berdasarkkan name
    public function search(Request $request)
    {
        // cari resource berdasarkan name
        $employees = Employees::where('name', 'like', '%' . $request->name . '%')->get();
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource Not Found',
                'data' => []
            ];
            return response()->json($data, 404);
        }
        // buat response data
        $data = [
            'message' => 'Resource not found',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 200);
    }

    // mendapatkan resource yang aktif  
    public function active()
    {
        // cari resource berdasarkan status
        $employees = Employees::where('status', 1)->get();
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource Not Found',
                'data' => []
            ];
            return response()->json($data, 404);
        }
        // buat response data
        $data = [
            'message' => 'Get Active resource',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 200);
    }

    // mendapatkan resource yang tidak aktif
    public function inactive()
    {
        // cari resource berdasarkan status
        $employees = Employees::where('status', 0)->get();
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource Not Found',
                'data' => []
            ];
            return response()->json($data, 404);
        }
        // buat response data
        $data = [
            'message' => 'Get inactive Resource',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 200);
    }

    // mendapatkan resource yang di hentikan
    public function terminated()
    {
        // cari resource berdasarkan status
        $employees = Employees::where('status', 2)->get();
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource Not Found',
                'data' => []
            ];
            return response()->json($data, 404);
        }
        // buat response data
        $data = [
            'message' => 'Get terminated resource',
            'data' => $employees
        ];
        // Kirim Response Code
        return response()->json($data, 200);
    }
}
