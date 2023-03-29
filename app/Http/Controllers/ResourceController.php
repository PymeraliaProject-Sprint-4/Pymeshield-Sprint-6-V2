<?php

namespace App\Http\Controllers;
use App\Models\ResourceURL;
use App\Models\ResourceText;
use App\Models\ResourceFile;
use App\Models\Category;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        $resourceURL = ResourceURL::orderBy('category_id')->get();
        $resourceFile = ResourceFile::orderBy('category_id')->get();
        $resourceText = ResourceText::orderBy('category_id')->get();
        $category = Category::all();
    
        $resourcesByCategory = $category->mapWithKeys(function ($category) use ($resourceFile, $resourceText, $resourceURL) {
            $resources = $resourceFile->filter(function ($resource) use ($category) {
                return $resource->category_id == $category->id;
            })
            ->concat($resourceText->filter(function ($resource) use ($category) {
                return $resource->category_id == $category->id;
            }))
            ->concat($resourceURL->filter(function ($resource) use ($category) {
                return $resource->category_id == $category->id;
            }));
    
            return [$category->name => $resources->map(function ($resource) {
                return ['name' => $resource->name, 'location' => $resource->location, 'resource' => $resource];
            })];
        });
    
        return view('recursos', compact('resourcesByCategory'));
    }
    
}
