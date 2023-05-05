<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\sections;
use App\Models\invoices;
use App\Models\products;
use App\Notifications\Add_invoice_new;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Notifications\Addinvoice;
use App\Exports\InvoicesExport;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\MyEventClass;

class InvoicesController extends Controller
{

    public function index()
    {
        $invoices = invoices::all();
        $sections = sections::all();
        return view('invoices.invoices', [
            'invoices' => $invoices,
            'sections' => $sections
        ]);
    }


    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', [
            'sections' => $sections
        ]);
    }

    public function getproducrs($id)
    {
        $products = products::where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_vat' => $request->Value_VAT,
            'rate_vat' => $request->Rate_VAT,
            'Total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        // $user = User::first();
        // Notification::send($user, new Addinvoice($invoice_id));
        // $user->notify(new Addinvoice($invoice_id));
        $user = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user, new Add_invoice_new($invoices));

        //event(new MyEventClass('hello world'));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }


    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }
    public function status_update($id,Request $request)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }


    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }


    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();

        $id_page = $request->id_page;


        if (!$id_page == 2) {

            if (!empty($Details->invoice_number)) {

                // Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
                File::deleteDirectory(public_path('Attachments/' . $Details->invoice_number));
            }

            $invoices->forceDelete(); //delete from database and ui
            session()->flash('delete_invoice');
            return redirect('/invoices');
        } else {

            $invoices->delete(); //still at database as archive with deleted at cloumn  and deleted from ui
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }
    }

    public function Invoice_Paid(){
        $invoices = invoices::where('value_status', 1)->get();
        return view('invoices.invoice_paid', [
            'invoices' => $invoices
        ]);
    }
    public function Invoice_UnPaid(){
        $invoices = invoices::where('value_status', 2)->get();
        return view('invoices.invoice_unpaid', [
            'invoices' => $invoices
        ]);
    }
    public function Invoice_Partial(){
        $invoices = invoices::where('value_status', 3)->get();
        return view('invoices.invoice_partial', [
            'invoices' => $invoices
        ]);
    }
    public function Print_invoice($id){
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoice', [
            'invoices' => $invoices
        ]);
    }
}
