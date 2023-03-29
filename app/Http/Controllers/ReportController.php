<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\Report;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        //pagina principal de informes mostra llistat informes (solo sin completar)
        $reports = Report::orderBy('status', 'asc')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $questionnaires = Questionnaire::all();
        $users = User::all();

        return view('report.index', compact('reports', 'questionnaires', 'users'));
    }
    //acció
    public function show($id)
    {
        //pagina que mostra els detalls de informes
        $report = DB::table('reports')
            ->select('answers.id', 'answers.name as answers', 'answers.recommendation as recommendation', 'questions.name as questions', 'type_measures.name as type_measures', 'risks.name as risks', 'probabilities.name as probabilities', 'interventions.name as interventions', 'impacts.name as impacts')
            ->join('answer_report', 'answer_report.report_id', '=', 'reports.id')
            ->join('answers', 'answer_report.answer_id', '=', 'answers.id')
            ->join('impacts', 'impacts.id', '=', 'answers.impact_id')
            ->join('interventions', 'interventions.id', '=', 'answers.intervention_id')
            ->join('probabilities', 'probabilities.id', '=', 'answers.probability_id')
            ->join('questions', 'questions.id', '=', 'answers.question_id')
            ->join('risks', 'risks.id', '=', 'answers.risk_id')
            ->join('type_measures', 'type_measures.id', '=', 'answers.type_measure_id')
            ->where('reports.id', '=', $id)
            ->get();

        return view('report.show', compact('report'));
    }

    public function pdf($id)
    {

        $report = Report::with(['answers', 'answers.impact', 'answers.intervention', 'answers.probability', 'answers.question', 'answers.risk', 'answers.typeMeasure'])
            ->findOrFail($id);

        $pdf = PDF::loadView('report.pdf', compact('report'))->setPaper('legal', 'landscape');
        return $pdf->stream();
    }

    public function store(Request $request)
    {
        // crear un report (desde la vista auditorías)
        $report = new Report();

        // validar datos
        $validated = $request->validate([
            'reportName' => 'required|string|max:50',
            'selectedQuestionnaire' => 'required|integer',
            'selectedUser' => 'required|integer'
        ]);
        $reportName = $validated['reportName'];
        $selectedQuestionnaire = $validated['selectedQuestionnaire'];
        $selectedUser = $validated['selectedUser'];

        $report->name = $reportName;
        $report->questionnaire_id = $selectedQuestionnaire;
        $report->user_id = $selectedUser;
        $report->date = date('Y-m-d');
        $report->status = "pending";

        $report->save();

        return response()->json([
            'redirect' => route('audit.index')
        ]);
    }
    function indexmobil()
    {
        return Report::all();
    }
    function indexmobilID($id)
    {
        return Report::find($id);
    }
}
