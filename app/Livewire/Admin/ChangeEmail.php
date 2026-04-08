<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangeEmail extends Component
{
    public $current_password = '';
    public $new_email = '';
    public $showModal = false;

    protected $rules = [
        'current_password' => 'required',
        'new_email' => 'required|email|unique:users,email',
    ];

    public function openModal()
    {
        $this->reset(['current_password', 'new_email']);
        $this->new_email = Auth::user()->email;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['current_password', 'new_email']);
    }

    public function updateEmail()
    {
        $this->validate();

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password tidak benar.');
            return;
        }

        $user->update([
            'email' => $this->new_email,
        ]);

        $this->closeModal();
        session()->flash('message', 'Email berhasil diubah! Silakan login ulang.');
    }

    public function render()
    {
        return view('livewire.admin.change-email');
    }
}
