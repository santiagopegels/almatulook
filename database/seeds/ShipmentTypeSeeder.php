<?php

use Illuminate\Database\Seeder;

class ShipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin\ShipmentType::create([
            'name'=> 'Motomandado',
            'description'=> 'Llega a domicilio',
            'cost'=> '500',
            'address_required'=> '1',
        ]);

        \App\Models\Admin\ShipmentType::create([
            'name'=> 'Retiro por sucursal',
            'description'=> 'Rebollo 2443',
            'cost'=> '0',
            'address_required'=> '0',
        ]);
    }
}
