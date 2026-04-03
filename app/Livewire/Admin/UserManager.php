<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Tenant;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UserManager extends Component
{
    use WithPagination;

    public $showModal = false;
    public $isEditing = false;
    public $userId = null;

    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'admin';
    public $tenant_id = null;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:customer,admin,super_admin',
        'tenant_id' => 'nullable|exists:tenants,id',
    ];

    protected $messages = [
        'email.unique' => 'Email sudah digunakan.',
        'password.min' => 'Password minimal 8 karakter.',
    ];

    public function render()
    {
        $users = User::with('tenant')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tenants = Tenant::where('status', 'active')->get();

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'tenants' => $tenants,
        ])->layout('layouts.admin', ['title' => 'Manajemen User']);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->isEditing = false;
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'admin';
        $this->tenant_id = null;
        $this->resetValidation();
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->tenant_id = $user->tenant_id;
        $this->password = ''; // Don't fill password
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveUser()
    {
        if ($this->isEditing) {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->userId,
                'password' => 'nullable|min:8',
                'role' => 'required|in:customer,admin,super_admin',
                'tenant_id' => 'nullable|exists:tenants,id',
            ];
        } else {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'role' => 'required|in:customer,admin,super_admin',
                'tenant_id' => 'nullable|exists:tenants,id',
            ];
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'tenant_id' => $this->role === 'customer' ? $this->tenant_id : null,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEditing) {
            $user = User::findOrFail($this->userId);
            $user->update($data);
            session()->flash('message', 'User berhasil diperbarui!');
        } else {
            User::create($data);
            session()->flash('message', 'User berhasil dibuat!');
        }

        $this->closeModal();
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak bisa menghapus akun sendiri!');
            return;
        }

        // Prevent deleting the only super admin
        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            session()->flash('error', 'Tidak bisa menghapus super admin terakhir!');
            return;
        }

        $user->delete();
        session()->flash('message', 'User berhasil dihapus!');
    }

    public function updatedRole($value)
    {
        if ($value !== 'customer') {
            $this->tenant_id = null;
        }
    }
}
