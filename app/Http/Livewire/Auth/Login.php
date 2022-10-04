<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['required'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();

        $userKey = $this->usernameKeyValidate() ?? 'email';
        if (!Auth::attempt([$userKey => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        return redirect()->intended(route('sys.index'));
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }

    /**
     * Validate User Key, sign-in use username/email
     * 
     */
    private function usernameKeyValidate()
    {
        $key = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';;
        return $key;
    }
}
