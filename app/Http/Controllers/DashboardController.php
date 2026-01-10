<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Reservation;
use App\Models\Project;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard based on their role.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Admin dashboard
        if ($user->role === 'admin') {
            return $this->adminDashboard($user);
        }

        // General user dashboard
        return $this->userDashboard($user);
    }

    /**
     * Admin dashboard with system-wide statistics
     */
    private function adminDashboard($user)
    {
        $data = [
            'pendingUsersCount' => User::where('status', 'pending')->count(),
            'pendingReservationsCount' => Reservation::where('status', 'pending')->count(),
            'totalMaterialsCount' => Material::count(),
            'activeUsersCount' => User::where('status', 'active')->count(),
            'recentReservations' => Reservation::with('material', 'user')
                ->latest()
                ->take(5)
                ->get(),
            'lowStockMaterials' => Material::where('quantity', '<', 5)
                ->take(5)
                ->get(),
            'pendingUsers' => User::where('status', 'pending')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('dashboard.admin', $data);
    }

    /**
     * General user dashboard with personalized data
     */
    private function userDashboard($user)
    {
        $data = [
            'myReservationsCount' => Reservation::where('user_id', $user->id)->count(),
            'availableMaterialsCount' => Material::where('status', 'available')
                ->where('quantity', '>', 0)
                ->count(),
            'myProjectsCount' => Project::where('created_by', $user->id)
                ->orWhereHas('members', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->count(),
            'upcomingEventsCount' => Event::where('event_date', '>', now())
                ->count(),
            'recentReservations' => Reservation::where('user_id', $user->id)
                ->with('material')
                ->latest()
                ->take(5)
                ->get(),
            'recentNotifications' => $user->notifications()
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('dashboard.index', $data);
    }
}
