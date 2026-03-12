<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Person;
use App\Enums\PersonType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PersonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PersonCrudController extends CrudController
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
    public function setup(): void
    {
        CRUD::setModel(Person::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/person');
        CRUD::setEntityNameStrings('персону', 'персони');
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

        CRUD::addColumn([
            'name'   => 'photo',
            'label'  => 'Фото',
            'type'   => 'image',
            'height' => '50px',
            'width'  => '50px',
        ]);

        CRUD::addColumn(['name' => 'first_name', 'label' => "Ім'я"]);
        CRUD::addColumn(['name' => 'last_name', 'label' => 'Прізвище']);
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Тип',
            'type'  => 'closure',
            'function' => fn ($entry) => $entry->type?->label(),
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
        CRUD::setValidation(\App\Http\Requests\PersonRequest::class);

        CRUD::addField([
            'name'  => 'first_name',
            'label' => 'Імʼя',
            'type'  => 'text',
        ]);

        CRUD::addField([
            'name'  => 'last_name',
            'label' => 'Прізвище',
            'type'  => 'text',
        ]);

        CRUD::addField([
            'name'  => 'photo',
            'label' => 'Фото',
            'type'  => 'browse',
            'upload' => true,
            'disk'  => 'public',
        ]);

        CRUD::addField([
            'name'  => 'type',
            'label' => 'Тип',
            'type'  => 'select_from_array',
            'options' => PersonType::options(),
            'value' => $this->crud->getCurrentEntry()
                ? $this->crud->getCurrentEntry()->type?->value
                : null,
        ]);

        CRUD::addField([
            'name'  => 'tags',
            'label' => 'Теги',
            'type'  => 'select_multiple',
            'entity' => 'tags',
            'model'  => Tag::class,
            'attribute' => 'name',
            'pivot'  => true,
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
