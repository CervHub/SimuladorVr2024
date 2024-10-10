<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLicense
{
    // Listado de MACs válidas
    private $validMacs = [
        '00:1A:2B:3C:4D:5E',
        '11:22:33:44:55:66',
        'AA:BB:CC:DD:EE:FF',
        // Agrega más MACs según sea necesario
    ];

    public function handle(Request $request, Closure $next)
    {
        $license = $request->header('X-License');

        if (!$license || !$this->isValidLicense($license)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }

    private function isValidLicense($license)
    {
        // Verificar si la licencia (MAC) está en el listado de MACs válidas
        return in_array($license, $this->validMacs);
    }
}
