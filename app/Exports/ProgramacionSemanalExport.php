<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class ProgramacionSemanalExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $programaciones;
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($programaciones, $fechaInicio, $fechaFin)
    {
        $this->programaciones = $programaciones;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function collection()
    {
        return $this->programaciones;
    }

    public function headings(): array
    {
        return [
            'FECHA',
            'HORA',
            'AMBIENTE',
            'FICHA',
            'INSTRUCTOR',
            'COMPETENCIA',
            'ESTADO'
        ];
    }

    public function map($programacion): array
    {
        return [
            Carbon::parse($programacion->fecha)->isoFormat('dddd D [de] MMMM'),
            Carbon::parse($programacion->hora_inicio)->format('H:i') . ' - ' . 
            Carbon::parse($programacion->hora_fin)->format('H:i'),
            $programacion->ambiente->numero . ' - ' . $programacion->ambiente->alias,
            $programacion->ficha->codigo_ficha . ' - ' . $programacion->ficha->nombre,
            $programacion->instructor->pnombre . ' ' . $programacion->instructor->papellido,
            $programacion->competencia->codigo . ' - ' . $programacion->competencia->descripcion,
            ucfirst($programacion->estado)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo para el título
        $sheet->insertNewRowBefore(1, 2);
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'PROGRAMACIÓN SEMANAL - Semana del ' . 
            Carbon::parse($this->fechaInicio)->isoFormat('D [de] MMMM') . ' al ' . 
            Carbon::parse($this->fechaFin)->isoFormat('D [de] MMMM [de] YYYY'));
        
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '000000']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Estilo para los encabezados
        $sheet->getStyle('A3:G3')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '39A900']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ]
        ]);

        // Bordes y estilos para toda la tabla
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A3:G'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Alineación del contenido
        $sheet->getStyle('A4:G'.$lastRow)->applyFromArray([
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);

        // Centrar columnas específicas
        $columnsToCenterAlign = ['A', 'B', 'G'];
        foreach ($columnsToCenterAlign as $column) {
            $sheet->getStyle($column.'4:'.$column.$lastRow)
                  ->getAlignment()
                  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        return [
            'A1:G'.$lastRow => [
                'font' => ['name' => 'Arial', 'size' => 11]
            ]
        ];
    }

    public function title(): string
    {
        return 'Programación Semanal';
    }
}