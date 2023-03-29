<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Impact;
use App\Models\Intervention;
use App\Models\Probability;
use App\Models\Risk;
use App\Models\TypeMeasure;
use Illuminate\Http\Request;
use Mockery\Matcher\Type;

class QuestionController extends Controller
{
    public function index()
    {
        //pagina principal de informes mostra llistat informes
        $questions = Question::where('hidden', false)
            ->orderBy('id', 'desc')
            ->orWhereNull('hidden')
            ->Paginate(10);

        return view('question.index', compact('questions'));
    }

    public function hidden()
    {
        //pagina principal de informes mostra llistat informes

        $questions = Question::whereNotNull('hidden')->Paginate(10);

        return view('question.hidden', compact('questions'));
    }
    //acció

    public function create()
    {
        $risks = Risk::all();
        $interventions = Intervention::all();
        $type_measures = TypeMeasure::all();
        $probabilities = Probability::all();
        $impacts = Impact::all();



        return view('question.create', compact('risks', 'interventions', 'type_measures', 'probabilities', 'impacts'));
    }


    public function store(Request $request)
    {
        //crear preguntes

        $question = new Question();

        $question->name = $request->name;

        $question->description = $request->description;

        $question->save();

        $lastInsertedRecord = Question::orderBy('id', 'desc')->first();
        $lastId = $lastInsertedRecord->id;


        $answer = new Answer();

        $answer->name = 'Si';


        $answer->recommendation = $request->recommendation_true;

        $answer->risk_id = $request->risk_true;

        $answer->intervention_id = $request->intervention_true;

        $answer->type_measure_id = $request->measure_true;

        $answer->probability_id = $request->probability_true;

        $answer->impact_id = $request->impact_true;

        $answer->question_id = $lastId;

        $answer->save();


        $answer2 = new Answer();

        $answer2->name = 'No';

        $answer2->recommendation = $request->recommendation_false;

        $answer2->risk_id = $request->risk_false;

        $answer2->intervention_id = $request->intervention_false;

        $answer2->type_measure_id = $request->measure_false;

        $answer2->probability_id = $request->probability_false;

        $answer2->impact_id = $request->impact_false;

        $answer2->question_id = $lastId;

        $answer2->save();

        return response()->json(['id' => $question->id]);
    }

    public function edit(Question $question)
    {
        $answers = Answer::where('question_id', $question->id)->get();

        $risks = Risk::all();
        $types  = TypeMeasure::all();
        $interventions = Intervention::all();
        $probabilities = Probability::all();
        $impacts = Impact::all();

        $risk = $risks->find($answers[0]->risk_id);
        $type = $types->find($answers[0]->type_measure_id);
        $intervention = $interventions->find($answers[0]->intervention_id);
        $probability = $probabilities->find($answers[0]->probability_id);
        $impact = $impacts->find($answers[0]->impact_id);

        // $question2 = Question::find($id);
        // $question2->answers()[0];



        $risk1 = null;
        $type1 = null;
        $intervention1 = null;
        $probability1 = null;
        $impact1 = null;

        if ($answers->count() > 1) {
            $risk1 = $risks->find($answers[1]->risk_id);
            $type1 = $types->find($answers[1]->type_measure_id);
            $intervention1 = $interventions->find($answers[1]->intervention_id);
            $probability1 = $probabilities->find($answers[1]->probability_id);
            $impact1 = $impacts->find($answers[1]->impact_id);
        }

        return view('question.edit', compact('question', 'answers', 'risks', 'risk', 'risk1', 'types', 'type', 'type1', 'interventions', 'intervention', 'intervention1', 'probabilities', 'probability', 'probability1', 'impacts', 'impact', 'impact1'));
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        $question->name = $request->name;
        $question->description = $request->description;
        $question->update();

        // $answer = Answer::where('id', $question->id)->get();

        $answers = Answer::where('question_id', $question->id)->get();


        $answer_count = 1;
        foreach ($answers as $answer) {
            if ($answer_count == 1) {
                $answer->name = $request->answer_name_true;
                $answer->recommendation = $request->reco_true;
                $answer->risk_id = $request->risk_true;
                $answer->type_measure_id = $request->type_true;
                $answer->intervention_id = $request->inter_true;
                $answer->probability_id = $request->prob_true;
                $answer->impact_id = $request->imp_true;
            } else {
                $answer->name = $request->answer_name_false;
                $answer->recommendation = $request->reco_false;
                $answer->risk_id = $request->risk_false;
                $answer->type_measure_id = $request->type_false;
                $answer->intervention_id = $request->inter_false;
                $answer->probability_id = $request->prob_false;
                $answer->impact_id = $request->imp_false;
            }
            $answer->update();
            $answer_count++;
        }

        return redirect()->route('question.index');
    }

    public function unActivate($id)
    {

        $question = Question::find($id);
        $question->hidden = now();
        $question->save();

        return redirect()->route('question.index');
    }

    public function activate($id)
    {

        $question = Question::find($id);
        $question->hidden = null;
        $question->save();

        return redirect()->route('question.hidden');
    }
    function indexmobil (){
        return Question::all();
    }
    function indexmobilID ($id){
        return Question::find($id);
    }

}
