<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class LabaRugiExport implements FromView, ShouldAutoSize, WithEvents
{
    use RegistersEventListeners;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('laporan.laba-rugi', ['data' => $this->data]);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        $sheet->getParent()->getDefaultStyle()->applyFromArray([
            'font' => ['name' => 'Arial', 'size' => 10]
        ]);
    }
}
