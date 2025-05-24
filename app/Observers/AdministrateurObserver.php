<?php

namespace App\Observers;

use App\Models\Administrateur;

class AdministrateurObserver
{
    public function saving(Administrateur $admin) {
        $admin->name = ucfirst($admin->lastname) . ' ' . ucfirst($admin->firstname);
    }
}
