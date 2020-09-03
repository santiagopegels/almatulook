<?php

use Illuminate\Database\Seeder;

class AttributesValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            'Talle' => [
                'XS',
                'S',
                'M',
                'L',
                'XL'
            ],
            'Color' => [
                'Azul',
                'Rojo',
                'Amarillo',
                'Verde',
                'Gris',
                'Violeta'
            ],
        ];

        foreach ($attributes as $name => $values) {
            $attribute = \App\Models\Admin\Attribute::create([
                'name' => $name,
                'slug' => $name
            ]);

            foreach ($values as $value) {
                $valueModel = \App\Models\Admin\Value::create([
                    'name' => $value,
                    'slug' => $value
                ]);
                $attribute->values()->save($valueModel);
            }
        }
    }
}
