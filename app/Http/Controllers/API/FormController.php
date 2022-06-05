<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
class FormController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Ini halaman create data'
        ], 200);
    }
    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);

        $student = new Student;
        $student->nama = $request->nama;
        $student->alamat = $request->alamat;
        $student->no_telp = $request->no_telp;
        $student->save();

        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'data' => $student
        ], 200);
    }

    public function edit($id)
    {
        $student = Student::with('score')->find($id);
        $studentCollection = new StudentResource($student);
        return response()->json([
            'message' => 'success',
            'data' => $studentCollection
        ], 200);
    }

    public function update(Request $request,$id)
    {
        $student = Student::find($id);
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);

        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);


        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => $student
        ], 200);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'data' => $student
        ], 200);
    }


    public function show(Request $request)
    {
        $perPage =$request->get('per_page');
        $students = Student::paginate($perPage);

        $collectionStudent = StudentResource::collection($students);
        // foreach ($students as $key => $student) {
        //     $data['id'] = $student->id;
        //     $data['nama'] = $student->nama;
        //     $data['alamat'] = $student->alamat;
        //     $data['no_telp'] = $student->no_telp;
        //     $datas[] = $data;
        // }

        // $dataStudent['data'] = $datas;
        // $dataStudent['next_page_url'] = $students->nextPageUrl();

        return response()->json([
            'message' => 'success',
            'data' => $collectionStudent
        ], 200);
    }
}
