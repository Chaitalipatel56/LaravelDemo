<?php

namespace App\Http\Controllers;
use App\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Classes::all());
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
            'class_name'=>'required',
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

        $class = new Classes;
        $class->class_name = $request->class_name;
        
        if($class->save()){
            return json_encode($class);
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
    public function update(Request $request,$id)
    {

        $validation=Validator::make(array('class_id'=>$id),[
            'class_id'=>'required|exists:classes,class_id'
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

       $class = Classes::find($id);
       $class->class_name = $request->class_name;

        if ($class->save()) {
            echo json_encode(array(
                'successful'=>true,
                'class_name'=>$request->class_name
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
        $validation=Validator::make(array('class_id'=>$id),[
            'class_id'=>'required|exists:classes,class_id'
        ]);

        if ($validation->fails()) {
            return json_encode([
                'successful'=>false,
                'errors'=>$validation->getMessageBag()->toArray()
            ],400);
        }

        if (Classes::destroy($id)) {
            return json_encode(array('successful'=>true));
        }

    }
}
