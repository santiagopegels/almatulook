<?php

use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin\Parameter::create([
            'parameter' => 'valor_dolar',
            'value' => '0'
        ]);
    }
}
