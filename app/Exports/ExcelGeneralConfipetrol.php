<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelGeneralConfipetrol implements FromCollection, WithHeadings, WithColumnWidths, WithTitle, WithEvents
{
    protected $data;
    protected $cabecera;

    public function __construct(Collection $data, Collection $cabecera)
    {
        $this->data = $data;
        $this->cabecera = $cabecera;
    }

    public function collection()
    {
        // Esta función de colección no se utilizará en este caso
        // Los datos se pasarán directamente al evento registerEvents
        return collect([]);
    }

    public function headings(): array
    {
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 30,
            'C' => 15,
            'D' => 20,
            'E' => 10,
        ];
    }

    public function title(): string
    {
        return 'Reportes';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setCellValue('A1', 'REPORTE POR SIMULADOR')->mergeCells('A1:E1');

                $event->sheet->getDelegate()->setCellValue('A2', 'SIMULADOR')->mergeCells('A2:B2');
                $event->sheet->getDelegate()->setCellValue('C2', $this->cabecera['simulador'])->mergeCells('C2:E2');

                $event->sheet->getDelegate()->setCellValue('A3', 'INSTRUCTOR')->mergeCells('A3:B3');
                $event->sheet->getDelegate()->setCellValue('C3', $this->cabecera['instructor'])->mergeCells('C3:E3');

                $event->sheet->getDelegate()->setCellValue('A4', 'FECHA')->mergeCells('A4:B4');
                $event->sheet->getDelegate()->setCellValue('C4', $this->cabecera['fecha'])->mergeCells('C4:E4');

                $event->sheet->getDelegate()->fromArray(['DOCUMENTO DE IDENTIDAD', 'DATOS DEL TRABAJADOR', 'NOTA'], null, 'A5');

                // Agrega los datos directamente en las filas siguientes
                $row = 6;
                foreach ($this->data as $item) {
                    $event->sheet->getDelegate()->fromArray([$item['doi'], $item['name'], $item['nota']], null, 'A' . $row);
                    $row++;
                }

                // Agrega bordes a todas las celdas
                $event->sheet->getDelegate()->getStyle('A1:E' . ($row - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Centra el contenido de todas las celdas
                $event->sheet->getDelegate()->getStyle('A1:E' . ($row - 1))->getAlignment()->applyFromArray([
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]);
            },
        ];
    }
}
