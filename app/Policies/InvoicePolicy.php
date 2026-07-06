<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('invoice.viewAny');
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $user->can('invoice.view');
    }

    public function create(User $user): bool
    {
        return $user->can('invoice.create');
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $user->can('invoice.update');
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $user->can('invoice.delete');
    }
}
