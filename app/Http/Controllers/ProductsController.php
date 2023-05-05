<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
   
    public function index()
    {
        $products=products::all();
        $sections=sections::all();
        return view('products.products',[
            'products'=>$products,
            'sections'=>$sections
        ]);
    }

   
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        Products::create([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }

    
    public function show(products $products)
    {
        //
    }

  
    public function edit(products $products)
    {
        //
    }

  
    public function update(Request $request, products $products)
    {
        //
    }

    public function ModalUpdate(Request $request)
    {
        
        $section_id=sections::where('section_name','=',$request->section_name)->first()->id;
        $product=products::findOrFail($request->pro_id);
        $product->update([
            'product_name'=>$request->product_name,
            'section_id'=> $section_id,
            'description'=>$request->description,
        ]);
        session()->flash('Edit', 'تم تعديل المنتج بنجاح ');
        return back();
    }
    public function destroy(products $products)
    {
        //
    }

    public function ModalDelete(Request $request)
    {
        $id = $request->pro_id;
        products::findOrFail($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return back();
        
    }
    
}
