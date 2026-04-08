<?php

namespace App\Livewire\Customer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AccountSettings extends Component
{
    public $activeTab = 'password'; // 'password' or 'email'
    public $showModal = false;
    
    // Password fields
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';
    
    // Email fields
    public $email_current_password = '';
    public $new_email = '';

    protected function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ];
    }

    public function openModal()
    {
        $this->reset(['current_password', 'new_password', 'new_password_confirmation', 'email_current_password', 'new_email']);
        $this->new_email = Auth::user()->email;
        $this->activeTab = 'password';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['current_password', 'new_password', 'new_password_confirmation', 'email_current_password', 'new_email']);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetErrorBag();
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak benar.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('message_password', 'Password berhasil diubah!');
    }

    public function updateEmail()
    {
        $this->validate([
            'email_current_password' => 'required',
            'new_email' => 'required|email|unique:users,email',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->email_current_password, $user->password)) {
            $this->addError('email_current_password', 'Password tidak benar.');
            return;
        }

        $user->update([
            'email' => $this->new_email,
        ]);

        $this->reset(['email_current_password']);
        $this->new_email = $user->fresh()->email;
        session()->flash('message_email', 'Email berhasil diubah! Silakan login ulang dengan email baru.');
    }

    public function render()
    {
        return view('livewire.customer.account-settings');
    }
}
