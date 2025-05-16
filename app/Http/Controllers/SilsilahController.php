<?php

namespace App\Http\Controllers;

use App\Models\Anggota_Keluarga;
use App\Models\Partner;
use Illuminate\Http\Request;

class SilsilahController extends Controller
{
    public function index() {
        
    }
    public function create_anggota_keluarga(Request $request) 
    {
        $validated = $request->validate([
            'nama_anggota_keluarga' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'status_kehidupan' => 'required|in:Hidup,Wafat',
            'tanggal_kematian' => 'nullable|date|required_if:status_kehidupan,Wafat',
            'alamat' => 'required|string|max:255',
            'urutan' => 'required|string',
            'tree_id' => 'required|string',
            'keluarga_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'parent_id' => 'nullable|exists:anggota_keluarga,id'
        ]);
        $photoPath = null;
        if ($request->hasFile('keluarga_image')) {
            $photoPath = $request->file('keluarga_image')->store('anggota_keluarga', 'public');
        }
        $anggota_keluarga = Anggota_Keluarga::create([
            'nama' => $validated['nama_anggota_keluarga'], // Changed from 'name' to 'nama' to match migration
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'status_kehidupan' => $validated['status_kehidupan'],
            'tanggal_kematian' => $validated['tanggal_kematian'],
            'alamat' => $validated['alamat'],
            'photo' => $photoPath, 
            'urutan' => $validated['urutan'], // Added missing required field
            'tree_id' => $validated['tree_id'], // Added missing required field (adjust as needed)
            'parent_id' => $validated['parent_id'] ?? null
        ]);

        $anggota_keluarga -> save();

        return redirect()->back()
            ->with('success', 'Anggota keluarga berhasil ditambahkan'); // Changed message to be more specific
    }
        
    public function edit_anggota_keluarga() {
        
    }
    public function update_anggota_keluarga(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_anggota_keluarga_edit' => 'required|string|max:255',
            'jenis_kelamin_edit' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir_edit' => 'required|date',
            'status_kehidupan_edit' => 'required',
            'tanggal_kematian_edit' => 'nullable|date', // Perbaikan disini
            'alamat_edit' => 'required|string|max:255',
            'urutan_edit' => 'required|string',
            'tree_id' => 'required|exists:trah,id',
            'keluarga_image_edit' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Perbaikan disini
            'parent_id_edit' => 'nullable|exists:anggota_keluarga,id'
        ]);

        $anggota = Anggota_Keluarga::findOrFail($id);

        // Handle file upload - perbaikan nama field
        if ($request->hasFile('keluarga_image_edit')) { // Sesuaikan dengan nama di form
            $photoPath = $request->file('keluarga_image_edit')->store('anggota_keluarga', 'public');
            $anggota->photo = $photoPath;
        }

        // Update anggota keluarga
        $anggota->update([
            'nama' => $validated['nama_anggota_keluarga_edit'],
            'jenis_kelamin' => $validated['jenis_kelamin_edit'],
            'tanggal_lahir' => $validated['tanggal_lahir_edit'],
            'status_kehidupan' => $validated['status_kehidupan_edit'],
            'tanggal_kematian' => $validated['tanggal_kematian_edit'],
            'alamat' => $validated['alamat_edit'],
            'urutan' => $validated['urutan_edit'],
            'tree_id' => $validated['tree_id'],
            'parent_id' => $validated['parent_id_edit'] ?? null
        ]);

        // Hapus ini, karena sudah diupdate di atas
        // $anggota->update();

        return redirect()->back()
            ->with('success', 'Data anggota keluarga berhasil diperbarui');
    }
    public function delete_anggota_keluarga($id) {
        try {
            $anggota = Anggota_Keluarga::findOrFail($id);
            $anggota->delete();

            return redirect()->back()
            ->with('success', 'Data anggota keluarga berhasil diperbarui');
                
        } catch (\Exception $e) {
            return redirect()->route('trah.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    public function create_pasangan_anggota_keluarga(Request $request) {
        $validated = $request->validate([
            'nama_pasangan_anggota_keluarga' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'status_kehidupan' => 'required|in:Hidup,Wafat',
            'tanggal_kematian' => 'nullable|date|required_if:status_kehidupan,Wafat',
            'alamat' => 'required|string|max:255',
            'urutan' => 'required|string',
            'keluarga_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'partner_id' => 'nullable|exists:anggota_keluarga,id'
        ]);

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('partner_image')) {
            $photoPath = $request->file('partner_image')->store('partner', 'public');
        }

        // Create new anggota keluarga
        $pasangan = Partner::create([
            'nama' => $validated['nama_pasangan_anggota_keluarga'], // Changed from 'name' to 'nama' to match migration
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'status_kehidupan' => $validated['status_kehidupan'],
            'tanggal_kematian' => $validated['tanggal_kematian'],
            'alamat' => $validated['alamat'],
            'photo' => $photoPath, 
            'urutan_anak' => $validated['urutan'], // Added missing required field
            // 'tree_id' => $validated['tree_id'], // Added missing required field (adjust as needed)
            'anggota_keluarga_id' => $validated['partner_id'] ?? null
        ]);

        $pasangan -> save();

        return redirect()->back()
            ->with('success', 'Anggota keluarga berhasil ditambahkan');
    }
    public function edit_pasangan_anggota_keluarga() {
        
    }
    public function update_pasangan_anggota_keluarga() {
        
    }
    public function delete_pasangan_anggota_keluarga() {
        
    }
}
