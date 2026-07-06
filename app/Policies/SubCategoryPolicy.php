<?php

namespace App\Policies;

use App\Models\SubCategory;
use App\Models\User;

class SubCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('subcategory.view');
    }

    public function view(User $user, SubCategory $subCategory): bool
    {
        return $user->can('subcategory.view');
    }

    public function create(User $user): bool
    {
        return $user->can('subcategory.create');
    }

    public function update(User $user, SubCategory $subCategory): bool
    {
        return $user->can('subcategory.update');
    }

    public function delete(User $user, SubCategory $subCategory): bool
    {
        return $user->can('subcategory.delete');
    }

}
