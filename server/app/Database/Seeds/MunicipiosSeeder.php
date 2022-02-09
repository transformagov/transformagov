<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    public function run()
    {
       $file = '/transformagov/server/app/Database/Seeds/municipios_0.json';
       $file_data = file_get_contents($file);
       $municipios = json_decode($file_data);
       foreach ($municipios as $municipio ) {
            $this->db->table('municipios')->insert((array) $municipio);
       }
    }
}
