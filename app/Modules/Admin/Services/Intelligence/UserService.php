<?php

namespace App\Modules\Admin\Services\Intelligence;

use App\Modules\Admin\Repositories\UserRepository;
use App\Modules\Intelligence\Services\AuditLogger;
use App\Shared\Models\User;
use DomainException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly AuditLogger $auditLogger,
    ) {}

    public function paginate(array $filters = [])
    {
        return $this->users->paginate($filters);
    }

    public function find(int $id): User
    {
        return $this->users->find($id);
    }

    public function owners()
    {
        return $this->users->owners();
    }

    public function ownersForSelection(?int $selectedId = null)
    {
        return $this->users->ownersForSelection($selectedId);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['is_verified'] = (bool) ($data['is_verified'] ?? false);

        $user = $this->users->create($data);

        $this->auditLogger->log(
            'admin.user.created',
            'user',
            $user->getKey(),
            [],
            Arr::except($data, ['password'])
        );

        return $user;
    }

    public function update(User $user, array $data): User
    {
        if (
            $user->getKey() === Auth::id()
            && $user->role === 'admin'
            && (
                ($data['role'] ?? 'admin') !== 'admin'
                || ! ($data['is_verified'] ?? true)
            )
        ) {
            throw new DomainException(
                'Anda tidak dapat menurunkan role atau menonaktifkan verifikasi akun sendiri.'
            );
        }

        $oldValues = $user->only([
            'full_name',
            'email',
            'role',
            'is_verified',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_verified'] = (bool) ($data['is_verified'] ?? false);

        $user = $this->users->update($user, $data);

        $this->auditLogger->log(
            'admin.user.updated',
            'user',
            $user->getKey(),
            $oldValues,
            Arr::except($data, ['password'])
        );

        return $user;
    }

    public function delete(User $user): void
    {
        if (Auth::id() === $user->getKey()) {
            throw new DomainException(
                'Anda tidak dapat menghapus akun sendiri.'
            );
        }

        if ($this->users->hasProfiles($user)) {
            throw new DomainException(
                'Pengguna masih memiliki profil UMKM. Nonaktifkan atau pindahkan profil terlebih dahulu.'
            );
        }

        $oldValues = $user->only([
            'full_name',
            'email',
            'role',
            'is_verified',
        ]);

        $userId = $user->getKey();

        $this->users->delete($user);

        $this->auditLogger->log(
            'admin.user.deleted',
            'user',
            $userId,
            $oldValues
        );
    }
}