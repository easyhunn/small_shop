<?php

namespace App\Policies;

use App\Cart;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any carts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        foreach($user->roles as $role) {
            if(in_array($role->role, ['admin']))
                return true;
        }
    }

    /**
     * Determine whether the user can view the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function view(User $user, Cart $cart)
    {
        //
        return true;

    }
    public function viewProcess(User $user, $id)
    {
        //
        return true;
        foreach($user->roles as $role) {
            if(in_array($role->role, ['admin']))
                return true;
        }
        if ($user->id == $id)
            return true;
    }

    /**
     * Determine whether the user can create carts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function update(User $user, Cart $cart)
    {
        //
    }

    /**
     * Determine whether the user can delete the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function delete(User $user, Cart $cart)
    {
        //

        if($cart->status != 2)
            return true;
        foreach($user->roles as $role) {
            if(in_array($role->role, ['admin']))
                return true;
        }
    }

    /**
     * Determine whether the user can restore the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function restore(User $user, Cart $cart)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function forceDelete(User $user, Cart $cart)
    {
        //
    }
}
