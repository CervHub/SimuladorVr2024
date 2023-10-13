<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ReporteController extends Controller
{
    public function generarImagen($porcentaje)
    {
        $canvas = imagecreatetruecolor(200, 200);
        $colorFondo = imagecolorallocate($canvas, 255, 255, 255);
        $colorArco = imagecolorallocate($canvas, 255, 0, 0);

        $centerX = 100;
        $centerY = 100;
        $radius = 80;

        imagefilledarc($canvas, $centerX, $centerY, $radius * 2, $radius * 2, 0, 360, $colorFondo, IMG_ARC_PIE);
        imagefilledarc($canvas, $centerX, $centerY, $radius * 2, $radius * 2, -90, -90 + (360 * ($porcentaje / 100)), $colorArco, IMG_ARC_PIE);

        ob_start();
        imagepng($canvas);
        $imageData = ob_get_clean();
        imagedestroy($canvas);

        $base64Image = 'data:image/png;base64,' . base64_encode($imageData);

        return $base64Image;
    }
}
