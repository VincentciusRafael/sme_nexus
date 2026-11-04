<?php

namespace App\Http\Controllers\BusinessAutopsy\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessAutopsy\StoreUserRequest;
use App\Http\Requests\BusinessAutopsy\UpdateUserRequest;
use App\Models\User;
use App\Services\BusinessAutopsy\UserService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    private const ROLES = [
        'sme_owner' => 'Pemilik UMKM',
        'mentor' => 'Mentor',
        'investor' => 'Investor',
        'admin' => 'Admin',
        'user' => 'Pengguna',
    ];

    public function __construct(private readonly UserService $users) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'role', 'is_verified']);

        if (($filters['is_verified'] ?? '') === '') {
            $filters['is_verified'] = null;
        }

        return view('business-autopsy.admin.users.index', [
            'users' => $this->users->paginate($filters),
            'filters' => $filters,
            'roles' => self::ROLES,
        ]);
    }

    public function create(): View
    {
        return view('business-autopsy.admin.users.form', [
            'user' => new User(['role' => 'sme_owner', 'is_verified' => true]),
            'roles' => self::ROLES,
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_verified'] = $request->boolean('is_verified');

        $this->users->create($data);

        return redirect()
            ->route('admin.business-autopsy.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('business-autopsy.admin.users.form', [
            'user' => $user,
            'roles' => self::ROLES,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $data['is_verified'] = $request->boolean('is_verified');

        $this->users->update($user, $data);

        return redirect()
            ->route('admin.business-autopsy.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->users->delete($user);

            return redirect()
                ->route('admin.business-autopsy.users.index')
                ->with('success', 'Pengguna berhasil dihapus.');
        } catch (DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
