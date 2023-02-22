<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        if($students->count() > 0){
            return response()->json([
                'status'=> 200,
                'students'=> $students,
            ],200);
        }else{
            return response()->json([
                'status'=> 404,
                'message'=> 'No Record Found',
            ],404);
        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|string|max:191',
            'course'=> 'required|string|max:191',
            'email'=> 'required|email',
            'phone'=> 'required|digits:11',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=> $validator->messages(),
            ],422);
        }else{

            $students = Student::create([
                'name'=> $request->name,
                'course'=> $request->course,
                'email'=> $request->email,
                'phone'=> $request->phone,
            ]);
            if($students){
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Added Add Created Success',
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Student Creadted Faild',
                ],500);
            }


        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student =  Student::find($id);

        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student,
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Student Not Found',
            ],404);
        }




    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {

        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student,
            ],200);
        }else{
            return response()->json([
                'status'=>422,
                'message'=>'Student Not Found',
            ],422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required|string|max:191',
            'course'=> 'required|string|max:191',
            'email'=> 'required|email',
            'phone'=> 'required|digits:11',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=> $validator->messages(),
            ],422);
        }else{

            $student;

            if($student){
                $student->update([
                    'name'=> $request->name,
                    'course'=> $request->course,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                ]);

                return response()->json([
                    'status'=>200,
                    'message'=>'Student Record Updated Success',
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Student Updated Faild',
                ],500);
            }


        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'student'=> "Data Delete Successfully",
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'Student Not Found',
            ],404);
        }
    }
}
