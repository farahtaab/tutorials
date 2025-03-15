<?php

namespace App\Http\Controllers;

use App\Models\Ifixit;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GuideController extends Controller
{
    /**
     * Muestra una lista de guías desde Ifixit.
     */
    public function index()
    {
        // Paginamos los resultados (10 guías por página)
        $guides = Ifixit::paginate(10); // Puedes ajustar el número 10 a lo que desees
    
        if ($guides->isEmpty()) {
            return view('guides.index')->with('message', 'No hi ha guies disponibles.');
        }
    
        return view('guides.index', compact('guides'));
    }
    

    public function show($id)
{
    $guide = Ifixit::where('guide_id', $id)->firstOrFail();
    $tr = new GoogleTranslate('ca');

    // Traducir dinámicamente
    $guide->title = $tr->translate($guide->title);
    $guide->summary = $tr->translate($guide->summary);

    // Traducir los pasos
    $translated_steps = [];
    foreach ($guide->steps as $step) {
        $translated_steps[] = [
            'title' => $tr->translate($step['title']),
            'text' => $tr->translate($step['text']),
            'image' => $step['image'], // Asegúrate de que la imagen esté correctamente definida
        ];
    }
    $guide->steps = $translated_steps;

    return view('guides.show', compact('guide'));
}

}
