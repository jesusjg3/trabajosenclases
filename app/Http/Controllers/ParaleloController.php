<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paralelo;
use Illuminate\Support\Facades\log;

class ParaleloController extends Controller
{
    //transacciones
    /**
     * @OA\Get(
     *     path="/api/paralelos",
     *     summary="Listar paralelos",
     *     tags={"Paralelos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de paralelos"
     *     )
     * )
     */

    //devoler zl usuario todo los paralelos que estan registrado en la tabla
    public function index(){
        log::info("lista de paralelos");
        return response()->json(Paralelo::all());
    }
    //guardar
    /**
     * @OA\Post(
     *     path="/api/paralelos",
     *     summary="Crear paralelo",
     *     tags={"Paralelos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="P1")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Paralelo creado exitosamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request){
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        log::info('Paralelo creado');
        $paralelo = Paralelo::create($validated);

        return response()->json([
            'message' => 'Paralelo creado exitosamente',
            'data' => $paralelo
        ]);
    }

    /**
        * @OA\Put(
        *     path="/api/paralelos/{id}",
        *     summary="Actualizar paralelo",
        *     tags={"Paralelos"},
        *     @OA\Parameter(
        *         name="id",
        *         in="path",
        *         required=true,
        *         @OA\Schema(type="integer")
        *     ),
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"nombre"},
        *             @OA\Property(property="nombre", type="string", example="P2")
        *         )
        *     ),
        *     @OA\Response(response=200, description="Paralelo actualizado exitosamente"),
        *     @OA\Response(response=422, description="Error de validación")
        * )
        */
    //update
    public function update(Request $request, $id){
        //validaciones
        $paralelo = Paralelo::findorFail($id); 

        $validated = $request -> validate([
            'nombre'=>'required|string|max:20|'
        ]);
        //actualizar
        $paralelo->update($validated);
        log::info('Paralelo actualizado', ['id' => $id]);
        return response()->json(['message'=>'Paralelo actualizado exitosamente', 'data' => $paralelo], 200);

    }
            /**
         * @OA\Delete(
         *     path="/api/paralelos/{id}",
         *     summary="Eliminar paralelo",
         *     tags={"Paralelos"},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(response=200, description="Paralelo eliminado exitosamente"),
         *     @OA\Response(response=404, description="Paralelo no encontrado")
         * )
         */
    //eliminar
    public function destroy($id){
        
        $paralelo = Paralelo::findorFail($id);
        $paralelo->delete();
        log::info('Paralelo eliminado', ['id' => $id]);
        return response()->json($paralelo,200);
    }
}
