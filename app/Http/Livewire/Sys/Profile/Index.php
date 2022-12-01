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

    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    public $extraMenu = [];
    // Form Field
    public $name = '';
    public $username = '';
    public $email = '';
    public $avatar = '';
    public $photo;
    // 
    public $deletePassword = '';

    /**
     * Validation
     */
    protected $rules = [
        'name' => ['required'],
        'username' => ['required', 'alpha_dash'],
        'email' => ['required', 'email'],
        'photo' => ['nullable', 'image', 'max:500', 'mimes:jpeg,jpeg,png']
    ];

    /**
     * Livewire Event Listener
     */
    // 

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->menuState = 'profile';
        $this->submenuState = 'account';

        $this->name = \Auth::user()->name;
        $this->username = \Auth::user()->username;
        $this->email = \Auth::user()->email;
        $this->avatar = \Auth::user()->getProfilePicture();

        $extraMenu = collect(config('siaji.sys.sidebar'))
            ->where('name', 'Profile')
            ->first();

        if(!empty($extraMenu) && count($extraMenu['sub']) > 0){
            foreach($extraMenu['sub'] as $menu){
                $this->extraMenu[] = $menu;
            }
        }
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        return view('livewire.sys.profile.index')
            ->extends('layouts.sneat', [
                'menuState' => $this->menuState,
                'submenuState' => $this->submenuState
            ]);
    }

    /**
     * Function
     */
    // Save to database
    public function save()
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
    // Check if password is match
    public function checkAccount()
    {
        $checkPassword = \Hash::check($this->deletePassword, \Auth::user()->password);

        return [
            'result' => $checkPassword
        ];
    }
    public function deleteAccount()
    {
        \Auth::logout();
        return redirect()->route('home');
    }
    // Remove temp file
    public function removePhoto(): void
    {
        if($this->photo){
            if(\File::exists('livewire-tmp'.'/'.$this->photo->getFilename())){
                \Storage::delete('livewire-tmp'.'/'.$this->photo->getFilename());
            }

            $this->photo = null;
        }
    }
}
