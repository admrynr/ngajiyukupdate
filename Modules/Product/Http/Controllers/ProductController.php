<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Helpers\Guzzle;
use Yajra\Datatables\Datatables;
use App\Http\Models\Product;
use App\Http\Models\Categories;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $title = 'Product Management';

        $category = Categories::all();
        
        return view('product::index', ['categories' => $category])->withTitle($title);
    }

    //get data for Edit
    public function edit($id, Request $request)
    {
        $data = Product::where('id', $id)->first();

        return json_encode($data);
    }

    //update data
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->product_name = $request->name;
        $product->product_type = $request->type;
        $product->categories_id = $request->category;
        $product->base_price = $request->base;
        $product->final_price = $request->final;
        $product->stock = $request->stock;

        if(!$product->update()){
            $data = [
                'status' => 2,
                'message' => 'Fail Update Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Update Data'
            ];
        }


        return json_encode($data);

    }

    //approve data
    public function approve($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->is_verified = 1;

        if(!$product->update()){
            $product = [
                'status' => 2,
                'message' => 'Fail Approve Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Approve Data'
            ];
        }

        return json_encode($data);
    }

    //decline data
    public function decline($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->is_verified = 0;

        if(!$product->update()){
            $data = [
                'status' => 2,
                'message' => 'Fail Update Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Update Data'
            ];
        }

        return json_encode($data);
    }

    //delete data
    public function destroy($id, Request $request)
    {
        $product = Product::where('id', $id);
        $product->delete();

        if(!$product->delete()){
            $data = [
                'status' => 2,
                'message' => 'Fail Update Data'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => 'Success Update Data'
            ];
        }

        return json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        $product->product_name = $request->name;
        $product->product_type = $request->type;
        $product->categories_id = $request->category;
        $product->base_price = $request->base;
        $product->final_price = $request->final;
        $product->stock = $request->stock;
        $product->is_verified = 0;
        $product->image = 'default.jpg';
        $product->save();

        $data = [
            'status' => 1,
            'message' => 'Success Update Data'
        ];

        return json_encode($data);
        
    }

    public function data(Request $request)
    {
        if ($request->filter == 'all')
        $product = Product::with('categories')->get();
        else if($request->filter == 'active')
        $product = Product::where('is_verified',1)->get();
        else if($request->filter == 'deactive')
        $product = Product::where('is_verified',0)->get();
        else
        $product = Product::onlyTrashed()->get();

        return datatables::of($product)->make(true);
    }

    //bulk data
    public function bulk($data, Request $request)
    {
        $datas = explode(',',$request->id);
        foreach($datas as $key){
            if($data == 'trash')
            $bulk = Product::where('id',$key)->delete();
            else if($data == 'activate')
            $bulk = Product::where('id',$key)->update(['is_verified'=>1]);
            else if($data == 'deactivate')
            $bulk = Product::where('id',$key)->update(['is_verified' => 0]);
            else if($data == 'restore')
            $bulk = Product::where('id',$key)->restore();
            else 
            $bulk = Product::where('id',$key)->forcedelete();
        }
        
        $data = [
            'status' => 1,
            'message' => 'Success Update Data'
        ];

        return json_encode($data);
    }

    //get info data
    public function info(Request $request)
    {
        $model = Product::all();

        $active = Product::where('is_verified',1)->count();
        $deactive = Product::where('is_verified',0)->count();;
        $total = $model->count();
        $trashed = Product::onlyTrashed()->count();

        $info = [
            'total' => $total,
            'active' => $active,
            'deactive' => $deactive,
            'trashed' => $trashed
        ];

        return json_encode($info);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('product::show');
    }

}
