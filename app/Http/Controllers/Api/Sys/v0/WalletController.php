<?php

namespace App\Http\Controllers\Api\Sys\v0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected $walletModel;
    public function __construct()
    {
        $this->walletModel = new \App\Models\Wallet();
    }

    /**
     * Wallet List
     * 
     */
    public function list(Request $request)
    {
        $data = $this->walletModel->query()
            ->where('user_id', \Auth::user()->id);

        if ($request->has('force_order_column') && ! empty($request->force_order_column)) {
            $data->orderBy($request->force_order_column, $request->force_order ?? 'asc');
        }

        if($request->has('is_datatable') && $request->is_datatable != ''){
            $dt = datatables()
                ->of($data->with('parent'))
                ->addColumn('balance', function ($data) {
                    return $data->getBalance();
                })
                ->addColumn('last_record', function ($data) {
                    $data = $data->record()
                        ->orderBy('datetime', 'desc')
                        ->orderBy('id', 'desc')
                        ->first();
    
                    return ! empty($data) ? json_encode($data) : null;
                });

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
