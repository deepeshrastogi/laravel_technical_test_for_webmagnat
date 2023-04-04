<?php
namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Validator;

class ProductController extends Controller {
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * user registration through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'price' => 'required', 
            'attribute' => 'required', 
        ]);

        if ($validator->fails()) { 
            return $this->error($validator->errors());     
        }
        
        $productData = [
            'name' => $request->name,
            'price' => $request->price,
            'vat' => $request->vat,
        ];

        if ($request->hasfile('product_image')) {
            $file = $request->file('product_image');
            $name = $file->getClientOriginalName();  
            $file->move(public_path('uploads'), $name);
            $productData['product_image'] = url('/') . '/uploads/' . $name;
        }
        $productData["created_by"] = Auth::user()->id;
        $productData["quantity"] = !empty($request->quantity) ? $request->quantity : null ;
        $product = Product::create($productData);
        $attributes = explode(',',$request->attribute);
        $product->productAttributes()->attach($attributes);
        return $this->success(['product' => $product]);  

    }

    /**
     * user registration through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function getProductsList(Request $request) {
        $products = Product::with('productAttributes')->get();
        return $this->success(['products' => $products]);  
    }

     /**
     * user registration through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function getProduct(Request $request, $id) {
        $product = Product::with('productAttributes')->find($id);
        return $this->success(['product' => $product]);  
    }

    /**
     * user registration through post
     * @param  \Illuminate\Http\Request
     * @return [json] token object, through an error if user credentials are not valid
     */
    public function delete(Request $request, $id) {
        $product = Product::where(['id' => $id])->delete();
        return $this->success(['product' => $product]);  
    }

    
    

}
