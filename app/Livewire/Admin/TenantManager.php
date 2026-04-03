<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class TenantManager extends Component
{
    use WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $isEditing = false;
    public $tenantId = null;
    public $showIdCardModal = false;
    public $viewingTenant = null;
    public $idCardFile = null;

    // Form fields
    public $property_id = '';
    public $room_id = '';
    public $name = '';
    public $email = '';
    public $phone = '';
    public $id_card_number = '';
    public $address = '';
    public $move_in_date = '';
    public $move_out_date = '';
    public $status = 'active';
    public $deposit = 0;
    public $emergency_contact = '';

    protected $rules = [
        'property_id' => 'required|exists:properties,id',
        'room_id' => 'required|exists:rooms,id',
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'required|string|max:20',
        'id_card_number' => 'nullable|string|max:50',
        'address' => 'nullable|string',
        'move_in_date' => 'required|date',
        'move_out_date' => 'nullable|date',
        'status' => 'required|in:active,completed,cancelled',
        'deposit' => 'nullable|numeric|min:0',
        'emergency_contact' => 'nullable|string',
    ];

    public function render()
    {
        $activeTenants = Tenant::with(['property', 'room'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhereHas('room', function ($q) {
                          $q->where('code', 'like', '%' . $this->search . '%');
                      });
            })
            ->where('status', 'active')
            ->orderBy('move_in_date', 'desc')
            ->get();

        $completedTenants = Tenant::with(['property', 'room'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhereHas('room', function ($q) {
                          $q->where('code', 'like', '%' . $this->search . '%');
                      });
            })
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('move_out_date', 'desc')
            ->get();

        $properties = Property::all();
        $rooms = Room::where('property_id', $this->property_id)->where('status', 'available')->get();

        return view('livewire.admin.tenant-manager', [
            'activeTenants' => $activeTenants,
            'completedTenants' => $completedTenants,
            'properties' => $properties,
            'availableRooms' => $rooms,
        ])->layout('layouts.admin', ['title' => 'Penyewa']);
    }

    public function updatedPropertyId($value)
    {
        $this->room_id = '';
        $this->dispatch('property-changed');
    }
    
    protected $listeners = ['property-changed' => '$refresh'];


    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->isEditing = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function editTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $this->tenantId = $id;
        $this->property_id = $tenant->property_id;
        $this->room_id = $tenant->room_id;
        $this->name = $tenant->name;
        $this->email = $tenant->email;
        $this->phone = $tenant->phone;
        $this->id_card_number = $tenant->id_card_number;
        $this->address = $tenant->address;
        $this->move_in_date = $tenant->move_in_date?->format('Y-m-d');
        $this->move_out_date = $tenant->move_out_date?->format('Y-m-d');
        $this->status = $tenant->status;
        $this->deposit = $tenant->deposit;
        $this->emergency_contact = $tenant->emergency_contact;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function saveTenant()
    {
        $this->validate();

        $data = [
            'property_id' => $this->property_id,
            'room_id' => $this->room_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'id_card_number' => $this->id_card_number,
            'address' => $this->address,
            'move_in_date' => $this->move_in_date,
            'move_out_date' => $this->move_out_date ?: null,
            'status' => $this->status,
            'deposit' => $this->deposit,
            'emergency_contact' => $this->emergency_contact,
        ];

        if ($this->isEditing) {
            $tenant = Tenant::findOrFail($this->tenantId);
            $tenant->update($data);
            session()->flash('message', 'Penyewa berhasil diperbarui!');
        } else {
            $tenant = Tenant::create($data);
            
            // Update room status to occupied
            $room = Room::find($this->room_id);
            if ($room && $this->status === 'active') {
                $room->update(['status' => 'occupied']);
            }

            // AUTO-CREATE CUSTOMER ACCOUNT
            $this->autoCreateCustomerAccount($tenant);

            // AUTO-GENERATE FIRST INVOICE
            $this->autoGenerateFirstInvoice($tenant);
            
            session()->flash('message', 'Penyewa berhasil ditambahkan! Akun customer dan tagihan pertama otomatis dibuat.');
        }

        $this->closeModal();
    }

    public function deleteTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $room = $tenant->room;
        
        $tenant->delete();
        
        // Update room status back to available
        if ($room) {
            $room->update(['status' => 'available']);
        }
        
        session()->flash('message', 'Penyewa berhasil dihapus!');
    }

    public function checkoutTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->update([
            'status' => 'completed',
            'move_out_date' => now(),
        ]);
        
        // Update room status back to available
        $room = $tenant->room;
        if ($room) {
            $room->update(['status' => 'available']);
        }
        
        session()->flash('message', 'Penyewa berhasil checkout!');
    }

    public function openIdCardModal($id)
    {
        $this->viewingTenant = Tenant::findOrFail($id);
        $this->showIdCardModal = true;
        $this->idCardFile = null;
    }

    public function closeIdCardModal()
    {
        $this->showIdCardModal = false;
        $this->viewingTenant = null;
        $this->idCardFile = null;
    }

    public function uploadIdCard()
    {
        $this->validate([
            'idCardFile' => 'required|image|max:2048',
        ]);

        if ($this->viewingTenant) {
            $path = $this->idCardFile->store('id-cards', 'public');
            $this->viewingTenant->update(['id_card_photo' => $path]);
            $this->viewingTenant->refresh();
            $this->idCardFile = null;
            session()->flash('message', 'KTP berhasil diupload!');
        }
    }

    private function resetForm()
    {
        $this->tenantId = null;
        $this->property_id = '';
        $this->room_id = '';
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->id_card_number = '';
        $this->address = '';
        $this->move_in_date = '';
        $this->move_out_date = '';
        $this->status = 'active';
        $this->deposit = 0;
        $this->emergency_contact = '';
        $this->isEditing = false;
    }

    public function generateCustomerAccount($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);

        // Check if tenant already has a user account
        $existingUser = User::where('tenant_id', $tenantId)->first();
        if ($existingUser) {
            session()->flash('error', 'Penyewa ini sudah memiliki akun customer! Email: ' . $existingUser->email);
            return;
        }

        $this->autoCreateCustomerAccount($tenant);
        session()->flash('message', 'Akun customer berhasil dibuat!');
    }

    private function autoCreateCustomerAccount($tenant)
    {
        // Generate email from name
        $email = $tenant->email;
        if (!$email) {
            $emailBase = strtolower(str_replace(' ', '.', $tenant->name));
            $email = $emailBase . '@sewavip.com';
            
            // Check if email already exists, add number suffix
            $counter = 1;
            $originalEmail = $email;
            while (User::where('email', $email)->exists()) {
                $email = str_replace('@', $counter . '@', $originalEmail);
                $counter++;
            }
        }

        // Generate random password
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

        // Create user account
        $user = User::create([
            'name' => $tenant->name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => User::ROLE_CUSTOMER,
            'tenant_id' => $tenant->id,
        ]);

        // Store credentials in session for display
        session()->flash('customer_credentials', [
            'email' => $email,
            'password' => $password,
        ]);

        return $user;
    }

    private function autoGenerateFirstInvoice($tenant)
    {
        $room = $tenant->room;
        if (!$room) return;

        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($tenant->id, 4, '0', STR_PAD_LEFT);
        
        Invoice::create([
            'tenant_id' => $tenant->id,
            'room_id' => $room->id,
            'invoice_number' => $invoiceNumber,
            'issue_date' => now(),
            'due_date' => now()->addMonth(),
            'rent_amount' => $room->price_monthly ?? 0,
            'additional_amount' => 0,
            'total_amount' => $room->price_monthly ?? 0,
            'description' => 'Tagihan sewa kamar pertama',
            'status' => 'sent',
            'notes' => 'Auto-generated saat pendaftaran penyewa',
        ]);
    }
}
