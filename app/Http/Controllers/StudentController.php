<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Student_subject_relationship;
use App\Subjects;
use Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return Student::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validation=Validator::make($request->all(),[
            'name'=>'required',
            'phoneno'=>'required|min:10',
            'address'=>'required',
            'email'=>'required',
            'class_id'=>'required',
            'subject_id'=>'required|exists:subjects,subject_id'
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

        $student = new Student;
        $student->name = $request->name;
        $student->phoneno = $request->phoneno;
        $student->address = $request->address;
        $student->email = $request->email;
        $student->class_id = $request->class_id;
        
        if($student->save()){
            
             $lastInsertedId = $student->id;

                $ssr=new Student_subject_relationship;
                $ssr->student_id=$lastInsertedId;
                $ssr->subject_id=$request->subject_id;
                
                if($ssr->save()){
                    return json_encode([
                                'successful'=>true,
                                'Student Record'=>[
                                    'Name'=> $student->name,
                                    'Phoneno'=> $student->phoneno,
                                    'Address'=> $student->address,
                                    'Email'=> $student->email,
                                    'Class_id'=> $student->class_id,
                                    'Subject_id'=>$ssr->subject_id,
                                ]
                    ]);
                } else {

                    echo 'Studnets save succesfully but Student_subject_relationship table not saved.';
                } 

        } else {
            return json_encode([
                'successful'=>false
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

// JSON API for retriving details of students studying a particular Subject.
    public function show_student_details($id) {
        
        return Student::find($id)->students;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $arr = array('id'=>$id);
        $Validator_id=Validator::make($arr,[
            'id'=>'bail|exists:students,id'
        ]);

        if ($Validator_id->fails()){
            return json_encode(array(
                'success' => false,
                'errors' => $Validator_id->getMessageBag()->toArray(),
            ), 400);
        }

        $inputValidator=Validator::make($request->all(),[
            'name'=>'required|min:1',
            'phoneno'=>'required|min:10',
            'address'=>'required',
            'email'=>'required',
            'class_id'=>'required',
            'subject_id'=>'required|exists:subjects,subject_id'
        ]);

        if ($inputValidator->fails()){
            return json_encode(array(
                'success' => false,
                'errors' => $inputValidator->getMessageBag()->toArray(),
            ), 400);
        } 

        $student=Student::find($id);
        $student->name = $request->name;
        $student->phoneno = $request->phoneno;
        $student->address = $request->address;
        $student->email = $request->email;
        $student->class_id = $request->class_id;

        if($student->save()){
            
                $student_id = $id;
                $ssr=Student_subject_relationship::find($student_id);
                $ssr->subject_id=$request->subject_id;
                
                if($ssr->save()){
                    return json_encode([
                                'successful'=>true,
                                'Student Record'=>[
                                    'name' => $request->name,
                                    'Phoneno'=> $request->phoneno,
                                    'Address'=> $request->address,
                                    'Email'=> $request->email,
                                    'Class_id'=> $request->class_id,
                                    'Subject_id'=>$request->subject_id,
                                ]
                    ]);
                } else {

                    echo 'Studnets save succesfully but Student_subject_relationship table not updated.';
                } 

        } else {
            return json_encode([
                'successful'=>false
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $arr = array('id'=>$id);
        $validation=Validator::make($arr,[
                'id'=>'required|exists:students,id',
                'student_id'=>'exists:student_subject_relationship,student_id'
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

        if (Student::destroy($id)) {

           
           $deletedRows = Student_subject_relationship::where('student_id', $id)
                             ->delete();

           if($deletedRows) {

                return json_encode(array('successful'=>'true'));

            } else {

                echo 'Student_subject_relationship record delete';
            }
        } else {
            echo 'Student table record delete';
        }
    } 
}