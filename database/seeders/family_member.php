<?php

namespace Database\Seeders;

use App\Models\Trah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class family_member extends Seeder
{
    public function run()
    {
        $treeId = 1;
        $totalGenerations = 3; // Test with 3 first, then change to 18
        
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear related tables first
        DB::table('pasangan')->truncate();
        DB::table('anggota_keluarga')->truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Generasi 0 (Root) - Only 2 members
        $root1Id = DB::table('anggota_keluarga')->insertGetId([
            'nama' => 'Budi',
            'tanggal_lahir' => null,
            'jenis_kelamin' => 'Laki-Laki',
            'urutan' => 1,
            'status_kehidupan' => 'Hidup',
            'tanggal_kematian' => null,
            'alamat' => 'Jl. Merdeka No.1',
            'tree_id' => $treeId,
            'parent_id' => null,
            'photo' => null,
        ]);

        $root2Id = DB::table('anggota_keluarga')->insertGetId([
            'nama' => 'Ani',
            'tanggal_lahir' => null,
            'jenis_kelamin' => 'Perempuan',
            'urutan' => 2,
            'status_kehidupan' => 'Hidup',
            'tanggal_kematian' => null,
            'alamat' => 'Jl. Merdeka No.1',
            'tree_id' => $treeId,
            'parent_id' => null,
            'photo' => null,
        ]);

        // Track parents for each generation
        $currentParents = [$root1Id, $root2Id];
        
        for ($gen = 1; $gen < $totalGenerations; $gen++) {
            $newParents = [];
            
            foreach ($currentParents as $parentId) {
                // Create 2 children for each parent
                for ($childOrder = 1; $childOrder <= 2; $childOrder++) {
                    $gender = ($childOrder % 2 == 0) ? 'Perempuan' : 'Laki-Laki';
                    
                    $childId = DB::table('anggota_keluarga')->insertGetId([
                        'nama' => Str::random(10),
                        'tanggal_lahir' => null,
                        'jenis_kelamin' => $gender,
                        'urutan' => $childOrder,
                        'status_kehidupan' => 'Hidup',
                        'tanggal_kematian' => null,
                        'alamat' => 'Jl. ' . Str::random(5),
                        'tree_id' => $treeId,
                        'parent_id' => $parentId,
                        'photo' => null,
                    ]);
                    
                    $newParents[] = $childId;
                }
            }
            
            $currentParents = $newParents;
        }
    }
}