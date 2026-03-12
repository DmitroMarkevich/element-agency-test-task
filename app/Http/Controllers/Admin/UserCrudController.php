<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('користувач', 'користувачі');
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

        CRUD::addColumn([
            'name'  => 'id',
            'label' => 'ID',
            'type'  => 'number',
        ]);

        CRUD::setFromDb();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(\App\Http\Requests\StoreUserRequest::class);

        $this->setupUserFields();

        $this->crud->setOperationSetting('beforeSave', function ($entry) {
            if (User::where('email', $entry->email)->where('site_id', $entry->site_id)->exists()) {
                throw new \Exception("Користувач з такою поштою'$entry->email' вже існує.");
            }
        });
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(\App\Http\Requests\UpdateUserRequest::class);

        $this->setupUserFields();

        $this->crud->getRequest()->request->remove('password_confirmation');

        if (empty($this->crud->getRequest()->password)) {
            $this->crud->getRequest()->request->remove('password');
        }
    }

    private function setupUserFields(): void
    {
        CRUD::setFromDb();

        CRUD::addField([
            'label' => 'Ролі',
            'type' => 'checklist',
            'name' => 'roles',
            'entity' => 'roles',
            'attribute' => 'name',
            'model' => config('permission.models.role'),
            'pivot' => true,
        ]);

        CRUD::addField([
            'label' => 'Дозволи',
            'type'  => 'checklist',
            'name'  => 'permissions',
            'entity' => 'permissions',
            'attribute' => 'name',
            'model' => config('permission.models.permission'),
            'pivot' => true,
        ]);
    }
}
