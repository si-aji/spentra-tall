<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'as' => 'sys.',
    'middleware' => ['web', 'auth:web']
], function(){
    // Manual
    Route::group([
        'prefix' => 'manual',
        'as' => 'manual.'
    ], function($q){
        // Fetch related record
        Route::get('related-record', function(){
            $id = request()->has('id') ? request()->id : 1;
            $data = \App\Models\Record::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Data Fetched',
                'result' => [
                    'data' => $data,
                    'related' => $data->getRelatedTransferRecord()
                ]
            ]);
        });

        // Run migration from v1 to v2
        Route::get('migrate-from-v1', function(){
            $users = \App\Models\User::where('is_migrated', false)
                ->whereHas('record')
                ->get();
            foreach($users as $user){
                // Record
                foreach($user->record as $record){
                    if($record->timezone_offset == '-480'){
                        // Modify Datetime, convert to utc
                        $raw = date('Y-m-d H:i:00', strtotime($record->datetime));
                        // Convert to UTC
                        $utc = convertToUtc($raw, ($record->timezone_offset));
                        $datetime = date('Y-m-d H:i:00', strtotime($utc));

                        // Update Data
                        $record->date = date("Y-m-d", strtotime($datetime));
                        $record->time = date("H:i:s", strtotime($datetime));
                        $record->datetime = date("Y-m-d H:i:s", strtotime($datetime));
                        $record->save();
                    }
                }

                // Planned Payment Record
                foreach($user->plannedPayment as $plannedPayment){
                    foreach($plannedPayment->plannedPaymentRecord as $plannedPaymentRecord){
                        if(!empty($plannedPaymentRecord->confirmed_at)){
                            // Modify Datetime, convert to utc
                            $raw = date('Y-m-d H:i:00', strtotime($plannedPaymentRecord->confirmed_at));
                            // Convert to UTC
                            $utc = convertToUtc($raw, ($plannedPaymentRecord->timezone_offset));
                            $datetime = date('Y-m-d H:i:00', strtotime($utc));

                            // Update Data
                            $plannedPaymentRecord->confirmed_at = date("Y-m-d H:i:s", strtotime($datetime));
                            $plannedPaymentRecord->save();
                        }
                    }
                }

                // State that user already migrated
                $user->is_migrated = true;
                $user->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Updated',
                'result' => [
                    'count' => count($users)
                ]
            ]);
        });
    });

    // Dashboard
    Route::get('/', \App\Http\Livewire\Sys\Dashboard\Index::class)
        ->name('index');

    // Planned Payment
    Route::get('planned-payment/{uuid}', \App\Http\Livewire\Sys\PlannedPayment\Show::class)
        ->name('planned-payment.show');
    Route::get('planned-payment', \App\Http\Livewire\Sys\PlannedPayment\Index::class)
        ->name('planned-payment.index');

    // Record
    Route::group([
        'as' => 'record.',
        'prefix' => 'record'
    ], function(){
        // Template
        Route::get('template/{uuid}', \App\Http\Livewire\Sys\Record\Template\Show::class)
            ->name('template.show');
        Route::get('template', \App\Http\Livewire\Sys\Record\Template\Index::class)
            ->name('template.index');
    });
    Route::get('record/{uuid}', \App\Http\Livewire\Sys\Record\Show::class)
        ->name('record.show');
    Route::get('record', \App\Http\Livewire\Sys\Record\Index::class)
        ->name('record.index');

    // Wallet
    Route::group([
        'prefix' => 'wallet',
        'as' => 'wallet.'
    ], function(){
        // List
        Route::get('list/re-order', \App\Http\Livewire\Sys\Wallet\Lists\ReOrder::class)
            ->name('list.re-order');
        Route::get('list', \App\Http\Livewire\Sys\Wallet\Lists\Index::class)
            ->name('list.index');
        // Group
        Route::get('group/{uuid}', \App\Http\Livewire\Sys\Wallet\Group\Show::class)
        ->name('group.show');
        Route::get('group', \App\Http\Livewire\Sys\Wallet\Group\Index::class)
        ->name('group.index');
    });

    // Profile
    Route::get('profile', \App\Http\Livewire\Sys\Profile\Index::class)
        ->name('profile.index');
    // Category
    Route::get('category/re-order', \App\Http\Livewire\Sys\Profile\Category\ReOrder::class)
        ->name('category.re-order');
    Route::get('category', \App\Http\Livewire\Sys\Profile\Category\Index::class)
        ->name('category.index');
    // Tags
    Route::get('tag', \App\Http\Livewire\Sys\Profile\Tag\Index::class)
        ->name('tag.index');
});