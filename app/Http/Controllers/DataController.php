<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Imports\{OrderImport, UsersImport, InvoiceImport, PatientImport, PaymentsImport, PrescriberImport, ProductImport, PatientEducationImport, ConditionVideoImport, AdminVideoImport, MedVideoMappingImport, FormularyImport, OrderArchiveImport};
use App\Exports\{UsersExport, OrdersExport, InvoicesExport, PaymentsExport};
use Maatwebsite\Excel\Facades\Excel;


class DataController extends Controller
{
    public function export(Request $request)
    {
        $file = 'DermRX Pharmacy ' . ucfirst($request->table) . ' ' . date('Y-m-d H:i:s') . '.xlsx';
        switch ($request->table) {
            case 'users':
                return (new UsersExport($request->date))->download($file);
                break;

            case 'orders':
                return (new OrdersExport($request->date))->download($file);
                break;

            case 'invoices':
                return (new InvoicesExport($request->date))->download($file);
                break;

            default:
                return (new PaymentsExport($request->date))->download($file);
                break;
        }

        return redirect("admin/export?success=true&table={$request->table}");
    }

    public function import(Request $request)
    {
        switch ($request->table) {
            case 'users':
                Excel::import(new UsersImport, $request->file('csv'));
                break;

            case 'patients':
                Excel::import(new PatientImport, $request->file('csv'));
                break;

            case 'order':
                if($request->id != null)$request->session()->put('pharmacy_id', $request->id);
                Excel::import(new InvoiceImport, $request->file('csv'));
                break;

            case 'order_archive':
                Excel::import(new OrderArchiveImport, $request->file('csv'));
                break;

            case 'doctor':
                Excel::import(new PrescriberImport, $request->file('csv'));
                break;

            case 'items':
                Excel::import(new ProductImport, $request->file('csv'));
                break;
                
            case 'ndcUpload':
                Excel::import(new PatientEducationImport, $request->file('csv'));
                break;

            case 'covUpload':
                Excel::import(new ConditionVideoImport, $request->file('csv'));
                break;

            case 'admUpload':
                Excel::import(new AdminVideoImport, $request->file('csv'));
                break;

            case 'mvmUpload':
                Excel::import(new MedVideoMappingImport, $request->file('csv'));
                break;

            case 'formulary':
                DB::transaction(function() use ($request) {
                    Excel::import(new FormularyImport, $request->file('csv'));    
                });
                break;

            default:
                Excel::import(new PaymentsImport, $request->file('csv'));
                break;
        }
        if($request->id && $request->table == 'order') return redirect("pharmacy/{$request->table}?success=true");
        if($request->table == 'order_archive') return redirect('admin/archives/orders');
        $request->table = $request->table == 'ndcUpload' ? 'rxdata' : $request->table;
        $request->table = $request->table == 'covUpload' ? 'rxdata' : $request->table;
        $request->table = $request->table == 'admUpload' ? 'rxdata' : $request->table;
        $request->table = $request->table == 'mvmUpload' ? 'rxdata' : $request->table;
        return redirect("admin/{$request->table}?success=true");
    }
}
