<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportDataMolibdenoExcel implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected Collection $data;
    protected Collection $cabecera;

    public function __construct(Collection $data, Collection $cabecera)
    {
        $this->data = $data;
        $this->cabecera = $cabecera;
    }

    public function collection(): Collection
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Reportes';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->setCellValue('A1', 'REPORTE POR SIMULADOR')->mergeCells('A1:H1');
                $sheet->setCellValue('A2', 'SIMULADOR')->mergeCells('A2:B2');
                $sheet->setCellValue('C2', $this->cabecera['simulador'])->mergeCells('C2:H2');
                $sheet->setCellValue('A3', 'INSTRUCTOR')->mergeCells('A3:B3');
                $sheet->setCellValue('C3', $this->cabecera['instructor'])->mergeCells('C3:H3');
                $sheet->setCellValue('A4', 'FECHA')->mergeCells('A4:B4');
                $sheet->setCellValue('C4', $this->cabecera['fecha'])->mergeCells('C4:H4');

                $sheet->fromArray(
                    ['DNI', 'NOMBRES Y APELLIDOS', 'INTENTO', 'F. INICIO', 'F. FIN', 'NOTA', 'NOTA REF.', 'MODO'],
                    null,
                    'A5'
                );

                $row = 6;
                foreach ($this->data as $item) {
                    $sheet->fromArray([
                        $item['doi'],
                        $item['name'],
                        $item['intento'],
                        $item['start_date'],
                        $item['end_date'],
                        $item['nota'],
                        $item['nota_referencial'],
                        $item['modo'],
                    ], null, 'A' . $row);
                    $row++;
                }

                $lastRow = max($row - 1, 5);
                $sheet->getStyle('A1:H' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle('A1:H' . $lastRow)->getAlignment()->applyFromArray([
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]);
            },
        ];
    }
}
