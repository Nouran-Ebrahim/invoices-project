<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class InvoicesDetailsController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(invoices_details $invoices_details)
    {
        //
    }

    public function getdetails($id)
    {
        $details = invoices_details::where('invoice_id', '=', $id)->get();
        $invoices = invoices::where('id', $id)->first();
        $attachments  = invoice_attachments::where('invoice_id', $id)->get();
        return view('invoices.invoice_details', [
            'details' => $details,
            'invoices' => $invoices,
            'attachments' => $attachments,
        ]);
    }
    public function open_file($invoice_number, $file_name)
    {
     
        $path = public_path('Attachments/'.$invoice_number.'/'.$file_name);
        return response()->file($path);
    }

    public function get_file($invoice_number, $file_name)
    {
        $contents= public_path('Attachments/'.$invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }
    public function edit(invoices_details $invoices_details)
    {
    }

    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }


    public function destroy(Request $request)
    {
        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        //response()->delete(public_path('Attachments/'.$request->invoice_number.'/'.$request->file_name));
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }
}
