<?php

namespace App\Http\Controllers\API;

use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScoreController extends Controller
{
    public function create(Request $request)
    {

        $student = new Student;
        $student->nama = $request->nama;
        $student->alamat = $request->alamat;
        $student->no_telp = $request->no_telp;
        $student->save();

            foreach($request->list_pelajaran as $pelajaran){
                $score = array(
                    'mapel' => $pelajaran['mapel'],
                    'nilai' => $pelajaran['nilai'],
                    'student_id' => $student->id
                );
                $scores = Score::create($score);
            }
            return response()->json([
                'message' => 'Data berhasil ditambahkan'
            ],200);
    }

    public function getStudent($id)
    {
        $student = Student::with('score')->where('id',$id)->first();
        return response()->json([
            'student' => $student,

        ],200);
    }

    public function update(Request $request,$id)
    {
        $student = Student::find($id);
        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);

        Score::where('student_id',$id)->delete();
        foreach($request->list_pelajaran as $pelajaran){
            $score = array(
                'mapel' => $pelajaran['mapel'],
                'nilai' => $pelajaran['nilai'],
                'student_id' => $id
            );
            $scores = Score::create($score);
        }
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ],200);
    }
}
