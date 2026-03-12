<?php

use App\Http\Controllers\Admin\TagCrudController;
use App\Http\Controllers\Admin\MovieCrudController;
use App\Http\Controllers\Admin\PersonCrudController;
use App\Http\Controllers\Admin\RoleCrudController;
use App\Http\Controllers\Admin\PermissionCrudController;

return [
    MovieCrudController::class => [
        'movie-list' => ['only' => ['index']],
        'movie-show' => ['only' => ['show']],
        'movie-create' => ['only' => ['create', 'store']],
        'movie-update' => ['only' => ['edit', 'update']],
        'movie-delete' => ['only' => ['destroy']],
    ],

    PersonCrudController::class => [
        'person-list' => ['only' => ['index']],
        'person-show' => ['only' => ['show']],
        'person-create' => ['only' => ['create', 'store']],
        'person-update' => ['only' => ['edit', 'update']],
        'person-delete' => ['only' => ['destroy']],
    ],

    TagCrudController::class => [
        'tag-list' => ['only' => ['index']],
        'tag-show' => ['only' => ['show']],
        'tag-create' => ['only' => ['create', 'store']],
        'tag-delete' => ['only' => ['destroy']],
    ],

    PermissionCrudController::class => [
        'permission-list' => ['only' => ['index']],
        'permission-show' => ['only' => ['show']],
        'permission-create' => ['only' => ['create', 'store']],
        'permission-update' => ['only' => ['edit', 'update']],
        'permission-delete' => ['only' => ['destroy']],
    ],

    RoleCrudController::class => [
        'role-list' => ['only' => ['index']],
        'role-show' => ['only' => ['show']],
        'role-create' => ['only' => ['create', 'store']],
        'role-update' => ['only' => ['edit', 'update']],
        'role-delete' => ['only' => ['destroy']],
    ],

    \App\Http\Controllers\Admin\UserCrudController::class => [
        'user-list'   => ['only' => ['index']],
        'user-show'   => ['only' => ['show']],
        'user-create' => ['only' => ['create', 'store']],
        'user-update' => ['only' => ['edit', 'update']],
        'user-delete' => ['only' => ['destroy']],
    ],
];
