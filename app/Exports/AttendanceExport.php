<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    use Exportable;

    protected $month;
    protected $year;
    protected $user_id;
    private $row = 0;

    function __construct($month, $year, $user_id)
    {
        $this->month = $month;
        $this->year = $year;
        $this->user_id = $user_id;
    }

    public function model(array $row)
    {
        ++$this->row;
    }

    public function collection()
    {

        $data = Attendance::with('user')
            ->where('user_id', $this->user_id)
            ->whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->get();

        return $data;
    }

    /**
     * @var Attendance $attendance
     */
    public function map($attendance): array
    {
        return [
            ++$this->row,
            $attendance->created_at->isoFormat('DD-MM-YYYY'),
            $attendance->type(),
            $attendance->checkin_time,
            $attendance->checkout_time,
            $attendance->status()
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'Tanggal',
            'Jenis Absen',
            'Jam Masuk',
            'Jam Pulang',
            'Status',
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'D9D9D9']
                    ]
                ];


                $event->sheet->getStyle('A2:F2')->applyFromArray($styleArray);
            },
        ];
    }
}
