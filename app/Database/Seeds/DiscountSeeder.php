<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        // Create 10 discounts starting from today
        for ($i = 0; $i < 10; $i++) {
            $date = date('Y-m-d', strtotime("+$i days"));
            $data[] = [
                'tanggal'    => $date,
                'nominal'    => 100000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('discount')->insertBatch($data);
    }
}
