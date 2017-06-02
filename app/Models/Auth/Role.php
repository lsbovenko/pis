<?php

namespace App\Models\Auth;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * @return string
     */
    public function getDisplayNameField() : string
    {
        return $this->name;
    }
}
