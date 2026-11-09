<?php

namespace Tests\Unit;

use App\Models\DetailInductionWorker;
use PHPUnit\Framework\TestCase;

class PalaMineraNotaTest extends TestCase
{
    public function test_calcula_el_promedio_con_limites_y_suma_las_colisiones(): void
    {
        foreach ([
            [5, [0, 0, 0], 20, 20, 20],
            [6, [0, 0, 0], 20, 20, 20],
            [4, [2, 1, 0], 16, 17, 16.5],
            [0, [0, 0, 0], 0, 20, 10],
            [5, [10, 10, 5], 20, 0, 10],
        ] as [$trucks, $collisions, $truckScore, $collisionScore, $final]) {
            $payload = [
                'trucks' => ['totalTrucks' => $trucks],
                'collisions' => array_combine(['shovelTracks', 'truck', 'bucketDoor'], $collisions),
                'note' => 99,
            ];
            self::assertEquals($truckScore, DetailInductionWorker::palaMineraNotaCamiones($payload));
            self::assertEquals($collisionScore, DetailInductionWorker::palaMineraNotaColisiones($payload));
            self::assertEquals($final, DetailInductionWorker::palaMineraNota($payload));
        }
    }

    public function test_usa_cargas_correctas_y_el_cable_no_afecta_la_nota(): void
    {
        $payload = [
            'trucks' => ['correctLoads' => 3, 'totalTrucks' => 9],
            'collisions' => ['shovelTracks' => 2, 'truck' => 1, 'bucketDoor' => 0, 'supplyCable' => true],
        ];
        self::assertEquals(12, DetailInductionWorker::palaMineraNotaCamiones($payload));
        self::assertEquals(14.5, DetailInductionWorker::palaMineraNota($payload));
        $payload['trucks']['correctLoads'] = 0;
        self::assertEquals(0, DetailInductionWorker::palaMineraNotaCamiones($payload));
        $payload['trucks']['correctLoads'] = 6;
        self::assertEquals(18.5, DetailInductionWorker::palaMineraNota($payload));
    }
}
