<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'order_status' => 'sometimes|in:pending,paid,shipped,delivered,canceled',
            'payment_status' => 'sometimes|in:unpaid,paid,refunded',
        ];
    }
}
