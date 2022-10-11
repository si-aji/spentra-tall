<?php

namespace App\Http\Controllers\Api\Sys\v0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagModel;
    public function __construct()
    {
        $this->tagModel = new \App\Models\Tag();
    }

    /**
     * Tag List
     * 
     */
    public function list(Request $request)
    {
        $data = $this->tagModel->query()
            ->where('user_id', \Auth::user()->id);

        if ($request->has('force_order_column') && ! empty($request->force_order_column)) {
            $data->orderBy($request->force_order_column, $request->force_order ?? 'asc');
        }

        if($request->has('is_datatable') && $request->is_datatable != ''){
            $dt = datatables()
                ->of($data);

            return $dt
                ->filterColumn('name', function ($query, $keyword) {
                    return $query->where('name', 'like', '%'.$keyword.'%');
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
