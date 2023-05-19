<?php

namespace Database\Seeders;

use App\Models\Billetera;
use Illuminate\Database\Seeder;

class BilleteraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Billetera::create([
            'public key' => '044ADAB94DA436049708F5854D4ED3D992B46ECC37066071841650DE2676CE90CCD70589BF490B62C002782BD63D8395C2CF7487EC4DE5568909BE9F061FF5B7E0',
            'private_key' => 'F162477A1E1954C748ACC2E6E2CC9FA28D50831720BDB5626D377E4317261AB0',
            'direccion' => 'TNjGCoDNsa2AqcZLYDheueYKwBd7sURhtC',
            'user_id' => 1
        ]);
    }
}
