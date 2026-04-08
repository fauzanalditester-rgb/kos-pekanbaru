<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';
    public $showModal = false;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ];

    public function openModal()
    {
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function updatePassword()
    {
        $this->validate();

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak benar.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->closeModal();
        session()->flash('message', 'Password berhasil diubah!');
    }

    public function render()
    {
        return view('livewire.admin.change-password');
    }
}
