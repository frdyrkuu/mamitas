<?php

namespace App\Exports;

use App\Models\History;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;

class SalesReportExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $currentYear;
    private $currentMonth;
    private $dailySalesFormatted = [];
    private $dailySales = [];
    private $dailyTotalSales = [];
    private $dailySubTotalSales = [];
    private $gross_sales;
    private $net_sales;

    public function __construct($year, $month) {
        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->initializeSalesData();
    }

    private function initializeSalesData() {
        $rowsThisMonth = History::whereYear('created_at', $this->currentYear)
            ->whereMonth('created_at', $this->currentMonth)
            ->get();

        $this->gross_sales = $rowsThisMonth->sum('total');
        $this->net_sales = $rowsThisMonth->sum('sub_total');

        for ($day = 1; $day <= Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->daysInMonth; $day++) {
            $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, $day);
            $formattedDate = $date->isoFormat('MMMM D, YYYY');

            $rowsWithDate = $rowsThisMonth->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', $date->endOfDay());

            $totalSales = $rowsWithDate->sum('total');
            $subTotalSales = $rowsWithDate->sum('sub_total');

            $this->dailySalesFormatted[$formattedDate] = $totalSales;
            $this->dailySales[$date->day] = $totalSales;
            $this->dailyTotalSales[$formattedDate] = $totalSales;
            $this->dailySubTotalSales[$formattedDate] = $subTotalSales;
        }
    }

    public function view() : View
    {
        return view('backoffice/admin_dashboard', [
            'sales' => $this->dailySalesFormatted,
            'dailySales' => $this->dailySales,
            'dailyTotalSales' => $this->dailyTotalSales,
            'dailySubTotalSales' => $this->dailySubTotalSales,
            'gross_sales' => $this->gross_sales,
            'net_sales' => $this->net_sales
        ]);
    }
}

