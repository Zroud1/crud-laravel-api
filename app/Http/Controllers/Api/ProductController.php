<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\models\Product;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Support\Facades\Validator ;

class ProductController extends BaseController
{

    public function index()
    {
        $products =Product::all();
        return  $this->sendResponse('get All Product',ProductResource::collection($products));
    }





    public function store(Request $request)
    {
        $input = $request->all();
       $validator = Validator::make($input , [
        'name'=> 'required',
        'detail'=> 'required',
        'price'=> 'required'
       ]  );

         if ($validator->fails()) {
            return $this->sendError('Please validate error' ,$validator->errors() );
          }
         $product=new Product();
         $product->name =$input['name'];
         $product->detail =$input['detail'];
         $product->price =$input['price'];

         $product->save();


        return $this->sendResponse('Product created successfully',new ProductResource($product));
    }


    public function show($id)
    {
       $product=Product::find($id);
        if(is_null($product)){
            return $this->sendError('Product not found');
        }
        return $this->sendResponse(new ProductResource($product),'Product found successfully');
    }



    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
         'name'=> 'required',
         'detail'=> 'required',
         'price'=> 'required'
        ]  );

          if ($validator->fails()) {
             return $this->sendError('Please validate error' ,$validator->errors() );
           }

          $product->name =$input['name'];
          $product->price =$input['price'];
          $product->detail =$input['detail'];
          $product->save();
         return $this->sendResponse(new ProductResource($product),'Product updated successfully');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse('Product deleted successfully',new ProductResource($product));
    }
}
