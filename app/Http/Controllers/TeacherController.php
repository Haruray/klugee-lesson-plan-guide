<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KlugeeClass;
use App\User;
use App\Syllabus;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $id=auth()->user()->id;
        $data=User::find($id)->klugee_classes()->get();
        return view('home',['data'=>$data]);
    }
    public function addClassPage(){
        return view('addclass');
    }
    public function classPage($user_id,$class_id){
        $data=Syllabus::select('topic')->distinct()->get();
        $view=view('plans');
        $class=KlugeeClass::where('id',$class_id)->first();
        $classdata=["user_id"=>$user_id,"class_id"=>$class_id,"class_name"=>$class->class_name,];
        return $view->with('data',$data)->with('classdata',$classdata);
    }
    public function getData($selection,$data,$class_id){
        if ($selection=="lesson"){
            $data=Syllabus::where($selection,$data)->first();
            $id=$data->id;
            $arr['data']=Syllabus::find($id)->lesson_steps()->distinct()->get();
        }
        else if ($selection=="phase"){
            //
        }
        else{
            $arr['data']=Syllabus::where($selection,$data)->distinct()->get();
        }
        echo json_encode($arr);
        exit;
    }
}
