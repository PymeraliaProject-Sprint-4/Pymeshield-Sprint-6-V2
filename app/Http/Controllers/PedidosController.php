<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class PedidosController extends Controller
{
    public function mis_pedidos()
    {
        return view('Pedidos.show');
    }

    public function pedidosFinalizados()
    {
        return view('Pedidos.termino');
    }

    public function newPedido(Request $request)
    {
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $status = $request->status;
        $amount = $request->amount;
        $robotId = $request->robot_id;

        // Insertar los datos en la tabla pedidos
        DB::table('pedidos')->insert([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
            'amount' => $amount,
            'robot_id' => $robotId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Resto de la lógica de la función, si es necesario

        return response()->json(['message' => 'Pedido creado exitosamente']);
    }


    public function allPedidos()
    {
        $user = Auth::user();

        $pedidos = DB::table('pedidos')
            ->join('robots', 'pedidos.robot_id', '=', 'robots.id')
            ->join('users', 'robots.user_id', '=', 'users.id')
            ->where('users.id', $user->id)
            ->where('pedidos.status', 'Corriente') // Agregar esta condición
            ->select('pedidos.*', 'robots.id as robot_id', 'robots.Name_robot')
            ->get();

        return response()->json($pedidos);
    }

    public function allPedidosFinished()
    {
        $user = Auth::user();

        $pedidos = DB::table('pedidos')
            ->join('robots', 'pedidos.robot_id', '=', 'robots.id')
            ->join('users', 'robots.user_id', '=', 'users.id')
            ->where('users.id', $user->id)
            ->where('pedidos.status', 'Terminado') // Agregar esta condición
            ->select('pedidos.*', 'robots.id as robot_id', 'robots.Name_robot')
            ->get();

        return response()->json($pedidos);
    }

    public function statusPedido()
    {
        $pedidos = Pedido::all();

        foreach ($pedidos as $pedido) {
            $startDateTime = new Carbon($pedido->start_time);
            $endDateTime = new Carbon($pedido->end_time);
            $currentDateTime = Carbon::now();

            if ($currentDateTime < $endDateTime) {
                $pedido->status = 'Corriente';
            } else {
                $pedido->status = 'Terminado';
            }

            $pedido->save();
        }

        return response()->json(['message' => 'Status de pedidos actualizado.']);
    }
}
