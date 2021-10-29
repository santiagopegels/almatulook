<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin\Category::create([
            'name' => 'Remeras',
            'slug' => 'remeras',
            'description' => 'Remeras',
            'category_parent_id' => null,
        ])->attributes()->sync([1,2]);

        \App\Models\Admin\Category::create([
            'name' => 'Manga Corta',
            'slug' => 'manga-corta',
            'description' => 'Manga Corta',
            'category_parent_id' => 1,
        ])->attributes()->sync([1,2]);

        \App\Models\Admin\Category::create([
            'name' => 'Manga Larga',
            'slug' => 'manga-larga',
            'description' => 'Manga Larga',
            'category_parent_id' => 1,
        ])->attributes()->sync([1,2]);

        \App\Models\Admin\Category::create([
            'name' => 'Vestidos',
            'slug' => 'vestidos',
            'description' => 'Vestidos',
            'category_parent_id' => null,
        ])->attributes()->sync([1,2]);
    }
}
