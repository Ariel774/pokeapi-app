<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function index()
    {
        return view('pokemon.index'); // Redireccionamos hacia nuestra vista
    }
    
    public function search(Request $request) // Función para guardar las búsquedas y traducir las habilidades
    {
        $request->validate(['pokemonName' => 'required|string']);
        $pokemon_name = strtolower(trim($request->input('pokemonName')));
    
        // Realizar la búsqueda en la API de Pokémon
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$pokemon_name}");
    
        if ($response->successful()) {
            $data = $response->json();
            
            // Mapear las habilidades y traducirlas al español
            $abilities = collect($data['abilities'])->map(function($ability) {
                $ability_url = $ability['ability']['url'];
                // Obtener la traducción al español para cada habilidad
                $ability_response = Http::get($ability_url);
                if ($ability_response->successful()) {
                    $ability_data = $ability_response->json();
                    // Buscar el nombre en español
                    $spanish_ability = collect($ability_data['names'])->firstWhere('language.name', 'es');
                    // Devolver el nombre en español si existe, de lo contrario, devolver el nombre original
                    return $spanish_ability ? $spanish_ability['name'] : $ability['ability']['name'];
                }
                // Si falla la llamada a la API, devolver el nombre original de la habilidad
                return $ability['ability']['name'];
            })->toArray();
    
            // Guardar la búsqueda en la base de datos
            Search::create([
                'pokemon_name' => $pokemon_name,
                'result' => json_encode($abilities), // Guardar las habilidades traducidas como JSON
                'session_id' => session()->getId(),
            ]);
    
            return response()->json(['abilities' => $abilities]); // Devolver las habilidades traducidas al frontend
        } else {
            return response()->json(['error' => 'Pokémon no encontrado'], 404);
        }
    }

    public function getSearches() // Función para obtener las últimas busquedas
    {
        $sessionId = session()->getId(); // Obtenemos el id de la sesión
        $searches = Search::where('session_id', $sessionId) // Buscamos por id de sesión
            ->orderBy('created_at', 'desc')
            ->take(10) // Tomamos los 10 últimos registros
            ->get(['id', 'pokemon_name', 'result']);

        return response()->json($searches); // Devolvemos las búsquedas en formato JSON
    }

    public function repeatSearch($id)
    {
        $search = Search::findOrFail($id);
        $abilities = json_decode($search->result, true); // Decodificar las habilidades desde JSON
        return response()->json(['abilities' => $abilities]); // Devolver las habilidades al frontend
    }
}
