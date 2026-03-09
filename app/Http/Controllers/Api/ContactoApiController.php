<?php

namespace App\Http\Controllers\Api;

use App\Models\Contacto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ContactoApiController extends Controller
{
    /**
     * Recibir mensaje de contacto desde la web
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validar datos
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'company' => 'nullable|string|max:255',
                'message' => 'required|string|max:5000',
                'g-recaptcha-response' => 'required|string',
            ], [
                'name.required' => 'El nombre es obligatorio',
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El correo electrónico no es válido',
                'message.required' => 'El mensaje es obligatorio',
                'g-recaptcha-response.required' => 'Por favor complete el captcha',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verificar reCAPTCHA (opcional - puedes implementar la verificación real con Google)
            // $recaptcha = $request->input('g-recaptcha-response');
            // Aquí iría la verificación con la API de Google reCAPTCHA

            // Crear contacto
            $contacto = Contacto::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'leido' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.',
                'data' => [
                    'id' => $contacto->id,
                    'created_at' => $contacto->created_at->format('Y-m-d H:i:s'),
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el mensaje: ' . $e->getMessage()
            ], 500);
        }
    }
}
