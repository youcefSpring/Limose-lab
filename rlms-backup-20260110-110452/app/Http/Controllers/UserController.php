<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('research_group', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by role
        if ($request->has('role') && $request->role !== '') {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'research_group' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,pending,suspended,banned',
            'avatar' => 'nullable|image|max:2048',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($validated);

        // Assign roles
        $user->syncRoles($validated['roles']);

        return redirect()->route('users.index')->with('success', __('User created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load([
            'roles',
            'reservations' => fn($q) => $q->latest()->limit(5),
            'createdProjects' => fn($q) => $q->latest()->limit(5),
            'experiments' => fn($q) => $q->latest()->limit(5),
            'createdEvents' => fn($q) => $q->latest()->limit(5),
        ]);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'research_group' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,pending,suspended,banned',
            'avatar' => 'nullable|image|max:2048',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        // Update roles
        $user->syncRoles($validated['roles']);

        return redirect()->route('users.show', $user)->with('success', __('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', __('You cannot delete your own account.'));
        }

        // Delete avatar if exists
        if ($user->avatar) {
            \Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', __('User deleted successfully.'));
    }

    /**
     * Activate a user.
     */
    public function activate(User $user)
    {
        $user->update(['status' => 'active']);

        return redirect()->back()->with('success', __('User activated successfully.'));
    }

    /**
     * Suspend a user.
     */
    public function suspend(Request $request, User $user)
    {
        // Prevent suspending own account
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', __('You cannot suspend your own account.'));
        }

        $validated = $request->validate([
            'suspension_reason' => 'required|string|max:500',
            'suspended_until' => 'nullable|date|after:today',
        ]);

        $user->update([
            'status' => 'suspended',
            'suspension_reason' => $validated['suspension_reason'],
            'suspended_until' => $validated['suspended_until'] ?? null,
        ]);

        return redirect()->back()->with('success', __('User suspended successfully.'));
    }

    /**
     * Ban a user.
     */
    public function ban(Request $request, User $user)
    {
        // Prevent banning own account
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', __('You cannot ban your own account.'));
        }

        $validated = $request->validate([
            'suspension_reason' => 'required|string|max:500',
        ]);

        $user->update([
            'status' => 'banned',
            'suspension_reason' => $validated['suspension_reason'],
        ]);

        return redirect()->back()->with('success', __('User banned successfully.'));
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        $user = auth()->user();
        $user->load([
            'roles',
            'reservations' => fn($q) => $q->latest()->limit(10),
            'createdProjects' => fn($q) => $q->latest()->limit(10),
            'experiments' => fn($q) => $q->latest()->limit(10),
            'createdEvents' => fn($q) => $q->latest()->limit(10),
        ]);

        return view('users.profile', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'research_group' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'locale' => 'nullable|in:en,fr,ar',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('users.profile')->with('success', __('Profile updated successfully.'));
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', __('Current password is incorrect.'));
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.profile')->with('success', __('Password updated successfully.'));
    }
}
