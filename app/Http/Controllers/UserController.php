<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\trah;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        $admin = User::where('role', 'admin')->get();
        $admincount = count($admin);
        return view('admin.manage.user-management', compact('user', 'admincount'));
    }

    public function keluarga()
    {
        $user = auth()->user();

        // Hanya ambil trah yang dibuat oleh user ini
        $trah = Trah::where('created_by', $user->name)
            ->withCount('anggotaKeluarga') // Contoh: hitung jumlah anggota
            ->latest()
            ->get();

        return view('user.keluarga', compact('user', 'trah'));
    }
}
