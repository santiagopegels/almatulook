<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Category;
use App\Repositories\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories\Admin
 * @version September 3, 2020, 12:39 pm UTC
*/

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'description',
        'category_parent_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     *
     * Update Parent Category Id Into Categories Table
     *
     */
    public function updateChildren($category, $subcategory)
    {
        $subcategoryObject = $this->find($subcategory['id']);

        if(!isset($subcategoryObject)){
            $subcategoryObject = $this->create($subcategory);
            $category->children()->save($subcategoryObject);
        } else{
            $this->update($subcategory, $subcategoryObject->id);
        }
    }

    /**
     *
     * Update Parent Category Id Into Categories Table
     *
     */
    public function updateAttributes($category, $attributesIds)
    {
        $category->attributes()->sync($attributesIds);
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }
}
