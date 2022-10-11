<?php

namespace App\Http\Controllers\Api\Sys\v0;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletGroupController extends Controller
{
    protected $walletModel;
    protected $walletGroupModel;
    public function __construct()
    {
        $this->walletModel = new \App\Models\Wallet();
        $this->walletGroupModel = new \App\Models\WalletGroup();
    }

    /**
     * Wallet List
     * 
     */
    public function list(Request $request)
    {
        $data = $this->walletGroupModel->query()
            ->where('user_id', \Auth::user()->id);

        if ($request->has('force_order_column') && ! empty($request->force_order_column)) {
            $data->orderBy($request->force_order_column, $request->force_order ?? 'asc');
        }

        if($request->has('is_datatable') && $request->is_datatable != ''){
            $dt = datatables()
                ->of($data->with('walletGroupList.parent'));

            return $dt
                ->addColumn('balance', function($data){
                    return $data->getBalance();
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
