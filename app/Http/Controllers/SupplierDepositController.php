<?php

namespace App\Http\Controllers;

use App\Models\DepositMethod;
use App\Models\DepositSource;
use App\Models\DrawerCash;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierDeposit;
use Illuminate\Http\Request;

class SupplierDepositController extends Controller
{
    public function index(Request $request)
    {
        $supplier_id = $request->get('supplier_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $type = authUserServiceType();

        $suppliers = Supplier::query()
            ->where('type', $type)
            ->get();

        $supplierDepositsQuery = SupplierDeposit::query()
            ->whereIn('supplier_id', $suppliers->pluck('id'));

        if ($supplier_id) {
            $supplierDepositsQuery->where('supplier_id', $supplier_id);
        }

        if ($fromDate) {
            $supplierDepositsQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $supplierDepositsQuery->whereDate('created_at', '<=', $toDate);
        }

        if ($request->boolean('is_print')) {
            $supplierDeposits = $supplierDepositsQuery
                ->latest()
                ->get();
            return view('supplier.deposit.print-detail', compact('supplierDeposits', 'fromDate', 'toDate'));
        }else{
            $supplierDeposits = $supplierDepositsQuery
                ->latest()
                ->simplePaginate(20);
        }

        return view('supplier.deposit.index', compact(
                'supplierDeposits',
                'suppliers',
                'supplier_id',
                'fromDate',
                'toDate',
            )
        );
    }

    public function create(Request $request)
    {
        $type = authUser()->service_type;

        $suppliers = Supplier::query()
            ->where('type', $type)
            ->get();

        $supplierDeposits = SupplierDeposit::query()
            ->whereIn('supplier_id', $suppliers->pluck('id'))
            ->latest()
            ->simplePaginate(20);

        $editId = $request->get('editId');
        $depositEdit = SupplierDeposit::find($editId);

        $depositMethods = DepositMethod::all();
        $services = Service::where('type', authUser()->service_type)->get();
        $depositSources = DepositSource::all();

        return view('supplier.deposit.create', compact(
                'supplierDeposits',
                'suppliers',
                'depositEdit',
                'depositMethods',
                'services',
                'depositSources',
            )
        );
    }

    public function show($id)
    {
        $invoice = SupplierDeposit::findOrFail($id);

        if (authUser()->service_type != $invoice->type) {
            return back()->with('error', 'Permission deny!');
        }

        return view('invoices.show', compact('invoice'));
    }

    public function print($id)
    {
        $deposit = SupplierDeposit::findOrFail($id);

        return view('supplier.deposit.print', compact('deposit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'deposited_by' => 'required',
            'method_id' => 'required',
            'source_id' => 'nullable',
            'remarks' => 'nullable',
        ]);

        SupplierDeposit::create([
            'supplier_id' => $request->get('supplier_id'),
            'amount' => $request->get('amount'),
            'date' => $request->get('date'),
            'deposited_by' => $request->get('deposited_by'),
            'method_id' => $request->get('method_id'),
            'service_id' => $request->get('service_id'),
            'source_id' => $request->get('source_id', DepositSource::CASH_IN_HAND),
            'remarks' => $request->get('remarks'),
            'created_by_user_id' => authUser()->id,
        ]);

        DrawerCash::create([
            'type' => authUserServiceType(),
            'out_amount' => $request->get('amount'),
            'deposit_source_id' => $request->get('deposit_source_id', DepositSource::CASH_IN_HAND),
            'remarks' => "Supplier deposit from drawer cash",
            'created_by_user_id' => authUser()->id,
        ]);

        return back()->with('success', 'Supplier Deposit Created');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'deposited_by' => 'required',
            'method_id' => 'required',
            'source_id' => 'required',
            'remarks' => 'nullable',
        ]);

        $supplierDeposit = SupplierDeposit::findOrFail($id);

        $supplierDeposit->update([
            'supplier_id' => $request->get('supplier_id'),
            'amount' => $request->get('amount'),
            'date' => $request->get('date'),
            'deposited_by' => $request->get('deposited_by'),
            'method_id' => $request->get('method_id'),
            'service_id' => $request->get('service_id'),
            'source_id' => $request->get('source_id', DepositSource::CASH_IN_HAND),
            'remarks' => $request->get('remarks'),
        ]);

        return back()->with('success', 'Supplier Deposit Updated');
    }

    public function report(Request $request)
    {
        $type = authUser()->service_type;

        $suppliers = Supplier::query()
            ->where('type', $type)
            ->get();

        if ($request->boolean('is_print')) {
            return view('supplier.deposit.report-print', compact('suppliers'));
        }

        return view('supplier.deposit.report', compact('suppliers'));
    }

}
