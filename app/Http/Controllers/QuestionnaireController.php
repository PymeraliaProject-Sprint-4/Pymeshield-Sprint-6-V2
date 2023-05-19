<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;


class QuestionnaireController extends Controller
{
    public function index()
    {

        $questionnaires = Questionnaire::where('hidden', false)
        ->orWhereNull('hidden')
        ->Paginate(10);
        
        $questionnaire = Questionnaire::all();
        $users = User::all();

        return view('questionnaire.index', compact('questionnaire','questionnaires', 'users'));

    }

    public function hidden()
    {
        $questionnaires = Questionnaire::whereNotNull('hidden')
            ->Paginate(10);

        return view('questionnaire.hidden', compact('questionnaires'));
    }


    public function create()
    {
        $questionnaires = Questionnaire::all();

        return view('questionnaire.create', compact('questionnaires'));
    }


    public function store(Request $request)
    {

        $questionnaire = new Questionnaire();

        $validator = Validator::make($request->all(), [
            'questionnaire_name' => ['required', 'string'],
        ], [
            'questionnaire_name.required' => __('validation.required.name'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $questionnaire->name = $request->questionnaire_name;
        $questionnaire->autor = Auth::user()->name;
        $questionnaire->date = date('Y-m-d');

        $questionnaire->save();


        return response()->json(['id' => $questionnaire->id]);
    }

    public function edit(Questionnaire $questionnaire)
    {

        $questions = Question::all();
        $assigned_questions = $questionnaire->questions;
        $unassigned_questions = $questions->filter(function ($question) use ($assigned_questions) {
            return !$assigned_questions->contains($question);
        });

        //pagina que mostra els detalls de informes
        return view('questionnaire.edit', compact('questionnaire', 'questions', 'unassigned_questions', 'assigned_questions'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'date' => ['required', 'date_format:Y-m-d']
        ]);

        $questionnaire = Questionnaire::find($id);

        $questionnaire->name = $request->name;
        $questionnaire->date = $request->date;
        $questionnaire->update();

        return redirect()->back();
    }

    public function unActivate($id)
    {

        $questionnaire = Questionnaire::find($id);
        $questionnaire->hidden = now();
        $questionnaire->save();

        return redirect()->route('questionnaire.index');
    }

    public function activate($id)
    {

        $questionnaire = Questionnaire::find($id);
        $questionnaire->hidden = null;
        $questionnaire->save();

        return redirect()->route('questionnaire.hidden');
    }


    public function updateQuestion(Request $request, Questionnaire $questionnaire)
    {
        $questionIds = $request->input('id', []);
        foreach ($questionIds as $questionId) {
            $questionnaire->questions()->attach($questionId);
        }

        return redirect()->back();
    }

    public function assignQuestion(Request $request, Questionnaire $questionnaire)
    {

        $questionIds = $request->input('id', []);
        foreach ($questionIds as $questionId) {
            $questionnaire->questions()->attach($questionId);
        }

        return redirect()->back();
    }

    public function unassignQuestion(Request $request, Questionnaire $questionnaire)
    {
        $questionIds = $request->input('id', []);
        foreach ($questionIds as $questionId) {
            $questionnaire->questions()->detach($questionId);
        }

        return redirect()->back();
    }
    function indexmobil (){
        return Questionnaire::all();
    }
    function indexmobilID ($id){
        return Questionnaire::find($id);
    }

    public function allQuestionnaires()
    {
        return Questionnaire::all();
    }
}
