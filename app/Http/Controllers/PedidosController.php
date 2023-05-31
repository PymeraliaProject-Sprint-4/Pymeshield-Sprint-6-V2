<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



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
}
