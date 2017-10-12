<?php

namespace App\Services\Roles;

use App\User;
use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Class Permissions
 * @package App\Services\Roles
 *
 * $permissions = new Permissions($gate);
 *
 * $permissions
 *    ->add('login-to-admin-panel', ['admin', 'manager'])
 *    ->add('admin', ['admin'])
 *    ->add('manager', ['admin', 'manager']);
 *
 * In html:
 * @can('login-to-admin-panel')
 *   <a href="/admin">Admin</a>
 * @endcan
 */
class Permissions
{
    /**
     * @var Gate
     */
    private $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    public function add(string $name, array $roles): Permissions
    {
        $this->gate->define($name, function (User $user) use ($roles) {
            return in_array($user->role, $roles);
        });

        return $this;
    }
}