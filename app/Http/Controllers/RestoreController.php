<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class RestoreController extends Controller
{

    //Funcio per a llistar
    public function devices(){
        return Device::whereNotNull("hidden")->paginate(5);
    }

    // Funcio per a restaurar, no tenen id, posarem serial_number 
    public function restoreDevice($id){
        $dispositiu = Device::find($id);
        $dateNow = null;
        $dispositiu->hidden = $dateNow;
        $dispositiu->save();
        return redirect()->back();
    }
    public function getIdDevice($id){
        $dispositiu = Device::find($id);
        $dispositiu->save();
        return redirect()->back();
    }
}
