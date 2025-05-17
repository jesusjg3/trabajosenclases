<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use Illuminate\Support\Facades\log;


class EstudianteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/estudiantes",
     *     summary="Listar estudiantes",
     *     tags={"Estudiantes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de estudiantes"
     *     )
     * )
     */

    public function index()
    {
        log::info("lista de estudiantes");
        // Devolver todos los estudiantes registrados en la tabla
        return response()->json(Estudiante::all());
    }


    /**
     * @OA\Post(
     *     path="/api/estudiantes",
     *     summary="Crear estudiante",
     *     tags={"Estudiantes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "cedula", "correo", "paralelo_id"},
     *             @OA\Property(property="nombre", type="string",example="Juan Perez"),
     *             @OA\Property(property="cedula", type="string", example="1234567890"),
     *             @OA\Property(property="correo", type="string", example="example@exmaple"),
     *             @OA\Property(property="paralelo_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\Response(response=201, description="Estudiante creado exitosamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request)
    {
        log::info("Estuandiante guardado");
        $validated = $request->validate([
            'nombre' => 'required|string',
            'cedula' => 'required|string|unique:estudiantes,cedula',
            'correo' => 'required|email|unique:estudiantes,correo',
            'paralelo_id' => 'required|exists:paralelos,id',
        ]);

        $estudiante = Estudiante::create($validated);

        return response()->json(['mensaje' => 'estudiante creado exitosamente', 'data' =>$estudiante], 201);
    }

    /**
        * @OA\Put(
        *     path="/api/estudiantes/{id}",
        *     summary="Actualizar estudiante",
        *     tags={"Estudiantes"},
        *     @OA\Parameter(
        *         name="id",
        *         in="path",
        *         required=true,
        *         description="ID del estudiante a actualizar",
        *         @OA\Schema(type="integer")
        *     ),
        *     @OA\RequestBody(
        *         required=true,
        *         @OA\JsonContent(
        *             required={"nombre", "cedula", "correo", "paralelo_id"},
        *             @OA\Property(property="nombre", type="string", example="Juan Perez"),
        *             @OA\Property(property="cedula", type="string", example=""),
        *             @OA\Property(property="correo", type="string", example=""),
        *             @OA\Property(property="paralelo_id", type="integer", example=1)
        *         )
        *     ),
        *     @OA\Response(response=200, description="Estudiante actualizado exitosamente"),
        *     @OA\Response(response=404, description="Estudiante no encontrado")
        * )
        */

        public function update(Request $request, $id){
            $estudiantes = Estudiante::findOrFail($id);
            
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'cedula' => 'required|string|max:20|unique:estudiantes',
                'correo' => 'required|email|unique:estudiantes',
                'paralelo_id' => 'required|exists:paralelos,id'        
            ]);
            $estudiantes->update($validated);
            Log::info('actualizando estudiante', ['id' => $id]);
            return response()->json(['mensaje' => 'estudiante actualizado exitosamente', 'data' =>$estudiantes], 200);
        }


        /**
         * @OA\Delete(
         *     path="/api/estudiantes/{id}",
         *     summary="Eliminar estudiante",
         *     tags={"Estudiantes"},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="ID del estudiante a eliminar",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(response=200, description="Estudiante eliminado exitosamente"),
         *     @OA\Response(response=404, description="Estudiante no encontrado")
         * )
         */

        public function destroy($id){
            Log::info('Estudiante eliminado', ['id' => $id]);
            $estudiante = Estudiante::findOrFail($id);
            $estudiante->delete();
            log::info('estudiante borrado', ['id' => $id] );
            return response()->json(['mensaje' => 'estudiante borrado extisamente','data'=> $estudiante], 200);
        }
}
