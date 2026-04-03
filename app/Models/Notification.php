<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'link',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    // Types
    const TYPE_PAYMENT_PENDING = 'payment_pending';
    const TYPE_PAYMENT_VERIFIED = 'payment_verified';
    const TYPE_INVOICE_CREATED = 'invoice_created';
    const TYPE_INVOICE_PAID = 'invoice_paid';
    const TYPE_TENANT_REGISTERED = 'tenant_registered';
    const TYPE_CHECKOUT_REMINDER = 'checkout_reminder';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function notifyAdmins($type, $title, $message, $data = [], $link = null)
    {
        $admins = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])->get();
        
        foreach ($admins as $admin) {
            self::create([
                'user_id' => $admin->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
                'link' => $link,
                'is_read' => false,
            ]);
        }
    }

    public static function notifyCustomer($customerId, $type, $title, $message, $data = [], $link = null)
    {
        self::create([
            'user_id' => $customerId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'link' => $link,
            'is_read' => false,
        ]);
    }

    public function getIconAttribute()
    {
        return match($this->type) {
            self::TYPE_PAYMENT_PENDING => 'clock',
            self::TYPE_PAYMENT_VERIFIED => 'check-circle',
            self::TYPE_INVOICE_CREATED => 'document-text',
            self::TYPE_INVOICE_PAID => 'currency-dollar',
            self::TYPE_TENANT_REGISTERED => 'user-add',
            self::TYPE_CHECKOUT_REMINDER => 'exclamation',
            default => 'bell',
        };
    }

    public function getIconColorAttribute()
    {
        return match($this->type) {
            self::TYPE_PAYMENT_PENDING => 'text-yellow-400',
            self::TYPE_PAYMENT_VERIFIED => 'text-green-400',
            self::TYPE_INVOICE_CREATED => 'text-blue-400',
            self::TYPE_INVOICE_PAID => 'text-[#0d9488]',
            self::TYPE_TENANT_REGISTERED => 'text-purple-400',
            self::TYPE_CHECKOUT_REMINDER => 'text-red-400',
            default => 'text-gray-400',
        };
    }
}
