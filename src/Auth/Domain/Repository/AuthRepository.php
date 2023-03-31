<?php

namespace CMS\Auth\Domain\Repository;

use CMS\Auth\Domain\Entity\User;
use Illuminate\Support\Facades\DB;

class AuthRepository
{
    public function __construct(
        private User $user
    ) {}

    public function getAll()
    {
        return DB::transaction(function () {

            return $this->user->all()->toArray();

        });
    }

    public function create(array $createUserDto)
    {
        return DB::transaction(function() use($createUserDto) {

            $user = $this->user->create($createUserDto);
            $user->assignRole($createUserDto['role']);
            return $user;

        });

    }

    public function update(int $id, array $updateUserDto)
    {
        return DB::transaction(function() use($id, $updateUserDto) {

            $user = $this->user->where('id', $id);

            if (array_key_exists('role', $updateUserDto)) {
                $user->first()->syncRoles([$updateUserDto['role']]);
                unset($updateUserDto['role']);
            }

            $user->update($updateUserDto);
            return $user->with('roles')->first();

        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function() use($id) {

            $user = $this->user->where('id', $id);
            $user->first()->syncRoles([]);
            return $user->delete();

        });
    }
}