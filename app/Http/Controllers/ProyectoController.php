<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProyectoController extends Controller
{
    // Listar todos los proyectos
    public function index()
    {
        $key = env('TRELLO_KEY');
        $token = env('TRELLO_TOKEN');
        $boardId = env('TRELLO_BOARD_ID');

        // Obtener todas las listas del tablero
        $response = Http::get("https://api.trello.com/1/boards/{$boardId}/lists", [
            'key' => $key,
            'token' => $token,
        ]);

        if ($response->successful()) {
            $listas = $response->json();

            foreach ($listas as &$lista) {
                // Obtener todas las tarjetas de cada lista
                $cardsResponse = Http::get("https://api.trello.com/1/lists/{$lista['id']}/cards", [
                    'key' => $key,
                    'token' => $token,
                ]);

                if ($cardsResponse->successful()) {
                    $cards = $cardsResponse->json();

                    foreach ($cards as &$card) {
                        // Obtener los checklists de cada tarjeta
                        $checklistResponse = Http::get("https://api.trello.com/1/cards/{$card['id']}/checklists", [
                            'key' => $key,
                            'token' => $token,
                        ]);

                        $totalCheckItems = 0;
                        $completedCheckItems = 0;

                        if ($checklistResponse->successful()) {
                            $checklists = $checklistResponse->json();
                            $card['checklists'] = $checklists;

                            // Calcular total y completados
                            foreach ($checklists as $checklist) {
                                $totalCheckItems += count($checklist['checkItems']);
                                foreach ($checklist['checkItems'] as $checkItem) {
                                    if ($checkItem['state'] === 'complete') {
                                        $completedCheckItems++;
                                    }
                                }
                            }
                        } else {
                            $card['checklists'] = [];
                        }

                        // Añadir el total y completados a la tarjeta
                        $card['totalCheckItems'] = $totalCheckItems;
                        $card['completedCheckItems'] = $completedCheckItems;

                        // Obtener la URL de la portada si el idAttachmentCover está disponible
                        if (isset($card['idAttachmentCover'])) {
                            $attachmentResponse = Http::get("https://api.trello.com/1/cards/{$card['id']}/attachments/{$card['idAttachmentCover']}", [
                                'key' => $key,
                                'token' => $token,
                            ]);

                            if ($attachmentResponse->successful()) {
                                $attachment = $attachmentResponse->json();
                                $card['coverUrl'] = $attachment['url']; // URL de la portada
                            } else {
                                $card['coverUrl'] = 'URL_DE_IMAGEN_POR_DEFECTO';
                            }
                        } else {
                            // URL de imagen por defecto si no hay portada
                            $card['coverUrl'] = 'URL_DE_IMAGEN_POR_DEFECTO';
                        }
                    }

                    $lista['cards'] = $cards;
                } else {
                    $lista['cards'] = [];
                }
            }

            return view('proyectos.index', compact('listas'));
        } else {
            return response()->json(['error' => 'No se pudieron obtener las listas de Trello'], 500);
        }
    }

    public function updateChecklists(Request $request)
    {
        DD($request);            
        $checkItems = $request->input('checkItems');
        $cardId = $request->input('cardId'); // Obtener cardId desde el formulario
        
        // Verificar que cardId esté presente
        if (!$cardId) {
            return redirect()->back()->with('error', 'ID de la tarjeta no proporcionado');
        }
        
        // Recorrer los elementos de los checkItems para actualizarlos
        foreach ($checkItems as $checkItemId => $state) {
            // Aquí puedes realizar la actualización del estado del checklist en Trello
            $key = env('TRELLO_KEY');
            $token = env('TRELLO_TOKEN');

            // Actualizar el estado del checkItem
            $response = Http::post("https://api.trello.com/1/cards/{$cardId}/checklistItems/{$checkItemId}", [
                'key' => $key,
                'token' => $token,
                'state' => $state, // 'complete' o 'incomplete'
            ]);
            
            if (!$response->successful()) {
                // Maneja el error si no se pudo actualizar
                return redirect()->back()->with('error', 'No se pudo actualizar el checklist');
            }
        }

        return redirect()->back()->with('success', 'Checklist actualizado correctamente');
    }

    public function updateChecklistItem(Request $request, $cardId, $checkItemId)
    {
        $state = $request->input('state');
        $key = env('TRELLO_KEY');
        $token = env('TRELLO_TOKEN');
    
        $response = Http::put("https://api.trello.com/1/cards/{$cardId}/checkItem/{$checkItemId}", [
            'state' => $state,
            'key' => $key,
            'token' => $token,
        ]);
    
        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Checklist item updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update checklist item'], 500);
        }
    }

    public function probarConexion()
    {
        $key = env('TRELLO_KEY');
        $token = env('TRELLO_TOKEN');

        // Hacer una solicitud a la API para obtener información del usuario
        $response = Http::get("https://api.trello.com/1/members/me", [
            'key' => $key,
            'token' => $token,
        ]);

        if ($response->successful()) {
            // Si la conexión es exitosa, puedes retornar la información del usuario
            return response()->json($response->json());
        } else {
            // Si la conexión falla, retorna un mensaje de error
            return response()->json(['error' => 'No se pudo conectar a la API de Trello'], 500);
        }
    }
}
