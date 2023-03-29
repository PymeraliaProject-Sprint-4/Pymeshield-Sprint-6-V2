<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\ImageDevice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageDeviceController extends Controller
{

    public function index() {
        return view('images');
    }

    public function mostrar($id_device) {
        //TODO: Això ara retorna les ubicacions. Mostrar-ho s'ha d'encarregar el BLADE.
        $device = Device::find($id_device);
        $files = ImageDevice::select('location')->where('device_id', $id_device)->get();
        return $files;
        //return view('images', compact('files', 'device'));
    }

    public function guardar(Request $request) {

        // Validem que la imatge sigui correcta
        $request->validate([
            'files.*' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Guardem l'arxiu i recuperem la ruta
        $files = $request->file('files');
        //Storage::disk('local')->put('test', $files);

        foreach ($files as $file) {
            $route = $file->store('public/images');

            // Guardem a la base de dades la ruta a aquesta imatge
            ImageDevice::create([
                'location' => 'storage/' . substr($route, 7), // eliminem "public/" de la ruta
                'device_id' => 1
            ]);
        }
    }
}
