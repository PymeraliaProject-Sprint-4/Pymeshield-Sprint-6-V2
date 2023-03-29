<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\ImageDevice;
use App\Models\TypeDevice;
use Carbon\Carbon;

class DevicesController extends Controller
{
    //Funcio per a llistar
    public function devices(){
        return Device::where('hidden', '=', null)
        ->join('type_devices','devices.type_device_id','=','type_devices.id')
        ->select('devices.*','type_devices.name')
        ->orderBy('devices.id','asc')->paginate(5);
    }

    //Funcio per a mostrar fotos
    public function show($id_device) {
        $device = Device::find($id_device);
        $files = ImageDevice::select('location')->where('device_id', $id_device)->get();
        return view('images', compact('files', 'device'));
    }

    //Funcio per a crer dispositiu, mitjançant les dades que enviem des del modal.
    public function create(Request $request){
        $device = new Device;
        $device->brand = $request->brand;
        $device->model = $request->model;
        $device->mac_ethernet = $request->mac_ethernet;
        $device->mac_wifi = $request->mac_wifi;
        $device->type_device_id = $request->type_device_id;
        $device->description = $request->description;
        $device->state = $request->state;
        $device->serial_number = $request->serial_number;
        $device->save();
    }

    //Funcio per a modificar dispositiu, recuperem informacio dels inputs del modal i fer update
    public function edit(Request $request){
        $device = Device::find($request->id);
        $device->brand = $request->brand;
        $device->model = $request->model;
        $device->mac_ethernet = $request->mac_ethernet;
        $device->mac_wifi = $request->mac_wifi;
        $device->description = $request->description;
        $device->state = $request->state;
        $device->serial_number = $request->serial_number;
        $device->type_device_id = $request->type_device_id;
        $device->save();
    }

    //acció per a eliminar dispositiu, assigna un valor a hidden és la data en el moment que és clica el boto
    public function delete(Request $request){
        $device = Device::find($request->id);
        $dateNow = Carbon::now();
        $device->hidden = $dateNow;
        $device->save();
    }

    public function type_devices(){
        $types = TypeDevice::all();
        return $types;
    }
}
