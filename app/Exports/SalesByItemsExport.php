<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class SalesByItemsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return DB::table('orders as o')
            ->join('tbl_history as h', 'o.ticket', '=', 'h.ticket')
            ->join('stocks as s', 'o.food_name', '=', 's.item')  // Join using food_name and item
            ->select(
                'o.food_name',
                DB::raw('COUNT(*) as occurrence'),
                's.retail',  // Get retail from stocks
                's.cost'    // Get cost from stocks
            )
            ->groupBy('o.food_name', 's.retail', 's.cost')
            ->orderBy('occurrence', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Item Name',
            'Items Sold',
            'Net Sales (₱)',
            'Item Cost (₱)',
            'Gross Profit (₱)',
            'Export Date'
        ];
    }

    public function map($row): array
    {
        $netSales = ($row->retail * $row->occurrence) - (($row->retail * $row->occurrence) * .12);
        $itemCost = $row->cost * $row->occurrence;
        $grossProfit = $netSales - $itemCost;

        return [
            $row->food_name,
            $row->occurrence,
            '₱ ' . number_format($netSales, 2),
            '₱ ' . number_format($itemCost, 2),
            '₱ ' . number_format($grossProfit, 2),
            now()->format('Y-m-d H:i:s')
        ];
    }
}