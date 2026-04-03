<?php

namespace App\Livewire\Customer;

use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Profil extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $emergency_contact = '';
    public $newPassword = '';
    public $currentPassword = '';
    public $idCardPhoto = null;
    public $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string',
        'emergency_contact' => 'nullable|string',
        'currentPassword' => 'nullable|required_with:newPassword',
        'newPassword' => 'nullable|min:8',
        'idCardPhoto' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        if ($user->tenant) {
            $this->phone = $user->tenant->phone;
            $this->address = $user->tenant->address;
            $this->emergency_contact = $user->tenant->emergency_contact;
        }
    }

    public function render()
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        return view('livewire.customer.profil', [
            'user' => $user,
            'tenant' => $tenant,
        ])->layout('layouts.customer', ['title' => 'Profil Saya']);
    }

    public function openEditModal()
    {
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->newPassword = '';
        $this->currentPassword = '';
        $this->idCardPhoto = null;
        $this->resetValidation();
    }

    public function saveProfile()
    {
        $this->validate();

        $user = Auth::user();

        // Update user basic info
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        // Update password if provided
        if ($this->newPassword) {
            if (!password_verify($this->currentPassword, $user->password)) {
                $this->addError('currentPassword', 'Password saat ini tidak benar.');
                return;
            }
            $userData['password'] = bcrypt($this->newPassword);
        }

        $user->update($userData);

        // Update tenant info if exists
        if ($user->tenant) {
            $tenantData = [
                'phone' => $this->phone,
                'address' => $this->address,
                'emergency_contact' => $this->emergency_contact,
            ];

            if ($this->idCardPhoto) {
                $tenantData['id_card_photo'] = $this->idCardPhoto->store('id-cards', 'public');
            }

            $user->tenant->update($tenantData);
        }

        $this->closeEditModal();
        session()->flash('message', 'Profil berhasil diperbarui!');
    }
}
