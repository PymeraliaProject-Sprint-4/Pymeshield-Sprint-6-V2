<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Course;
use \Illuminate\Support\Facades\DB;
class ResourceController extends Controller
{
    public function index($id)
    {
        return view('rescource.rescource_client', compact('id'));
    }

    public function RescourceDatos($id)
    {
        // Obtener el nombre del curso
        $course = DB::table('courses')->select('name')->where('id', $id)->first();
    
        // Obtener todas las categorías del curso seleccionado
        $categories = DB::table('categories')->select('id', 'name')->where('course_id', $id)->get();
    
        // Crear el objeto JSON combinando todos los resultados
        $json = [
            'course_name' => $course->name,
            'categories' => [],
        ];
    
        foreach ($categories as $category) {
            $category_json = [
                'category_id' => $category->id,
                'category_name' => $category->name,
                'resources' => [],
            ];
    
            // Obtener los recursos de texto de la categoría
            $resources_texts = DB::table('resource_texts')
                ->select('name as resource_name', 'description as resource_description')
                ->where('category_id', $category->id)
                ->get();
    
            foreach ($resources_texts as $resource) {
                $resource_json = [
                    'resource_type' => 'text',
                    'resource_name' => $resource->resource_name,
                    'resource_description' => $resource->resource_description,
                ];
                $category_json['resources'][] = $resource_json;
            }
    
            // Obtener los recursos de URL de la categoría
            $resources_urls = DB::table('resource_urls')
                ->select('name as resource_name', 'location as resource_location')
                ->where('category_id', $category->id)
                ->get();
    
            foreach ($resources_urls as $resource) {
                $resource_json = [
                    'resource_type' => 'url',
                    'resource_name' => $resource->resource_name,
                    'resource_location' => $resource->resource_location,
                ];
                $category_json['resources'][] = $resource_json;
            }
    
            // Obtener los recursos de archivo de la categoría
            $resources_files = DB::table('resource_files')
                ->select('name as resource_name', 'location as resource_location')
                ->where('category_id', $category->id)
                ->get();
    
            foreach ($resources_files as $resource) {
                $resource_json = [
                    'resource_type' => 'file',
                    'resource_name' => $resource->resource_name,
                    'resource_location' => $resource->resource_location,
                ];
                $category_json['resources'][] = $resource_json;
            }
    
            $json['categories'][] = $category_json;
        }
    
        // Devolver el objeto JSON
        return response()->json($json);
    }


    public function index_admin(){
        return view('rescource.rescource_admin');
    }

    public function index_admin_datos(){

    }
}    
