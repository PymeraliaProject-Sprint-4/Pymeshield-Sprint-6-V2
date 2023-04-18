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

        // Obtener los recursos de cada categoría (texto)
        $resources_texts = DB::table('resource_texts')
            ->join('categories', 'resource_texts.category_id', '=', 'categories.id')
            ->select('categories.id as category_id', 'resource_texts.name as resource_name', 'resource_texts.description')
            ->where('categories.course_id', $id)
            ->get();

        // Obtener los recursos de cada categoría (url)
        $resources_urls = DB::table('resource_urls')
            ->join('categories', 'resource_urls.category_id', '=', 'categories.id')
            ->select('categories.id as category_id', 'resource_urls.name as resource_name', 'resource_urls.location')
            ->where('categories.course_id', $id)
            ->get();

        // Obtener los recursos de cada categoría (archivo)
        $resources_files = DB::table('resource_files')
            ->join('categories', 'resource_files.category_id', '=', 'categories.id')
            ->select('categories.id as category_id', 'resource_files.name as resource_name', 'resource_files.location')
            ->where('categories.course_id', $id)
            ->get();

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

            foreach ($resources_texts as $resource) {
                if ($resource->category_id == $category->id) {
                    $resource_json = [
                        'resource_text_name' => $resource->resource_name,
                        'description_rescource_text' => $resource->description,
                    ];
                    $category_json['resources'][] = $resource_json;
                }
            }

            foreach ($resources_urls as $resource) {
                if ($resource->category_id == $category->id) {
                    $resource_json = [
                        'resource_url_name' => $resource->resource_name,
                        'rescource_url_location' => $resource->location,
                    ];
                    $category_json['resources'][] = $resource_json;
                }
            }

            foreach ($resources_files as $resource) {
                if ($resource->category_id == $category->id) {
                    $resource_json = [
                        'resource_file_name' => $resource->resource_name,
                        'rescource_file_location' => $resource->location,
                    ];
                    $category_json['resources'][] = $resource_json;
                }
            }

            $json['categories'][] = $category_json;
        }

        // Devolver el objeto JSON
        return response()->json($json);
    }
}
