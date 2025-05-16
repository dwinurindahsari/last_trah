<?php

namespace App\Http\Controllers;

use App\Models\Anggota_Keluarga;
use App\Models\Partner;
use App\Models\trah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KeluargaController extends Controller
{

    public function store(Request $request){
        $validated = $request->validate([
        'family_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'owner' => 'required|string|max:255',
        'password' => 'nullable|string|min:6'
    ]);

    $visibility = empty($validated['password']);

    $family = trah::create([
        'trah_name' => $validated['family_name'],    // mengambil dari input form
        'description' => $validated['description'] ?? null, // dari input dengan fallback null
        'created_by' => $validated['owner'],          // dari input form
        'password' => $validated['password'] ?? null,  // dari input dengan fallback null
        'visibility' => $visibility ? 'public' : 'private',                // dari perhitungan sebelumnya
    ]);
    return redirect()->route('admin.keluarga')
        ->with('success', 'Keluarga berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $family = Trah::findOrFail($id);
        
        $validated = $request->validate([
            'family_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'password' => 'nullable|string|min:6'
        ]);

        $visibility = empty($validated['password']) ? 'public' : 'private';

        $updateData = [
            'trah_name' => $validated['family_name'],
            'description' => $validated['description'] ?? null,
            'visibility' => $visibility
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        } else {
            unset($updateData['password']);
        }

        $family->update($updateData);
        
        return redirect()->route('admin.keluarga')
            ->with('success', 'Data keluarga berhasil diperbarui');
    } 
   
    public function delete($id){
         try {
            $trah = Trah::findOrFail($id);
            $trah->delete();

            return redirect()->route('admin.keluarga')
                ->with('success', 'Data trah berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->route('trah.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    public function detail_public($id)
    {
        // Ambil data trah beserta anggota keluarganya
        $trah = Trah::with(['anggotaKeluarga' => function($query) {
            $query->orderBy('urutan');
        }])->findOrFail($id);

        // Ambil hanya anggota keluarga yang terkait dengan trah ini
        $anggota_keluarga = $trah->anggotaKeluarga;
        
        // Ambil partner yang terkait dengan anggota keluarga ini
        $partner = Partner::whereIn('anggota_keluarga_id', $anggota_keluarga->pluck('id'))
                        ->orderBy('nama')
                        ->get();

        // Root member (anggota tanpa parent_id) dari trah ini saja
        $rootMember = $anggota_keluarga->whereNull('parent_id');
        
        // Root partner (partner tanpa anggota_keluarga_id) - ini mungkin perlu penyesuaian
        $rootPartner = $partner->whereNull('anggota_keluarga_id');

        return view('detail.public_detail', [
            'trahs' => $trah, // Menggunakan nama variabel yang konsisten
            'trah' => $trah, // Duplikat jika diperlukan untuk kompatibilitas
            'anggota_keluarga' => $anggota_keluarga,
            'existingMembers' => $anggota_keluarga, // Sama dengan anggota_keluarga
            'rootMember' => $rootMember,
            'rootPartner' => $rootPartner,
            'partner' => $partner
        ]);
    }

    public function detail_private($id, Request $request){
        $trah = Trah::with(['anggotaKeluarga' => function($query) {
            $query->orderBy('urutan');
        }])->findOrFail($id);

        // Ambil hanya anggota keluarga yang terkait dengan trah ini
        $anggota_keluarga = $trah->anggotaKeluarga;
        
        // Ambil partner yang terkait dengan anggota keluarga ini
        $partner = Partner::whereIn('anggota_keluarga_id', $anggota_keluarga->pluck('id'))
                        ->orderBy('nama')
                        ->get();

        // Root member (anggota tanpa parent_id) dari trah ini saja
        $rootMember = $anggota_keluarga->whereNull('parent_id');
        
        // Root partner (partner tanpa anggota_keluarga_id) - ini mungkin perlu penyesuaian
        $rootPartner = $partner->whereNull('anggota_keluarga_id');

        return view('detail.public_detail', [
            'trahs' => $trah, // Menggunakan nama variabel yang konsisten
            'trah' => $trah, // Duplikat jika diperlukan untuk kompatibilitas
            'anggota_keluarga' => $anggota_keluarga,
            'existingMembers' => $anggota_keluarga, // Sama dengan anggota_keluarga
            'rootMember' => $rootMember,
            'rootPartner' => $rootPartner,
            'partner' => $partner
        ]);
    }
    public function detail_private_user($id, Request $request){
        $trah = Trah::with(['anggotaKeluarga' => function($query) {
            $query->orderBy('urutan');
        }])->findOrFail($id);

        // Ambil hanya anggota keluarga yang terkait dengan trah ini
        $anggota_keluarga = $trah->anggotaKeluarga;
        
        // Ambil partner yang terkait dengan anggota keluarga ini
        $partner = Partner::whereIn('anggota_keluarga_id', $anggota_keluarga->pluck('id'))
                        ->orderBy('nama')
                        ->get();

        // Root member (anggota tanpa parent_id) dari trah ini saja
        $rootMember = $anggota_keluarga->whereNull('parent_id');
        
        // Root partner (partner tanpa anggota_keluarga_id) - ini mungkin perlu penyesuaian
        $rootPartner = $partner->whereNull('anggota_keluarga_id');

        return view('detail.public_detail', [
            'trahs' => $trah, // Menggunakan nama variabel yang konsisten
            'trah' => $trah, // Duplikat jika diperlukan untuk kompatibilitas
            'anggota_keluarga' => $anggota_keluarga,
            'existingMembers' => $anggota_keluarga, // Sama dengan anggota_keluarga
            'rootMember' => $rootMember,
            'rootPartner' => $rootPartner,
            'partner' => $partner
        ]);
    }

    public function checkPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $trah = Trah::findOrFail($id);

        // Debugging - Hapus setelah testing

        if (Hash::check($request->password, $trah->password)) {
            session(["trah_verified_$id" => true]);
            return redirect()->route('keluarga.detail.private', $id);
        }

        return back()->withErrors(['password' => 'Password salah!']); // Kembali ke modal dengan error
    }
    
    public function checkPassword2(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $trah = Trah::findOrFail($id);

        if (Hash::check($request->password, $trah->password)) {
            // Simpan status verifikasi di session
            session(["trah_verified_$id" => true]);
            return redirect()->route('user.keluarga.detail.private', $id);
        }

        return redirect()->route('user.keluarga')
            ->with('error','Password salah');
    }

    public function store_user(Request $request){
        $validated = $request->validate([
        'family_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'owner' => 'required|string|max:255',
        'password' => 'nullable|string|min:6'
    ]);

    $visibility = empty($validated['password']);

    $family = trah::create([
        'trah_name' => $validated['family_name'],    // mengambil dari input form
        'description' => $validated['description'] ?? null, // dari input dengan fallback null
        'created_by' => $validated['owner'],          // dari input form
        'password' => $validated['password'] ?? null,  // dari input dengan fallback null
        'visibility' => $visibility ? 'public' : 'private',                // dari perhitungan sebelumnya
    ]);
    return redirect()->route('user.keluarga')
        ->with('success', 'Keluarga berhasil dibuat');
    }

    public function update_user(Request $request, $id)
    {
        $family = Trah::findOrFail($id);
        
        $validated = $request->validate([
            'family_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'password' => 'nullable|string|min:6'
        ]);

        $visibility = empty($validated['password']) ? 'public' : 'private';

        $updateData = [
            'trah_name' => $validated['family_name'],
            'description' => $validated['description'] ?? null,
            'visibility' => $visibility
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        } else {
            unset($updateData['password']);
        }

        $family->update($updateData);
        
        return redirect()->route('user.keluarga')
            ->with('success', 'Data keluarga berhasil diperbarui');
    } 
   
    public function delete_user($id){
         try {
            $trah = Trah::findOrFail($id);
            $trah->delete();

            return redirect()->route('user.keluarga')
                ->with('success', 'Data trah berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->route('trah.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
