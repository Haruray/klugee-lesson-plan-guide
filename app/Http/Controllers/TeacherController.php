<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\KlugeeClass;
use App\User;
use App\Syllabus;
use App\LessonStep;
use App\classmember;
use App\ClassProgress;

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
    public function addClass(Request $request){
        $newdata=new KlugeeClass;
        $newdata->class_name=$request->input('class');
        $newdata->user_id=Auth::id();
        $newdata->save();
        $class_id=KlugeeClass::where([['class_name',$request->input('class')],['user_id',Auth::id()]])->first()['id'];
        $data=classmember::where('klugee_class_id',$class_id);
        return redirect('/'.'class/'.Auth::id().'/'.$class_id.'/info');
    }
    public function classInfoPage($user_id,$class_id){
        $data1=KlugeeClass::where('id',$class_id)->first();
        $data2=classmember::where('klugee_class_id',$data1['id'])->get();
        $view=view('classinfo');
        return $view->with('data1',$data1)->with('data2',$data2);
    }
    public function addClassMember(Request $request){
        $newdata=new classmember;
        $newdata->klugee_class_id=$request->input('class_id');
        $newdata->name=$request->input('classmember');
        $newdata->save();
        return redirect('/'.'class/'.Auth::id().'/'.$request->input('class_id').'/info');
    }
    
    public function classDelete($user_id,$class_id){
        $data=KlugeeClass::where([['id',$class_id],['user_id',$user_id]]);
        $data->forceDelete();
        return redirect('/home');
    }

    public function classMemberDelete($user_id,$class_id,$member_id){
        $data=classmember::where([['klugee_class_id',$class_id],['id',$member_id]]);
        $data->forceDelete();
        return redirect('/'.'class/'.$user_id.'/'.$class_id.'/info');
    }

    public function classPage($user_id,$class_id){
        $data=Syllabus::select('id','topic')->distinct()->groupBy('id','topic')->get();
        //taking the unique value
        //first value as default
        $newdata = [new \stdClass,new class{},(object)[],];
        $newdata[0]->id=$data[0]->id;
        $newdata[0]->topic=$data[0]->topic;
        $i=0;
        foreach ($data as $d){
            if ($d->topic!=$newdata[$i]->topic){
                $i++;
                $newdata[$i]->id=$d->id;
                $newdata[$i]->topic=$d->topic;
            }
        }
        $view=view('plans');
        $class=KlugeeClass::where('id',$class_id)->first();
        $classdata=["user_id"=>$user_id,"class_id"=>$class_id,"class_name"=>$class->class_name,];
        return $view->with('data',$newdata)->with('classdata',$classdata);
    }
    public function getData($selection,$data,$class_id){
        if ($selection=="lesson"){
            $data=Syllabus::where($selection,$data)->first();
            $id=$data->id;
            $arr['data']=LessonStep::where('syllabus_id',$id)->distinct()->get();
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
    public function justtesting($selection,$data,$class_id){
        if ($selection=="lesson"){
            $data=Syllabus::where($selection,$data)->first();
            $id=$data->id;
            $arr['data']=LessonStep::where('syllabus_id',$id)->distinct()->get();
        }
        else if ($selection=="phase"){
            //
        }
        else{
            $arr['data']=Syllabus::where($selection,$data)->distinct()->get();
        }
        return $arr['data'];
        
    }
    public function getDataBack($selection,$data,$class_id){
        if ($selection=="topic"){
            $arr['data']=Syllabus::select('topic')->distinct()->get();
            echo json_encode($arr);
            exit;
        }
        else if ($selection=="unit"){
            $target="topic";
            $targetdata=Syllabus::where($selection,$data)->whereNotNull('lesson')->first()['topic'];
        }
        else if ($selection=="lesson"){
            $target="unit";
            $targetdata=Syllabus::where($selection,$data)->whereNotNull('lesson')->first()['unit'];
        }
        $arr['data']=Syllabus::where($target,$targetdata)->whereNotNull('lesson')->distinct()->get();
        echo json_encode($arr);
        exit;
    }

    public function getClassName($class_id){
        $arr['data']=KlugeeClass::where('id',$class_id)->first();
        echo json_encode($arr);
        exit;
    }

    public function getCompletionData($class_id,$selection,$selection_id=0){
        $data['progress']=ClassProgress::where('klugee_class_id',$class_id)->get();
        $data['steps']=LessonStep::get();
        if ($selection=="unit" || $selection=="lesson"){
            $data['syllabus']=Syllabus::get();
        }
        echo json_encode($data);
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

    private function isStepDone($step_id,$class_id){
        $data=ClassProgress::where([['lesson_step_id',$step_id],['klugee_class_id',$class_id]])->first();
        if ($data==null){
            return false;
        }
        else{
            return true;
        }
    }
    public function stepPage($user_id,$class_id,$step_id){
        $data=LessonStep::where('id',$step_id)->first();
        $lesson_id=$data->syllabus_id;
        $backup=Syllabus::where('id',$lesson_id)->get()->first();
        $view=view('steppage');
        $stepnumber=self::countStep($step_id);
        $data->get();
        $isstepdone = self::isStepDone($step_id,$class_id);
        $classdata=["user_id"=>$user_id,"class_id"=>$class_id,"stepnumber"=>$stepnumber,"isstepdone"=>$isstepdone];
        return $view->with('data',$data)->with('backupdata',$backup)->with('classdata',$classdata);
    }
    public function stepPageNav($user_id,$class_id,$step_id,$where){
        $data=LessonStep::where('id',$step_id)->first();
        $lesson_id=$data->syllabus_id;
        $supportdata=Syllabus::where('id',$lesson_id)->whereNotNull('lesson')->first();
        $topic=$supportdata->topic;
        $unit=$supportdata->unit;
        //main data
        $data=LessonStep::where('syllabus_id',$lesson_id)->orderByRaw('FIELD(phase,"pre","during","post")')->get();
        $desiredIndex=$data->search(function($somedata,$key) use($step_id){   
            if ($somedata->id==$step_id){
                return $key;
            };
        });
        if ($where=='next'){
            $searchProgress= ClassProgress::where([['lesson_step_id',$step_id],['klugee_class_id',$class_id]])->first();
            if ($searchProgress==null){
                $progressData=new ClassProgress;
                $progressData->klugee_class_id = $class_id;
                $progressData->lesson_step_id = $step_id;
                $progressData->progress = 1;
                $progressData->save();
            }
            $collect= collect($data)->slice($desiredIndex+1);
            $data=$collect->first();
        }
        else if($where=='prev'){ 
            // $data=LessonStep::where('id','<',$step_id)->orderByDesc('id')->first();
            //jaga-jaga
            // if ($data==null){
            //     $syllabus=Syllabus::where([['id','<',$lesson_id],['topic',$data->topic],['unit',$data->unit]])->whereNotNull('lesson')->orderByDesc('id')->first();
            //     $new_syllabus_id=$syllabus->id;
            //     $data=LessonStep::where('syllabus_id',$lesson_id)->orderByRaw('FIELD(phase,"pre","during","post")')->first();
            // }
            $collect= collect($data)->slice(0,$desiredIndex);
            $data=$collect->reverse()->first();
        }
        if ($data==null){
            if ($where=='prev'){
                return redirect('/class'.'/'.$user_id.'/'.$class_id.'/redirect'.'/'.$lesson_id.'/prev');
            }
            else{
                return redirect('/class'.'/'.$user_id.'/'.$class_id.'/redirect'.'/'.$lesson_id.'/next');
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
            $isstepdone = self::isStepDone($new_step_id,$class_id);
            $classdata=["user_id"=>$user_id,"class_id"=>$class_id,"stepnumber"=>$stepnumber,"isstepdone"=>$isstepdone];
            $backup=Syllabus::where('id',$lesson_id)->get()->first();
            $view=view('steppage');
            $data->get();
            return $view->with('data',$data)->with('backupdata',$backup)->with('classdata',$classdata);
        }
    }

    public function redirectEnd($user_id,$class_id,$syllabus_id){
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
