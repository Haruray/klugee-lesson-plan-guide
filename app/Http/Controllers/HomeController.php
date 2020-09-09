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
        $arr['data']=Syllabus::where('topic',$topic)->get();
        echo json_encode($arr);
        exit;
    }
    public function addUnit(Request $request){
        $newdata= new Syllabus;
        $newdata->topic=$request->input('topic');
        $newdata->unit=$request->input('unit');
        $newdata->save();
        $topic=$request->input('topic');
        return redirect('/admin/syllabus/'.$topic);
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
        return redirect('/admin/syllabus/'.$topic);
    }
    public function stepPhasePage($topic,$unit){
        $data=Syllabus::where([
            ['topic',$topic],
            ['unit',$unit]
        ])->first();
        $phase=['Pre','During','Post'];
        $view=view('stepphase');
        return $view->with('data',$data)->with('phase',$phase);
    }
    public function stepPage($topic,$unit,$phase){
        $data=Syllabus::where([
            ['topic',$topic],
            ['unit',$unit]
        ])->first();
        $id=$data->id;
        $steps=Syllabus::find($id)->lesson_steps()->where('phase',strtolower($phase))->get();
        $backupdata=array($topic,$unit,strtolower($phase));
        $view=view('step');
        return $view->with('data',$steps)->with('backup',$backupdata);
    }
    public function addStep(Request $request){
        $topic=$request->input('topic');
        $unit=$request->input('unit');
        $phase=$request->input('phase');
        $newstep = new LessonStep;
        $newstep->syllabus_id=Syllabus::where([['topic',$topic],['unit',$unit]])->first()->id;
        $newstep->phase=$phase;
        $newstep->step=$request->input('step');
        $newstep->save();
        return redirect('/admin/syllabus/'.$topic.'/'.$unit.'/'.$phase);
    }
}
