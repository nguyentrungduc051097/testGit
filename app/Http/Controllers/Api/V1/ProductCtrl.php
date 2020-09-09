<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductCtrl extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $listProduct = $this->product->all();
        return response()->json($listProduct);
    }

    // Thêm
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $validate = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'price' => 'required',
                'imagePath' => 'required'
            ],
                [
                    'title.required' => 'Không được để trống',
                    'description.required' => 'Không được để trống',
                    'price' => 'Giá tiền không được để trống',
                    'imagePath' => 'Hình ảnh không được bỏ trống'
                ]);
            if ($validate->fails()) {
                return response()->json($validate->getMessageBag(), 422);
            }

            if ($request->hasFile('imagePath')) {
                $file = $request->file('imagePath');
                $destinationPath = public_path('image/imagePath');
                $fileName = time() . '_' . $file->getClientOriginalName(); // thời gian upload + tên fule
                $file->move($destinationPath, $fileName);
            } else {
                $fileName = 'noname.jpg';
            }
        }
        DB::beginTransaction();
        try {
            $newId = $this->product->create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'imagePath' => $request->imagePath
            ]);
            DB::commit();
            return response()->json(["status" => true, 'id' => $newId], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Lỗi hệ thống"], 422);
        }
    }

    //Cập nhập

    public function update(Request $request, $id)
    {
        try {
            $productInfo = $this->product->find($id);
            $productInfo->title = $request->title;
            $productInfo->description = $request->description;
            $productInfo->price = $request->price;
            $productInfo->imagePath = $request->imagePath;
            $productInfo->save();
            return response()->json(["status" => true], 200);
        } catch (\Exception $e) {
            return response()->json(["massage" => "Lỗi hệ thống xin vui lòng thử lại"], 422);
        }
    }

    // Sửa thông tin
    public function detail($id)
    {
        $detailProduct = $this->product->find($id);
        return response()->json();
    }

    // Xóa
    public function delete($id)
    {
        $deleteProduct = $this->product->find($id);
        return response()->json();
    }
}
