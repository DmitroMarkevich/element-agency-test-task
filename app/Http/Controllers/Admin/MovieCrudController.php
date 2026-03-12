<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Person;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MovieCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MovieCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Movie::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/movie');
        CRUD::setEntityNameStrings('фільм', 'фільми');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::orderBy('id');

        CRUD::addColumn(['name' => 'id', 'label' => 'ID']);
        CRUD::addColumn(['name' => 'title', 'label' => 'Назва']);
        CRUD::addColumn(['name' => 'release_year', 'label' => 'Рік']);
        CRUD::addColumn([
            'name'  => 'active',
            'label' => 'Активний',
            'type'  => 'boolean',
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(\App\Http\Requests\MovieRequest::class);

        CRUD::addField([
            'name'  => 'active',
            'label' => 'Активний',
            'type'  => 'boolean',
            'tab' => 'Загальне',
        ]);

        foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
            CRUD::addField([
                'name'  => 'title_' . $locale,
                'label' => 'Назва (' . strtoupper($locale) . ')',
                'type'  => 'text',
                'tab' => 'Загальне',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);
        }

        foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
            CRUD::addField([
                'name'  => 'description_' . $locale,
                'label' => 'Опис (' . strtoupper($locale) . ')',
                'type'  => 'ckeditor',
                'tab' => 'Загальне',
                'wrapper' => ['class' => 'form-group col-md-6']
            ]);
        }

        CRUD::addField([
            'name'  => 'release_year',
            'label' => 'Рік випуску',
            'type'  => 'number',
            'tab' => 'Загальне',
            'attributes' => ['min' => 1888, 'max' => 2100],
        ]);

        CRUD::addField([
            'name' => 'youtube_trailer_id',
            'label'  => 'YouTube Trailer ID',
            'type'   => 'text',
            'tab' => 'Загальне',
        ]);

        CRUD::addField([
            'name'  => 'poster',
            'label' => 'Постер',
            'type'  => 'browse',
            'upload' => true,
            'disk'  => 'public',
            'tab'   => 'Медіа',
        ]);

        CRUD::addField([
            'name'    => 'screenshots',
            'label'   => 'Скріншоти',
            'type'    => 'browse_multiple',
            'upload'  => true,
            'disk'    => 'public',
            'tab'   => 'Медіа',
        ]);

        CRUD::addField([
            'name'  => 'tags',
            'label' => 'Теги',
            'type'  => 'select_multiple',
            'entity' => 'tags',
            'model' => Tag::class,
            'attribute' => 'name',
            'pivot' => true,
            'tab' => 'Загальне',
        ]);

        CRUD::addField([
            'name'  => 'view_start_at',
            'label' => 'Дата початку перегляду',
            'type'  => 'datetime',
            'tab' => 'Загальне',
        ]);

        CRUD::addField([
            'name' => 'view_end_at',
            'label' => 'Дата кінця перегляду',
            'type'  => 'datetime',
            'tab' => 'Загальне',
        ]);

        CRUD::addField([
            'name'  => 'persons',
            'label' => 'Каст',
            'type'  => 'select_multiple',
            'entity' => 'persons',
            'model'  => Person::class,
            'attribute' => 'full_name',
            'pivot' => true,
            'tab' => 'Каст',
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }
}
