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
    protected $headerMap;
    protected $detailMap;
    public function __construct(Collection $data, Collection $cabecera, Collection $headerMap, Collection $detailMap)
    {
        $this->data = $data;
        $this->cabecera = $cabecera;
        $this->headerMap = $headerMap;
        $this->detailMap = $detailMap;
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

                $event->sheet->getDelegate()->fromArray(array_merge($this->headerMap->toArray(), ['Intento'], $this->detailMap->toArray()), null, 'A5');

                $row = 6; // +1 si tu cabecera comienza en
                foreach ($this->data as $item) {
                    $rowData = [];
                    foreach ($this->headerMap->keys() as $key) {
                        $rowData[$key] = $item[$key] ?? '-';
                    }

                    if (isset($item['detalle'])) {
                        $totalAttempts = count($item['detalle']);
                        foreach ($item['detalle'] as $attemptIndex => $detail) {
                            $detailData = [];
                            foreach ($this->detailMap->keys() as $key) {
                                if (isset($detail[$key])) {
                                    if ($detail[$key] === 0) {
                                        $detailData[$key] = '0';
                                    } else {
                                        $detailData[$key] = $detail[$key];
                                    }
                                } else {
                                    $detailData[$key] = '-';
                                }
                            }
                            $attemptData = [($attemptIndex + 1) . '/' . $totalAttempts];
                            $columnLetterHeader = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($this->headerMap->count() + 1);
                            $columnLetterDetail = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($this->headerMap->count() + 2);
                            $columnLetterDetailEnd = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($this->headerMap->count() + 1 + count($detailData));

                            if ($attemptIndex == 0) { // If it's the first iteration
                                $event->sheet->getDelegate()->fromArray(array_merge($rowData, $attemptData), null, 'A' . $row);
                                $event->sheet->getDelegate()->fromArray($detailData, null, $columnLetterDetail . $row);
                            } else { // If it's not the first iteration
                                $event->sheet->getDelegate()->fromArray($attemptData, null, $columnLetterHeader . $row);
                                $event->sheet->getDelegate()->fromArray($detailData, null, $columnLetterDetail . $row);
                            }

                            $row++;
                        }
                    } else {
                        $event->sheet->getDelegate()->fromArray($rowData, null, 'A' . $row);
                        $event->sheet->getDelegate()->getStyle('A' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $row++;
                    }

                    $rowData = []; // Clear the rowData for the next item
                }

                // Agrega bordes a todas las celdas
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();
                $event->sheet->getDelegate()->getStyle('A1:' . $highestColumn . ($row - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Centra el contenido de todas las celdas
                // $event->sheet->getDelegate()->getStyle('A1:E' . ($row - 1))->getAlignment()->applyFromArray([
                //     'horizontal' => Alignment::HORIZONTAL_CENTER,
                //     'vertical' => Alignment::VERTICAL_CENTER,
                // ]);
            },
        ];
    }
}
