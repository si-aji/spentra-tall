<?php

namespace App\Http\Controllers\Api\Sys\v0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecordTemplateController extends Controller
{
    protected $recordTemplateModel;
    public function __construct()
    {
        $this->recordTemplateModel = new \App\Models\RecordTemplate();
    }

    /**
     * Record Template List
     * 
     */
    public function list(Request $request)
    {
        $data = $this->recordTemplateModel->query()
            ->where('user_id', \Auth::user()->id);

        if ($request->has('force_order_column') && ! empty($request->force_order_column)) {
            $data->orderBy($request->force_order_column, $request->force_order ?? 'asc');
        }

        if($request->has('is_datatable') && $request->is_datatable != ''){
            $dt = datatables()
                ->of($data->with('category', 'wallet.parent', 'walletTransferTarget.parent'));

            return $dt
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
