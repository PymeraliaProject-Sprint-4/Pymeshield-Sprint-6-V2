<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Budget;
use Illuminate\Console\View\Components\Error;
use Illuminate\Http\Request;
use App\Models\Task;
use DateTime;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class TaskController extends Controller
{

    /** CONTROLADORES DE VISTAS */

    /**
     * acceptacioTasques
     *
     * Acción que recupera una vista del aplicatiu web
     *
     * @return void
     */
    public function acceptacioTasques()
    {
        return view('Tareas.aceptar_tareas.acceptar-tasques');
    }


    /**
     * kanban
     *
     * Acción que devuelve la vista de la página kanban
     *
     * @return void
     */
    public function kanban()
    {
        return view('Tareas.kanban.kanban');
    }


    /**
     * gantt
     *
     * Acción que devuelve la vista de la página gantt
     *
     * @return void
     */
    public function gantt()
    {
        return view('Tareas.gantt.gantt');
    }



    /**
     * datosTasques
     *
     * Acció que recupera les dades corresponent a un usuari i a un questionari que ha contestat
     *
     * param  mixed $request parametre que passem per a poder canviar de págines
     * @return void
     */
    public function datosTasques(Request $request)
    {
        $filtro = $request->buscador;
        // $filtro = $request->buscador; //variable que filtra
        //$filtro = 'Sapiente';
        $data = DB::table('answers')
            ->select('answers.recommendation', 'impacts.name', 'questions.description', 'answers.id')
            ->join('impacts', 'answers.impact_id', '=', 'impacts.id')
            ->join('questions', 'questions.id', '=', 'answers.question_id')
            ->join('question_questionnaire', 'questions.id', '=', 'question_questionnaire.question_id')
            ->join('questionnaires', 'questionnaires.id', '=', 'question_questionnaire.questionnaire_id')
            ->join('reports', 'reports.questionnaire_id', '=', 'questionnaires.id')
            ->join('answer_report', 'answer_report.answer_id', '=', 'answers.id')
            ->where('reports.id', '=', 4) //El que recoge por get en la url desde un cuestionario
            ->where('answer_report.report_id', '=', 4) //El que recoge por get en la url desde un cuestionario
            // /** filtros para la búsqueda */
            ->where('answers.recommendation', 'LIKE', '%' . $filtro . '%')
            ->orWhere('questions.description', 'LIKE', '%' . $filtro . '%')
            ->where('reports.id', '=', 4) //El que recoge por get en la url desde un cuestionario
            ->where('answer_report.report_id', '=', 4) //El que recoge por get en la url desde un cuestionario
            /** filtros para la búsqueda */
            ->paginate(10);

        return response()->json($data);
    }


    /** CRUD */

    //READ - Leer - Listar
    public function showTasks()
    {
        //$tasques = Task::all(); //muestra todos los registros
        $tasques = Task::paginate(); //pagina

        return view('Tareas.listado_tareas.listado-tareas', compact('tasques'));
    }


    public function search(Request $request)
    {
        $buscado = $request->buscado;
        $data = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('questionnaires', 'questionnaires.id', '=', 'tasks.questionnaire_id')
            ->join('answers', 'answers.id', '=', 'tasks.answer_id')
            ->join('budgets', 'budgets.id', '=', 'tasks.budget_id')
            ->join('impacts', 'impacts.id', '=', 'tasks.impact_id')
            ->select('tasks.id', 'answers.recommendation', 'tasks.questionnaire_id', 'tasks.state', 'users.name', 'tasks.user_id', 'tasks.price', 'tasks.start_date', 'tasks.final_date')->where('answers.recommendation', 'like', '%' . $buscado . '%')->get();
        if ($data == null) {
            return null;
        } else {
            return $data;
        }
        // return Task::all();
    }

    public function allTasks()
    {
        $data = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('questionnaires', 'questionnaires.id', '=', 'tasks.questionnaire_id')
            ->join('answers', 'answers.id', '=', 'tasks.answer_id')
            ->join('budgets', 'budgets.id', '=', 'tasks.budget_id')
            ->join('impacts', 'impacts.id', '=', 'tasks.impact_id')
            ->select('tasks.id', 'answers.recommendation', 'tasks.accepted', 'tasks.questionnaire_id', 'tasks.state', 'users.name', 'tasks.user_id', 'tasks.price', 'tasks.start_date', 'tasks.final_date')->get();
        return $data;
        // return Task::all();
    }
    // Guarda una tarea específica
    public function store(Request $request, Task $idTask)
    {
        # Valida los datos entrantes
        $request->validate([
            'recommendation' => ['required', 'string', 'max:255'],
            'accepted' => ['required'],
            'state' => ['required'],
            'user_id' => ['required', 'integer'],
            'price' => ['numeric'],
            'questionnaire_id' => ['required'],
            'start_date' => [],
            'final_date' => [],
        ]);
        # Almacena la tarea
        $idTask->create([
            'recommendation' => $request->recommendation,
            'accepted' => $request->accepted,
            'state' => $request->state,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'questionnaire_id' => $request->questionnaire_id,
            'start_date' => $request->start_date,
            'final_date' => $request->final_date,
        ]);
    }

    // Aquest mètode permet crear totes les tasques de cop
    public function createTasks(Request $request)
    {
        $budget = new Budget();
        $budget->status = 'Waiting';
        $budget->save();

        $data = $request->all()['data'];
        foreach ($data as $id => $value) {
            echo $id . $value;
            $task = new Task();
            $task->user_id = 1;
            $task->questionnaire_id = 1;
            $task->answer_id = $id;
            $task->budget_id = $budget->id;
            $task->manages = $value;
            $task->impact_id = 1;
            $task->save();
        }
    }

    // Edita una tarea específica
    public function update(Request $request, Task $idTask)
    {
        # Valida los datos entrantes
        $request->validate([
            'recommendation' => ['required', 'string', 'max:255'],
            'accepted' => ['required'],
            'state' => ['required'],
            'user_id' => ['required', 'integer'],
            'price' => ['numeric'],
            'start_date' => ['required'],
            'final_date' => ['required'],
        ]);
        # Actualiza la tarea
        $idTask->update([
            'recommendation' => $request->recommendation,
            'accepted' => $request->accepted,
            'state' => $request->state,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'start_date' => $request->start_date,
            'final_date' => $request->final_date,
        ]);
    }
    // Elimina una tarea específica
    public function destroy(Task $idTask)
    {
        // Elimina la tarea registrada en la base de datos
        $idTask->delete();
    }

    public function asignarPrecios()
    {
        return view('Presupuestos.Asignacion_Precios.AcceptarPresupostos');
    }

    public function mostrarTareas($id)
    {
        $userId = auth()->user()->id; // Aquí anirà la ID de sessió de l'usuari

        $tareas = DB::table('tasks')
            ->select('tasks.*', 'answers.recommendation')
            ->join('answers', 'tasks.answer_id', '=', 'answers.id')
            ->join('budgets', 'tasks.budget_id', '=', 'budgets.id')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->where([
                ['tasks.manages', '=', 'Me aconseja Pymeralia'],
                ['budgets.id', '=', $id],
                ['users.id', '=', $userId]
            ])
            ->paginate(5);


        return $tareas;
    }

    public function tasksKanban()
    {
        $user_id = auth()->user()->id; // Aquí anirà l'ID de sessió de l'usuari

        $tasks = Task::join('answers', 'tasks.answer_id', '=', 'answers.id')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->where('users.id', $user_id)
            ->where('tasks.manages', '=', 'Me aconseja Pymeralia')
            ->orWhere('tasks.manages', '=', 'Me lo gestiono yo')
            ->get(['tasks.*', 'answers.recommendation']);

        foreach ($tasks as $task) {
            $task->start_date = (new DateTime($task->start_date))->format('Y-m-d H:i');
            $task->final_date = (new DateTime($task->final_date))->format('Y-m-d H:i');
        }

        return response()->json($tasks);
    }

    public function updateState($id, Request $request)
    {
        $task = Task::find($id);
        $task->state = $request->state;
        $task->save();
    }
}
