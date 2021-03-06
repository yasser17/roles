<?php

use Yasser\Roles\Models\Permission;

class RolesClassTest extends TestCase
{
    function test_if_a_role_has_a_permission()
    {
        $role = $this->createAdminRole();

        $permission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);

        $role->attachPermission($permission);

        $this->assertTrue($role->hasPermission($permission));
    }

    function test_if_a_role_does_not_have_a_permission()
    {
        $role = $this->createAdminRole();

        $permission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);

        $this->assertFalse($role->hasPermission($permission));
    }


    function test_can_attach_a_permission_to_role()
    {
        $role = $this->createAdminRole();

        $permission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);


        $role->attachPermission($permission);

        $this->assertTrue($role->permissions()->get()->contains($permission));
    }

    function test_can_attach_permissions_array()
    {
        $role = $this->createAdminRole();

        $createPermission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);

        $editPermission = Permission::create([
            'name' => 'Edit user',
            'slug' => 'users.edit'
        ]);

        $role->attachPermissions([$createPermission, $editPermission]);

        $this->assertTrue($role->permissions()->get()->contains($createPermission));
        $this->assertTrue($role->permissions()->get()->contains($editPermission));
    }

    function test_detach_a_permission_from_a_role()
    {
        $role = $this->createAdminRole();

        $createPermission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);

        $role->attachPermission($createPermission);

        $this->assertTrue($role->permissions()->get()->contains($createPermission));

        $role->detachPermission($createPermission);

        $this->assertFalse($role->permissions()->get()->contains($createPermission));
    }

    function test_detach_many_permissions_from_a_role()
    {
        $role = $this->createAdminRole();

        $createPermission = Permission::create([
            'name' => 'Create user',
            'slug' => 'users.create'
        ]);

        $editPermission = Permission::create([
            'name' => 'Edit user',
            'slug' => 'users.edit'
        ]);

        $role->attachPermissions([$createPermission, $editPermission]);
        $this->assertTrue($role->permissions()->get()->contains($createPermission));
        $this->assertTrue($role->permissions()->get()->contains($editPermission));
        
        $role->detachPermissions([$createPermission, $editPermission]);
        $this->assertFalse($role->permissions()->get()->contains($createPermission));
        $this->assertFalse($role->permissions()->get()->contains($editPermission));
    }
}