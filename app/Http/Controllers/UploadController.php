<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


/**
 * Clase que se encarga de manejar el adaptador de subida de imágenes localmente.
 * @package App\Controllers
 */
class UploadController extends Controller
{
    /**
     * Maneja la subida de fotos localmente desde el editor CKEditor.
     *
     * @param Request $request Foto a subir de forma local
     *
     * @return JsonResponse URL en formato JSON del archivo cargado localmente en caso de éxito | JSON con el error en caso de ocurrir algún fallo en la subida del archivo
     *
     * @throws Exception Por si ocurre algún error durante la ejecución
     */
    public function upload(Request $request): JsonResponse
    {
        try {
            // Verificar si se ha enviado un archivo
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                // Dar nombre
                $fileName = time() . '_' . $file->getClientOriginalName();
                // Guardar en storage
                $file->storeAs('public/blog_photos', $fileName);

                // Devuelve la URL del archivo cargado
                return response()->json(['url' => asset('storage/blog_photos/' . $fileName)]);
            } else {
                // Devuelve un mensaje de error si no se encuentra ningún archivo
                session()->flash('error', 'No se encontró ningún archivo para cargar');
                return response()->json(['error' => 'No se encontró ningún archivo para cargar'], 422);
            }
        } catch (Exception $e) {
            session()->flash('error', 'Ocurrió un error al cargar el archivo: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al cargar el archivo'], 500);
        }
    }
}
