<?php

namespace App\Http\Controllers\BusinessAutopsy\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessAutopsy\StoreSmeProfileRequest;
use App\Http\Requests\BusinessAutopsy\UpdateSmeProfileRequest;
use App\Models\SmeProfile;
use App\Services\BusinessAutopsy\BusinessCategoryService;
use App\Services\BusinessAutopsy\SmeProfileService;
use App\Services\BusinessAutopsy\UserService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SmeProfileController extends Controller
{
    public function __construct(
        private readonly SmeProfileService $profiles,
        private readonly BusinessCategoryService $categories,
        private readonly UserService $users,
    ) {}

    public function index(Request $request): View
    {
        return view('business-autopsy.admin.profiles.index', [
            'profiles' => $this->profiles->paginate($request->only(['search', 'id_category', 'id_user'])),
            'filters' => $request->only(['search', 'id_category', 'id_user']),
            'categories' => $this->categories->all(),
            'owners' => $this->users->owners(),
        ]);
    }

    public function create(): View
    {
        return view('business-autopsy.admin.profiles.form', [
            'profile' => new SmeProfile(['established_year' => date('Y')]),
            'categories' => $this->categories->all(),
            'owners' => $this->users->owners(),
        ]);
    }

    public function store(StoreSmeProfileRequest $request): RedirectResponse
    {
        $this->profiles->create($request->validated());

        return redirect()
            ->route('admin.business-autopsy.profiles.index')
            ->with('success', 'Profil UMKM berhasil ditambahkan.');
    }

    public function edit(SmeProfile $profile): View
    {
        return view('business-autopsy.admin.profiles.form', [
            'profile' => $profile,
            'categories' => $this->categories->all(),
            'owners' => $this->users->owners(),
        ]);
    }

    public function update(UpdateSmeProfileRequest $request, SmeProfile $profile): RedirectResponse
    {
        $this->profiles->update($profile, $request->validated());

        return redirect()
            ->route('admin.business-autopsy.profiles.index')
            ->with('success', 'Profil UMKM berhasil diperbarui.');
    }

    public function destroy(SmeProfile $profile): RedirectResponse
    {
        try {
            $this->profiles->delete($profile);

            return redirect()
                ->route('admin.business-autopsy.profiles.index')
                ->with('success', 'Profil UMKM berhasil dihapus.');
        } catch (DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
