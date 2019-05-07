<?php

namespace Thinkstudeo\Rakshak\Tests\Unit;

use App\User;
use Thinkstudeo\Rakshak\Role;
use Thinkstudeo\Rakshak\Ability;
use Thinkstudeo\Rakshak\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_roles_assigned_to_the_user()
    {
        $role = create(Role::class);
        $user = create(User::class);

        $user->assignRole($role);

        $this->assertInstanceOf(Collection::class, $user->roles);
        $this->assertInstanceOf(Role::class, $user->fresh()->roles->first());
    }

    /** @test */
    public function it_can_assign_a_role_to_the_user()
    {
        $role1 = create(Role::class);
        $role2 = create(Role::class);
        $user = create(User::class);
        $this->assertCount(0, $user->roles);

        $user->assignRole($role1);
        $this->assertCount(1, $user->fresh()->roles);

        $user->assignRole($role2->name);
        $this->assertCount(2, $user->fresh()->roles);
    }

    /** @test */
    public function it_can_determine_whether_the_user_has_a_role()
    {
        $role1 = create(Role::class);
        $user = create(User::class);
        $this->assertFalse($user->hasRole($role1));

        $user->assignRole($role1);
        $this->assertTrue($user->fresh()->hasRole($role1));
    }

    /** @test */
    public function it_can_determine_whether_the_user_has_any_of_the_given_rolenames()
    {
        $role1 = create(Role::class, ['name' => 'site_manager']);
        $role2 = create(Role::class, ['name' => 'hr_manager']);
        $user = create(User::class);
        $this->assertFalse($user->hasAnyRole(['site_manager', 'hr_manager']));

        $user->assignRole('site_manager');
        $this->assertTrue($user->fresh()->hasRole('site_manager'));
        $this->assertTrue($user->fresh()->hasAnyRole(['site_manager', 'hr_manager']));
    }

    /** @test */
    public function it_can_determine_whether_the_user_has_any_of_the_given_roles()
    {
        $role1 = create(Role::class, ['name' => 'site_manager']);
        $role2 = create(Role::class, ['name' => 'hr_manager']);
        $user = create(User::class);
        $this->assertFalse($user->hasAnyRole([$role1, $role2]));

        $user->assignRole('site_manager');
        $this->assertTrue($user->fresh()->hasRole('site_manager'));
        $this->assertTrue($user->fresh()->hasAnyRole([$role1, $role2]));
    }

    /** @test */
    public function it_can_determine_whether_the_user_has_a_given_ability()
    {
        $ability = create(Ability::class);
        $role = create(Role::class);
        $role->addAbility($ability);
        $user = create(User::class);
        $this->assertFalse($user->hasAbility($ability));

        $user->assignRole($role);
        $this->assertTrue($user->fresh()->hasAbility($ability));
        $this->assertTrue($user->fresh()->hasAbility($ability->name));
    }

    /** @test */
    public function it_can_determine_whether_the_user_is_a_super_user()
    {
        $user = create(User::class);
        $this->assertFalse($user->isSuperUser());

        $user->assignRole('super');
        $this->assertTrue($user->fresh()->isSuperUser());
    }
}
