<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Syllabus;
use App\LessonStep;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function adminPage()
    {
        return view('admin');
    }
    public function syllabusPage()
    {
        $data=Syllabus::select('topic')->distinct()->get();
        $units=Syllabus::all();
        $view=view('syllabus');
        return $view->with('data',$data)->with('units',$units);
    }
    public function addTopic(Request $request)
    {
        $newdata=new Syllabus;
        $newdata->topic = $request->input('topic');
        $newdata->save();
        return redirect('/admin/syllabus');
    }
    public function unitPage($topic)
    {
        $arr['data']=Syllabus::where('topic',$topic)->distinct()->get();
        echo json_encode($arr);
        exit;
    }
    public function addUnit(Request $request){
        // $newdata= new Syllabus;
        // $newdata->topic=$request->input('topic');
        // $newdata->unit=$request->input('unit');
        // $newdata->save();
        $data=Syllabus::where('topic',$request->input('topic'))->first();
        $data->unit=$request->input('unit');
        $data->save();
        return redirect('/admin/syllabus/');
    }
    public function addLesson(Request $request){
        $data=Syllabus::where([['topic',$request->input('topic')],['unit',$request->input('unit')]])->whereNull('lesson')->first();
        if ($data==null){
            $newdata= new Syllabus;
            $newdata->topic=$request->input('topic');
            $newdata->unit=$request->input('unit');
            $newdata->lesson=$request->input('lesson');
            $newdata->save();
            $topic=$request->input('topic');
            $unit=$request->input('unit');
        }
        else{
            $data->lesson=$request->input('lesson');
            $data->save();
            $topic=$request->input('topic');
            $unit=$request->input('unit');
        }
        return redirect('/admin/syllabus/'.$topic.'/'.$unit);
    }
    public function deleteTopic($topic){
        $data=Syllabus::where('topic',$topic);
        $data->forceDelete();
        return redirect('/admin/syllabus');
    }
    public function deleteUnit($topic,$unit){
        $data=Syllabus::where([
            ['topic',$topic],
            ['unit',$unit]
        ]);
        $data->forceDelete();
        return redirect('/admin/syllabus/');
    }
    public function deleteLesson($id){
        $data=Syllabus::where('id',$id)->first();
        $topic=$data->topic;
        $unit=$data->unit;
        $data=Syllabus::where('id',$id);
        $data->forceDelete();
        return redirect('/admin/syllabus/'.$topic.'/'.$unit);
    }
    public function deleteStep($id){
        $data=LessonStep::where('id',$id)->first();
        $phase=$data->phase;
        $syllabus_id=$data->syllabus_id;
        $data=LessonStep::where('id',$id);
        $data->forceDelete();
        return redirect('/admin/syllabus/'.$syllabus_id.'/'.$phase.'/steps');
    }
    public function stepPhasePage($topic,$unit){
        $data=Syllabus::where([
            ['topic',$topic],
            ['unit',$unit]
        ])->get();
        $phase=['Pre','During','Post'];
        $view=view('stepphase');
        return $view->with('data',$data)->with('phase',$phase);
    }
    public function stepPage($id,$phase){
        $data=Syllabus::where('id',$id)->first();
        $topic=$data->topic;
        $unit=$data->unit;
        $lesson=$data->lesson;
        $steps=Syllabus::find($id)->lesson_steps()->where('phase',strtolower($phase))->get();
        $backupdata=array($topic,$unit,$lesson,strtolower($phase));
        $view=view('step');
        return $view->with('data',$steps)->with('backup',$backupdata);
    }
    public function addStep(Request $request){
        $topic=$request->input('topic');
        $unit=$request->input('unit');
        $lesson=$request->input('lesson');
        $phase=$request->input('phase');
        $newstep = new LessonStep;
        $newstep->syllabus_id=Syllabus::where([['topic',$topic],['unit',$unit],['lesson',$lesson]])->first()->id;
        $newstep->phase=$phase;
        $newstep->step=$request->input('step');
        $newstep->save();
        return redirect('/admin/syllabus/'.$newstep->syllabus_id.'/'.$phase.'/steps');
    }
}
