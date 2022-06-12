<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use Auth;
use Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->product  = New Product();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
          'product_name' => 'required',
          'product_desc' => 'required',
          'product_picture' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if($request->file('product_picture')) {
          $file = $request->file('product_picture');
          $fileName = time() . '.' . $file->extension();
          $path = 'upload/' . $fileName;
          Storage::putFileAs('public/upload', $file, $fileName);
        }

        $product = $this->product->create([
          'user_id' => Auth::id(),
          'product_name' => $request->product_name,
          'product_desc' => $request->product_desc,
          'product_picture' => $path
        ]);

        return response()->json([
          'success' => 200,
          'product' => $product
        ]);
    }

}
