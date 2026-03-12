<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RoleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    protected string $permission_model = \App\Models\Permission::class;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Role::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/role');
        CRUD::setEntityNameStrings('роль', 'ролі');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::orderBy('id');

        $this->crud->addColumn([
            'name'  => 'id',
            'label' => trans('ID'),
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'name'  => 'name',
            'label' => trans("Ім'я"),
            'type'  => 'text',
        ]);

        $this->crud->query->withCount('users');
        $this->crud->addColumn([
            'label' => 'Користувачі',
            'type'  => 'text',
            'name'  => 'users_count',
            'wrapper' => [
                'href' => function ($crud, $column, $entry) {
                    return backpack_url('user?role='.$entry->getKey());
                },
            ],
            'suffix' => ' '.strtolower(trans('Users')),
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(\App\Http\Requests\RoleRequest::class);

        CRUD::setFromDb();

        $this->crud->addField([
            'label' => 'Дозволи',
            'type'  => 'checklist',
            'name'  => 'permissions',
            'entity' => 'permissions',
            'attribute' => 'name',
            'model' => $this->permission_model,
            'pivot' => true,
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
