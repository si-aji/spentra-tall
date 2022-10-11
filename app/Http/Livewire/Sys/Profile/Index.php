<?php

namespace App\Http\Livewire\Sys\Profile;

use Carbon\Carbon;
use App\Http\Traits\FileUploadTrait;

use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    use FileUploadTrait;

    public $menuState = null;
    public $submenuState = null;
    public $extraMenu = [];

    public $name = '';
    public $username = '';
    public $email = '';
    public $avatar = '';
    public $photo;

    protected $rules = [
        'name' => ['required'],
        'username' => ['required', 'alpha_dash'],
        'email' => ['required', 'email'],
        'photo' => ['nullable', 'image', 'max:500', 'mimes:jpeg,jpeg,png']
    ];

    public function mount()
    {
        $this->menuState = 'profile';
        $this->submenuState = 'account';

        $this->name = \Auth::user()->name;
        $this->username = \Auth::user()->username;
        $this->email = \Auth::user()->email;
        $this->avatar = \Auth::user()->getProfilePicture();

        $extraMenu = config('siaji.sys.sidebar')
            ->where('name', 'Profile')
            ->first();

        if(!empty($extraMenu) && count($extraMenu['sub']) > 0){
            foreach($extraMenu['sub'] as $menu){
                $this->extraMenu[] = $menu;
            }
        }
    }

    public function render()
    {
        return view('livewire.sys.profile.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState
        ]);
    }

    public function store()
    {
        $this->validate();

        $user = \Auth::user();
        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;

        if(!empty($this->photo) && $this->photo != \Auth::user()->getProfilePicture()){
            $destinationPath = 'files/user'.'/'.\Auth::user()->uuid;
            // Check if directory exists
            if (! (\File::exists($destinationPath))) {
                \File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Handle upload
            if(!empty($user->avatar)){
                // Remove old file
                if (\Storage::exists($user->avatar)) {
                    \Storage::delete($user->avatar);
                }
            }
            $user->avatar = $this->photo->store($destinationPath);
        }
        $user->save();

        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully update Profile data'
        ]);
    }
}
