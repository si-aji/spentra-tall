<?php

namespace App\Http\Controllers\Api\Sys\v0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new \App\Models\Category();
    }

    /**
     * Category List
     * 
     */
    public function list(Request $request)
    {
        $data = $this->categoryModel->query()
            ->where('user_id', \Auth::user()->id);

        if ($request->has('force_order_column') && ! empty($request->force_order_column)) {
            $data->orderBy($request->force_order_column, $request->force_order ?? 'asc');
        }

        if($request->has('is_datatable') && $request->is_datatable != ''){
            $dt = datatables()
                ->of($data->with('parent'));

            return $dt
                ->filterColumn('name', function ($query, $keyword) {
                    return $query->where('name', 'like', '%'.$keyword.'%')
                        ->orWhereHas('parent', function ($query) use ($keyword) {
                            return $query->where('name', 'like', '%'.$keyword.'%');
                        });
                })
                ->toJson();
        }

        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => 'Data Fetched',
            'result' => [
                'data' => $data->get()
            ]
        ]);
    }
}
