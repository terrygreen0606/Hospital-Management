<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $date;

    function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * @return \Illuminate\Support\Query
     */
    public function query()
    {
        return Order::query()->whereDate('created_at', $this->date);
    }

    function headings(): array
    {
        return [
            "ID", "Rx Number", "Current Transaction Status Date", "Priority", "Dispensed Item Name", "Current Transaction Status", "Date Filled", "Date Written", "Rx Status", "Rx Status Changed On", "Number Of Refills Allowed", "Directions Translated", "Rx Total Quantity Remaining", "Refills Remaining", "Refill Number", "Dispensed Quantity", "Days Supply", "Total Price Paid", "Patient Paid Amount", "Patient Last Name", "Patient First Name", "Patient Primary Address", "Patient Primary City", "Patient Primary State",
            "Patient Primary Zip Code", "Patient Primary Phone Number", "Patient Date of Birth", "Dispensed Item NDC", "Patient Serial Number", "Prescriber First Name", "Prescriber Last Name", "Prescriber Primary Phone", "Patient Primary Category", "Prescriber NPI", "Pharmacy Name"
        ];
    }
}
