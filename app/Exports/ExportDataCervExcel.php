<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ExportDataCervExcel implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $rows = [];

        // Recorre la data
        foreach ($this->data as $item) {
            $worker = $item['worker'];
            $attempts = $item['attempts'];

            foreach ($attempts as $attempt) {
                // Solo procesar si tiene nota
                if (!isset($attempt['note'])) {
                    continue;
                }

                $json = $attempt['json'] ?? [];
                $tables = $json['tables'] ?? [];
                $infractions = $tables['infractions'] ?? [];

                $results['Intento'] = $attempt['attempt'] ?? '';
                $results['DNI'] = $worker['doi'] ?? '';
                $results['Licencia'] = $worker['license'] ?? '';
                $results['Categoria'] = $worker['category'] ?? '';
                $results['Nombres y Apellidos'] = $worker['nombres'] ?? '';
                $results['Fecha de Inicio'] = $attempt['start_date'] ?? '';
                $results['Fecha de Fin'] = $attempt['end_date'] ?? '';
                $results['Nota'] = $attempt['note'] ?? '';
                dd($attempt);
                foreach ($infractions as $infraction) {
                    $results['InfraccionNombre'] = $infraction['name'] ?? '';
                    $results['InfraccionScore'] = $infraction['score'] ?? '';
                    $results['InfraccionRepeticiones'] = $infraction['repetition'] ?? '';
                    $results['InfraccionTotal'] = $infraction['total'] ?? '';
                    $rows[] = $results;
                }
            }
        }

        return new Collection($rows);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Intento',
            'DNI',
            'Licencia',
            'Categoria',
            'Nombres y Apellidos',
            'Fecha de Inicio',
            'Fecha de Fin',
            'Nota',
            'InfraccionNombre',
            'InfraccionScore',
            'InfraccionRepeticiones',
            'InfraccionTotal',
        ];
    }
}
