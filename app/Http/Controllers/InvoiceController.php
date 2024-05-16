<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Bank;
use App\Models\CashAtBank;
use App\Models\Customer;
use App\Models\DepositSource;
use App\Models\DrawerCash;
use App\Models\Invoice;
use App\Models\InvoiceDuePayment;
use App\Models\InvoiceService;
use App\Models\Service;
use App\Models\Supplier;
use App\Services\EmailRecipientService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $type = authUserServiceType()->value;

        $invoiceId = Invoice::query()
                ->where('type', $type)
                ->latest()
                ->first()?->invoice_no + 1;

        if (authUser()->service_type->value != $type) {
            return back()->with('error', 'Permission deny!');
        }

        $title = authUserServiceType()->getLabel();

        $moreServices = $request->get('moreServices');

        $travelTourismServices = Service::where('type', $type)->get();
        $documentClearingServices = Service::where('type', $type)->get();

        $invoices = Invoice::query()
            ->where('type', $type)
            ->latest()
            ->get();

        $invoiceEditId = $request->get('invoiceEditId');
        $invoiceEdit = Invoice::find($invoiceEditId);

        $customers = Customer::query()
            ->where('type', $type)
            ->get();

        $agents = Agent::query()
            ->where('type', $type)
            ->get();
        $suppliers = Supplier::query()
            ->where('type', $type)
            ->get();

        if($request->boolean('is_print')){
            return view('invoices.print-all', compact('invoices'));
        }

        return view('invoices.index', compact(
                'travelTourismServices',
                'documentClearingServices',
                'invoiceId',
                'invoices',
                'invoiceEdit',
                'customers',
                'agents',
                'suppliers',
                'title',
                'type',
                'moreServices',
            )
        );
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (authUser()->service_type != $invoice->type) {
            return back()->with('error', 'Permission deny!');
        }

        return view('invoices.show', compact('invoice'));
    }

    public function details($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (authUser()->service_type != $invoice->type) {
            return back()->with('error', 'Permission deny!');
        }

        return view('invoices.details', compact('invoice'));
    }

    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('invoices.print', compact('invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'type' => 'required',
            'issue_date' => 'required',
        ]);

        $invoice = Invoice::create([
            'invoice_no' => Invoice::getInvoiceNo($request->get('type')),
            'type' => $request->get('type'),
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'ref_number' => $request->get('ref_number'),
            'issue_date' => $request->get('issue_date'),
            'customer_id' => $request->get('customer_id'),
            'agent_id' => $request->get('agent_id'),
            'supplier_id' => $request->get('supplier_id'),
            'received_amount' => $request->get('received_amount'),
            'created_by_user_id' => authUser()->id,
        ]);

        DrawerCash::create([
            'type' => authUserServiceType(),
            'in_amount' => $request->get('received_amount'),
            'invoice_id' => $invoice->id,
            'remarks' => "Invoice to Drawer Cash",
            'created_by_user_id' => authUser()->id,
        ]);

        $serviceIds = $request->get('service_ids');
        $salesRates = $request->get('sales_rates');
        $supplierRates = $request->get('supplier_rates');
        $agentCommissions = $request->get('agent_commissions');
        $taxes = $request->get('taxes');
        $remarks = $request->get('remarks');
        $quantities = $request->get('quantities');

        foreach ($serviceIds as $key => $serviceId) {
            if (@$salesRates[$key] != null) {
                InvoiceService::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $serviceId,
                    'sales_rate' => @$salesRates[$key],
                    'supplier_rate' => @$supplierRates[$key],
                    'agent_commission' => @$agentCommissions[$key],
                    'quantity' => @$quantities[$key],
                    'tax_percentage' => @$taxes[$key],
                    'remarks' => $remarks[$key],
                ]);
            }
        }

        try {
            (new EmailRecipientService())->sendInvoice($invoice);
        } catch (\Exception) {
        }

        return back()->with('success', 'Invoice Created');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'type' => 'required',
            'issue_date' => 'required',
        ]);

        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'ref_number' => $request->get('ref_number'),
            'issue_date' => $request->get('issue_date'),
            'customer_id' => $request->get('customer_id'),
            'agent_id' => $request->get('agent_id'),
            'supplier_id' => $request->get('supplier_id'),
            'received_amount' => $request->get('received_amount'),
        ]);

        $serviceIds = $request->get('service_ids');
        $salesRates = $request->get('sales_rates');
        $supplierRates = $request->get('supplier_rates');
        $agentCommissions = $request->get('agent_commissions');
        $taxes = $request->get('taxes');
        $remarks = $request->get('remarks');
        $quantities = $request->get('quantities');

        $invoice->services()->delete();

        foreach ($serviceIds as $key => $serviceId) {
            if (@$salesRates[$key] != null) {
                InvoiceService::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $serviceId,
                    'sales_rate' => @$salesRates[$key],
                    'quantity' => @$quantities[$key],
                    'supplier_rate' => @$supplierRates[$key],
                    'agent_commission' => @$agentCommissions[$key],
                    'tax_percentage' => @$taxes[$key],
                    'remarks' => $remarks[$key],
                ]);
            }
        }

        return back()->with('success', 'Invoice Updated');
    }

    public function dueCollection(Request $request)
    {
        $invoiceId = Invoice::query()
                ->where('type', authUserServiceType())
                ->latest()->first()?->invoice_no + 1;

        $moreServices = $request->get('moreServices');

        $type = authUserServiceType()->value;

        $travelTourismServices = Service::where('type', $type)->get();
        $documentClearingServices = Service::where('type', $type)->get();

        $invoices = Invoice::query()
            ->where('type', $type)
            ->latest()
            ->get();

        $invoiceEditId = $request->get('invoiceEditId');
        $invoiceEdit = Invoice::find($invoiceEditId);

        $customers = Customer::query()
            ->where('type', $type)
            ->get();

        $agents = Agent::query()
            ->where('type', $type)
            ->get();
        $suppliers = Supplier::query()
            ->where('type', $type)
            ->get();

        return view('invoices.due-collection', compact(
                'travelTourismServices',
                'documentClearingServices',
                'invoiceId',
                'invoices',
                'invoiceEdit',
                'customers',
                'agents',
                'suppliers',
                'type',
                'moreServices',
            )
        );
    }

    public function storeDuePayment(Request $request, $invoiceId)
    {
        $request->validate([
            'amount' => 'required',
            'date' => 'required',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);

        if (authUser()->service_type != $invoice->type) {
            return back()->with('error', 'Permission deny!');
        }

        InvoiceDuePayment::create([
            'invoice_id' => $invoiceId,
            'amount' => $request->get('amount'),
            'date' => $request->get('date'),
            'remarks' => $request->get('remarks'),
            'issued_by_user_id' => authUser()->id,
        ]);

        DrawerCash::create([
            'type' => authUserServiceType(),
            'in_amount' => $request->get('amount'),
            'invoice_id' => $invoice->id,
            'remarks' => "Due Collection of Invoice",
            'deposit_source_id' => DepositSource::DUE_COLLECTION,
            'created_by_user_id' => authUser()->id,
        ]);

        return back()->with('success', 'Invoice Due Payment Created');
    }

    public function duePaymentReport(Request $request)
    {
        $type = authUser()->service_type;

        $q = $request->get('q');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $invoicesIdsQuery = Invoice::query()
            ->where('type', $type);

        if ($q) {
            $invoicesIdsQuery->where('invoice_no', $q);
        }

        $invoicesIds = $invoicesIdsQuery->pluck('id');

        $payments = InvoiceDuePayment::query()
            ->with(['invoice'])
            ->whereIn('invoice_id', $invoicesIds);

        if ($fromDate) {
            $payments->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $payments->whereDate('date', '<=', $toDate);
        }

        $payments = $payments->latest()->paginate(50);

        return view('invoices.reports.due_payments', compact(
                'payments',
            )
        );
    }

    public function collectToBank($id)
    {
        $invoice = Invoice::findOrFail($id);

        if (authUser()->service_type != $invoice->type) {
            return back()->with('error', 'Permission deny!');
        }

        $banks = Bank::query()
            ->where('type', authUserServiceType())
            ->get();

        return view('invoices.collect-to-bank', compact('invoice', 'banks'));
    }

    public function storeCollectToBank(Request $request, $invoiceId)
    {
        $request->validate([
            'amount' => 'required',
            'date' => 'required',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);

        if (authUser()->service_type != $invoice->type) {
            return back()->with('error', 'Permission deny!');
        }

       $payment = InvoiceDuePayment::create([
            'invoice_id' => $invoiceId,
            'amount' => $request->get('amount'),
            'date' => $request->get('date'),
            'remarks' => $request->get('remarks'),
            'issued_by_user_id' => authUser()->id,
        ]);

        CashAtBank::create([
            'invoice_due_payment_id' => $payment->id,
            'type' => authUser()->service_type,
            'bank_id' => $request->get('bank_id'),
            'out_amount' => $request->get('amount'),
            'date' => $request->get('date'),
            'created_by_user_id' => authUser()->id
        ]);

        return back()->with('success', 'Collect to Bank Successfully Created');
    }

}
