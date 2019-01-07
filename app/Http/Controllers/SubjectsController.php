<?php

namespace App\Http\Controllers;
use App\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Validator;
use DB;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Subjects::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'subject_name'=>'required'
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

        $subject = new Subjects;

        $subject->subject_name = $request->subject_name;
        
        if ($subject->save()) {
            return json_encode($subject);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    public function show_students($id)
    {
        return Subjects::find($id)->student;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $validation=Validator::make(array('subject_id'=>$id),[
            'subject_id'=>'required|exists:subjects,subject_id'
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

       $subject = Subjects::find($id);
       $subject->subject_name = $request->subject_name;

        if ($subject->save()) {
            echo json_encode(array(
                'successful'=>true,
                'subject_name'=>$request->subject_name
            ));
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $validation=Validator::make(array('subject_id'=>$id),[
            'subject_id'=>'required|exists:subjects,subject_id'
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

        if (Subjects::destroy($id)) {
            return json_encode(array('successful'=>true));
        }
    }


    public function student_base($id)
    {
        $student = DB::table('subjects')
                      ->join('student_subject_relationship', 'subjects.subject_id', '=', 'student_subject_relationship.subject_id')
                     ->select('subjects.subject_name', 'student_subject_relationship.student_id')
                     ->where('subjects.subject_id', '=', $id)
                     ->get();

         //echo '<pre>'; print_r($student); echo '</pre>';
            $s = array();
            foreach($student as $stu){
                $subject_name = $stu->subject_name;
                $student_id = $stu->student_id;
                $s[] = $stu->student_id;
            }

            $stu_name = DB::table('students')
                            ->whereIn('id', $s)
                            ->get();

            $student_name = array();
            foreach($stu_name as $s_name){
                $student_name[] = $s_name->name;
                 
             }

            return json_encode([
                            'successful'=>true,
                            'Subject Record'=>[
                                'Subject Id'=> $id,
                                'Subject Name'=> $subject_name,
                                'Student_id'=>$s,
                                'student_name' => $student_name
                            ]
                    ]);
    }

}
