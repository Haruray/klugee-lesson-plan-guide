<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KlugeeClass;
use App\User;
use App\Syllabus;
use App\LessonStep;

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

    private function countStep($step_id){
        //nyari data yg mau diambil
        $data1=LessonStep::where('id',$step_id)->first();
        $syllabus_id=$data1->syllabus_id;
        $phase=$data1->phase;
        $data2=LessonStep::where([['syllabus_id',$syllabus_id],['phase',$phase]])->get();
        for ($i=0;$i<count($data2);$i++){
            if ($data2[$i]['id']==$step_id){
                $return_value=$i;
            }
        }
        return $return_value+1;
    }

    public function stepPage($user_id,$class_id,$step_id){
        $data=LessonStep::where('id',$step_id)->first();
        $lesson_id=$data->syllabus_id;
        $backup=Syllabus::where('id',$lesson_id)->get()->first();
        $view=view('steppage');
        $stepnumber=self::countStep($step_id);
        $data->get();
        $classdata=["user_id"=>$user_id,"class_id"=>$class_id,"stepnumber"=>$stepnumber];
        return $view->with('data',$data)->with('backupdata',$backup)->with('classdata',$classdata);
    }
    public function stepPageNav($user_id,$class_id,$step_id,$where){
        $data=LessonStep::where('id',$step_id)->first();
        $lesson_id=$data->syllabus_id;
        if ($where=='next'){
            $data=LessonStep::where('id','>',$step_id)->first();
        }
        else if($where=='prev'){ 
            $data=LessonStep::where('id','<',$step_id)->orderByDesc('id')->first();
        }
        if ($data==null){
            if ($where=='prev'){
                return redirect('/class'.'/'.$user_id.'/'.$class_id);
            }
            else{
                return redirect('/class'.'/'.$user_id.'/'.$class_id.'/redirect'.'/');
            }
        }
        else if ($lesson_id!=($data->syllabus_id) || $data->syllabus_id==null){
            if ($where=='prev'){
                return redirect('/class'.'/'.$user_id.'/'.$class_id.'/redirect'.'/'.$lesson_id.'/prev');
            }
            else{
                return redirect('/class'.'/'.$user_id.'/'.$class_id.'/redirect'.'/'.$lesson_id.'/next');
            }
        }
        else{
            $new_step_id=$data->id;
            $stepnumber=self::countStep($new_step_id);
            $classdata=["user_id"=>$user_id,"class_id"=>$class_id,"stepnumber"=>$stepnumber];
            $backup=Syllabus::where('id',$lesson_id)->get()->first();
            $view=view('steppage');
            $data->get();
            return $view->with('data',$data)->with('backupdata',$backup)->with('classdata',$classdata);
        }
    }

    public function redirectEnd($user_id,$class_id){
        $data=["user_id"=>$user_id,"class_id"=>$class_id];
        return view('endpage',['data'=>$data]);
    }
    public function redirectPath($user_id,$class_id,$syllabus_id,$where){
        $data=Syllabus::where('id','>',$syllabus_id)->whereNotNull('lesson')->first();
        if ($data==null){
            if ($where=='next'){
                $nextlesson='#';
                $nextlessonstepid=99969; //mark
            }
            else{
                $nextlesson=$syllabus_id;
                $nextlessonstep=Syllabus::find($nextlesson)->lesson_steps()->distinct()->first();
                $nextlessonstepid=$nextlessonstep->id;
            } 
        }
        else{
            if ($where=='next'){
                $nextlesson=$data->id;
                $nextlessonstep=Syllabus::find($nextlesson)->lesson_steps()->distinct()->first();
                $nextlessonstepid=$nextlessonstep->id;
            }
            else{
                $nextlesson=$syllabus_id;
                $nextlessonstep=Syllabus::find($nextlesson)->lesson_steps()->distinct()->first();
                $nextlessonstepid=$nextlessonstep->id;
            }
            
        }
        $data=Syllabus::where('id','<',$syllabus_id)->whereNotNull('lesson')->orderByDesc('id')->first();
        if ($data==null){
            if ($where=='prev'){
                $prevlesson=$syllabus_id;
                $prevlessonstepid=99969; //mark
            }
            else{
                $prevlesson=$syllabus_id;
                $prevlessonstep=Syllabus::find($prevlesson)->lesson_steps()->distinct()->first();
                $prevlessonstepid=$prevlessonstep->id;
            }   
        }
        else{
            if ($where=='prev'){
                $prevlesson=$data->id;
                $prevlessonstep=Syllabus::find($prevlesson)->lesson_steps()->distinct()->first();
                $prevlessonstepid=$prevlessonstep->id;
            }
            else{
                $prevlesson=$syllabus_id;
                $prevlessonstep=Syllabus::find($prevlesson)->lesson_steps()->distinct()->first();
                $prevlessonstepid=$prevlessonstep->id;
            }
        }
        
        $data=["user_id"=>$user_id,"class_id"=>$class_id,"nextlesson"=>$nextlessonstepid,"prevlesson"=>$prevlessonstepid];
        return view('redirectpath',['data'=>$data]);
    }
}
