{{-- This file is used for menu items by any Backpack v7 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-dropdown title="Безпека" icon="la la-lock">
    @if(backpack_user()->can('user-list'))
        <x-backpack::menu-item title="Користувачі" icon="la la-user-circle" :link="backpack_url('user')" />
    @endif
    @if(backpack_user()->can('permission-list'))
        <x-backpack::menu-item title="Дозволи" icon="la la-key" :link="backpack_url('permission')" />
    @endif
    @if(backpack_user()->can('role-list'))
        <x-backpack::menu-item title="Ролі" icon="la la-shield" :link="backpack_url('role')" />
    @endif
</x-backpack::menu-dropdown>

@if(backpack_user()->can('movie-list'))
    <x-backpack::menu-item title="Фільми" icon="la la-film" :link="backpack_url('movie')" />
@endif

@if(backpack_user()->can('person-list'))
    <x-backpack::menu-item title="Персони" icon="la la-user" :link="backpack_url('person')" />
@endif

@if(backpack_user()->can('tag-list'))
    <x-backpack::menu-item title="Теги" icon="la la-tag" :link="backpack_url('tag')" />
@endif

<x-backpack::menu-item :title="trans('backpack::crud.file_manager')" icon="la la-files-o" :link="backpack_url('elfinder')" />
