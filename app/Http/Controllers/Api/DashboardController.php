<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Prescriber, Patient, Provider, Invoice, Payment, Order, ArchiveOrder};
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class DashboardController extends Controller
{
    public function admin($data_type) {
        switch($data_type) {
            case 'prescriber_count':
                $data = Prescriber::count() + ArchiveOrder::distinct('prescriber_full_name')->count();
            break;
            case 'pharmacy_count':
                $data = Provider::count();
            break;
            case 'patient_count':
                $data = Patient::count();
            break;
            case 'script_count':
                $daily_orders = Order::whereDate('created_at', Carbon::now()->toDateString())->count() + ArchiveOrder::whereDateFilled(Carbon::now()->format('d/m/Y'))->count();
                $weekly_orders = Order::whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count() + ArchiveOrder::whereBetween(DB::raw("str_to_date(date_filled, '%d/%m/%Y')"), [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $monthly_orders = Order::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count() + ArchiveOrder::whereBetween(DB::raw("str_to_date(date_filled, '%d/%m/%Y')"), [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                $quarterly_orders = Order::whereBetween('created_at', [Carbon::now()->firstOfQuarter(), Carbon::now()->lastOfQuarter()])->count() + ArchiveOrder::whereBetween(DB::raw("str_to_date(date_filled, '%d/%m/%Y')"), [Carbon::now()->firstOfQuarter(), Carbon::now()->lastOfQuarter()])->count();
                $annual_orders = Order::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count() + ArchiveOrder::whereBetween(DB::raw("str_to_date(date_filled, '%d/%m/%Y')"), [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();

                $total_scripts = Order::count() + ArchiveOrder::count();
                $completed_scripts = Order::whereCurrentTransactionStatus('Completed')->count() + ArchiveOrder::count();
                $adherance = [
                    'total_scripts' => $total_scripts,
                    'completed_scripts' => $completed_scripts,
                    'rate' => $completed_scripts > 0 ? round(($completed_scripts / $total_scripts) * 100, 2):0,
                ];

                $data = [
                    'daily_orders' => $daily_orders,
                    'weekly_orders' => $weekly_orders,
                    'monthly_orders' => $monthly_orders,
                    'quarterly_orders' => $quarterly_orders,
                    'annual_orders' => $annual_orders,
                    'adherance' => $adherance,
                ];
            break;
            case 'invoices':
                $new_invoices = Invoice::orderBy('created_at','ASC')->whereStatus('pending')->whereDate('created_at',Carbon::today()->toDateString())->paginate(10);
                $pending_invoices = Invoice::whereStatus('pending')->paginate(5);
                $completed_invoices = Invoice::whereStatus('completed')->paginate(10);
                $cancelled_invoices = Invoice::whereStatus('cancelled')->paginate(10);

                $data = [
                    'new_invoices' => $new_invoices,
                    'pending_invoices' => $pending_invoices,
                    'completed_invoices' => $completed_invoices,
                    'cancelled_invoices' => $cancelled_invoices,
                ];
            break;
            case 'doctors':
                $semi_prescribers = Prescriber::select('name','npi')->withCount('orders AS scripts');
                $archived_prescribers = DB::table('archive_orders')
                ->select('prescriber_full_name AS name','prescriber_npi AS npi',DB::raw('COUNT(prescriber_full_name) AS scripts'))
                ->groupBy('prescriber_full_name','prescriber_npi');
                $data = $semi_prescribers->unionAll($archived_prescribers)->paginate(10);
            break;
            case 'pharmacies':
                $pharmacies = [];
                Provider::chunk(50, function($providers) use (&$pharmacies) {
                    foreach($providers as $provider) {
                        $patients = Patient::wherePharmacyId($provider->id)->pluck('user_id')->toArray();
                        $pharmacies = array_merge($pharmacies, [[
                            'pharmacy_name' => $provider->name,
                            'completed_invoices' => Invoice::whereIn('user_id',$patients)->whereStatus('completed')->get()->count(),
                            'total_invoices' => Invoice::whereIn('user_id',$patients)->get()->count(),
                            'payments' => Payment::whereIn('user_id',$patients)->get()->count(),
                        ]]);
                    }
                });

                $data = $this->generatePaginationFromArray(1,10,$pharmacies);
            break;
            case 'top_medicines':
                $medicines_leaderboard = [];
                Order::distinct('dispensed_item_name')->chunk(500, function($medicines) use (&$medicines_leaderboard) {
                    foreach($medicines as $medicine) {
                        $tally = Order::whereDispensedItemName($medicine->dispensed_item_name)->count() + ArchiveOrder::whereDispensedItemName($medicine->dispensed_item_name)->count();
                        if(count($medicines_leaderboard) == 0) {
                            $medicines_leaderboard = array_merge($medicines_leaderboard, [[
                                'name' => $medicine->dispensed_item_name,
                                'tally' => $tally,
                            ]]);
                        } else {
                            $hasMatch = false;
                            foreach($medicines_leaderboard as $leaderboard) {
                                if($leaderboard['name'] == $medicine->dispensed_item_name) {
                                    $hasMatch = true;
                                    break;
                                }
                            }

                            if(!$hasMatch) {
                                $medicines_leaderboard = array_merge($medicines_leaderboard, [[
                                    'name' => $medicine->dispensed_item_name,
                                    'tally' => $tally,
                                ]]);
                            }
                        }
                        
                    }
                });

                ArchiveOrder::distinct('dispensed_item_name')->chunk(500, function($medicines) use (&$medicines_leaderboard) {
                    foreach($medicines as $medicine) {
                        $tally = ArchiveOrder::whereDispensedItemName($medicine->dispensed_item_name)->count() + Order::whereDispensedItemName($medicine->dispensed_item_name)->count();
                        if(count($medicines_leaderboard) == 0) {
                            $medicines_leaderboard = array_merge($medicines_leaderboard, [[
                                'name' => $medicine->dispensed_item_name,
                                'tally' => $tally,
                            ]]);
                        } else {
                            $hasMatch = false;
                            foreach($medicines_leaderboard as $leaderboard) {
                                if($leaderboard['name'] == $medicine->dispensed_item_name) {
                                    $hasMatch = true;
                                    break;
                                }
                            }

                            if(!$hasMatch) {
                                $medicines_leaderboard = array_merge($medicines_leaderboard, [[
                                    'name' => $medicine->dispensed_item_name,
                                    'tally' => $tally,
                                ]]);
                            }
                        }
                        
                    }
                });

                array_multisort(array_column($medicines_leaderboard,'tally'),SORT_DESC,$medicines_leaderboard);
                $data = array_slice($medicines_leaderboard,0,10);
            break;
            case 'top_pharmacies':
                $pharmacies_leaderboard = [];
                Order::distinct('pharmacy_name')->chunk(500, function($pharmacies) use (&$pharmacies_leaderboard) {
                    foreach($pharmacies as $pharmacy) {
                        $tally = Order::wherePharmacyName($pharmacy->pharmacy_name)->count() + ArchiveOrder::wherePharmacy($pharmacy->pharmacy_name)->count();
                        if(count($pharmacies_leaderboard) == 0) {
                            $pharmacies_leaderboard = array_merge($pharmacies_leaderboard, [[
                                'name' => $pharmacy->pharmacy_name,
                                'tally' => $tally,
                            ]]);
                        } else {
                            $hasMatch = false;
                            foreach($pharmacies_leaderboard as $leaderboard) {
                                if($leaderboard['name'] == $pharmacy->pharmacy_name) {
                                    $hasMatch = true;
                                    break;
                                }
                            }

                            if(!$hasMatch) {
                                $pharmacies_leaderboard = array_merge($pharmacies_leaderboard, [[
                                    'name' => $pharmacy->pharmacy_name,
                                    'tally' => $tally,
                                ]]);
                            }
                        }
                    }
                });

                ArchiveOrder::distinct('pharmacy')->chunk(500, function($pharmacies) use (&$pharmacies_leaderboard) {
                    foreach($pharmacies as $pharmacy) {
                        $tally = ArchiveOrder::wherePharmacy($pharmacy->pharmacy)->count() + Order::wherePharmacyName($pharmacy->pharmacy)->count();
                        if(count($pharmacies_leaderboard) == 0) {
                            $pharmacies_leaderboard = array_merge($pharmacies_leaderboard, [[
                                'name' => $pharmacy->pharmacy,
                                'tally' => $tally,
                            ]]);
                        } else {
                            $hasMatch = false;
                            foreach($pharmacies_leaderboard as $leaderboard) {
                                if($leaderboard['name'] == $pharmacy->pharmacy) {
                                    $hasMatch = true;
                                    break;
                                }
                            }

                            if(!$hasMatch) {
                                $pharmacies_leaderboard = array_merge($pharmacies_leaderboard, [[
                                    'name' => $pharmacy->pharmacy,
                                    'tally' => $tally,
                                ]]);
                            }
                        }
                    }
                });

                array_multisort(array_column($pharmacies_leaderboard,'tally'),SORT_DESC,$pharmacies_leaderboard);
                $data = array_slice($pharmacies_leaderboard,0,10);
            break;
            case 'top_prescribers':
                $prescribers_leaderboard = [];
                Order::with('prescriber')->distinct('prescriber_npi')->chunk(500, function($prescribers) use (&$prescribers_leaderboard) {
                    foreach($prescribers as $prescriber) {
                        $tally = Order::wherePrescriberNpi($prescriber->prescriber_npi)->count() + ArchiveOrder::wherePrescriberFullName($prescriber->prescriber->name)->count();
                        if(count($prescribers_leaderboard) == 0) {
                            $prescribers_leaderboard = array_merge($prescribers_leaderboard, [[
                                'name' => $prescriber->prescriber->name,
                                'tally' => $tally,
                            ]]);
                        } else {
                            $hasMatch = false;
                            foreach($prescribers_leaderboard as $leaderboard) {
                                if($leaderboard['name'] == $prescriber->prescriber->name) {
                                    $hasMatch = true;
                                    break;
                                }
                            }

                            if(!$hasMatch) {
                                $prescribers_leaderboard = array_merge($prescribers_leaderboard, [[
                                    'name' => $prescriber->prescriber->name,
                                    'tally' => $tally,
                                ]]);
                            }
                        }
                            
                    }
                });

                ArchiveOrder::distinct('prescriber_full_name')->chunk(500, function($prescribers) use (&$prescribers_leaderboard) {
                    foreach($prescribers as $prescriber) {
                        $tally = ArchiveOrder::wherePrescriberFullName($prescriber->prescriber_full_name)->count() + Order::wherePrescriberNpi($prescriber->prescriber_npi)->count();
                        if(count($prescribers_leaderboard) == 0) {
                            $prescribers_leaderboard = array_merge($prescribers_leaderboard, [[
                                'name' => $prescriber->prescriber_full_name,
                                'tally' => $tally,
                            ]]);
                        } else {
                            $hasMatch = false;
                            foreach($prescribers_leaderboard as $leaderboard) {
                                if($leaderboard['name'] == $prescriber->prescriber_full_name) {
                                    $hasMatch = true;
                                    break;
                                }
                            }

                            if(!$hasMatch) {
                                $prescribers_leaderboard = array_merge($prescribers_leaderboard, [[
                                    'name' => $prescriber->prescriber_full_name,
                                    'tally' => $tally,
                                ]]);
                            }
                        }
                    }
                });

                array_multisort(array_column($prescribers_leaderboard,'tally'),SORT_DESC,$prescribers_leaderboard);
                $data = array_slice($prescribers_leaderboard,0,10);
            break;
            case 'payments_count_pie_chart':
                $daily_payments = Payment::whereDate('created_at', Carbon::today()->toDateString())->count();
                $weekly_payments = Payment::whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $monthly_payments = Payment::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                $annual_payments = Payment::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();

                $data = [
                    'daily_payments' => $daily_payments,
                    'weekly_payments' => $weekly_payments,
                    'monthly_payments' => $monthly_payments,
                    'annual_payments' => $annual_payments,
                ];
            break;
        }

        return response()->json([
            'data' => $data,
        ],200);
    }

    public function admin_paginate(Request $request, $table_type) {
        switch($table_type) {
            case 'new_invoices':
                $table = Invoice::orderBy('created_at','ASC')->whereStatus('pending')->whereDate('created_at',Carbon::today()->toDateString())->paginate(10);
            break;
            case 'pending_invoices':
                $table = Invoice::whereStatus('pending')->paginate(5);
            break;
            case 'completed_invoices':
                $table = Invoice::whereStatus('completed')->paginate(10);
            break;
            case 'cancelled_invoices':
                $table = Invoice::whereStatus('cancelled')->paginate(10);
            break;
            case 'doctors':
                $semi_prescribers = Prescriber::select('name','npi')->withCount('orders AS scripts');
                $archived_prescribers = DB::table('archive_orders')
                ->select('prescriber_full_name AS name','prescriber_npi AS npi',DB::raw('COUNT(prescriber_full_name) AS scripts'))
                ->groupBy('prescriber_full_name','prescriber_npi');
                $table = $semi_prescribers->unionAll($archived_prescribers)->paginate(10);
            break;
            case 'pharmacies':
                $pharmacies = [];
                Provider::chunk(50, function($providers) {
                    foreach($providers as $provider) {
                        $patients = Patient::wherePharmacyId($provider->id)->pluck('user_id')->toArray();
                        $pharmacies = array_merge($pharmacies, [[
                            'pharmacy_name' => $provider->name,
                            'completed_invoices' => Invoice::whereIn('user_id',$patients)->whereStatus('completed')->get()->count(),
                            'total_invoices' => Invoice::whereIn('user_id',$patients)->get()->count(),
                            'payments' => Payment::whereIn('user_id',$patients)->get()->count(),
                        ]]);
                    }
                });

                $table = $this->generatePaginationFromArray($request->query('page'),10,$pharmacies);
            break;
        }

        return response()->json([
            'table' => $table,
        ]);
    }

    private function generatePaginationFromArray($page,$perPage,$array) {
        $collection = collect($array);
        $new_collection = $collection->slice(($page * $perPage) - $perPage, $perPage)->all();
        $paginated= new LengthAwarePaginator($new_collection , count($collection), $perPage);
        // $paginated->setPath($url);

        return $paginated;
    }
}
