<?php

namespace App\Http\Controllers;

use App\Models\invoices_archive;
use Illuminate\Http\Request;
use App\Models\invoices;

class InvoicesArchiveController extends Controller
{

    public function index()
    {
        $invoices=invoices::onlyTrashed()->get();
        return view('invoices.Archive_invoice', [
            'invoices' => $invoices,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(invoices_archive $invoices_archive)
    {
        //
    }

    public function edit(invoices_archive $invoices_archive)
    {
        //
    }


    public function update(Request $request)
    {
         $id = $request->invoice_id;
         Invoices::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }

    public function destroy(Request $request)
    {
        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/Archive');
    }
}
