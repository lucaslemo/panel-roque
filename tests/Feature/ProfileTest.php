<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response
            ->assertOk()
            ->assertSeeVolt('profile.update-profile-information-form')
            ->assertSeeVolt('profile.update-password-form');
            // ->assertSeeVolt('profile.delete-user-form');
    }

    // public function test_profile_information_can_be_updated(): void
    // {
    //     $this->seed(PermissionsSeeder::class);
    //     $user = User::factory()->create();

    //     $this->actingAs($user);

    //     $component = Volt::test('profile.update-profile-information-form')
    //         ->set('name', 'Test User')
    //         ->set('email', 'test@example.com')
    //         ->call('updateProfileInformation');

    //     $component
    //         ->assertHasNoErrors()
    //         ->assertNoRedirect();

    //     $user->refresh();

    //     $this->assertSame('Test User', $user->name);
    //     $this->assertSame('test@example.com', $user->email);
    //     $this->assertNull($user->email_verified_at);
    // }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-profile-information-form')
            ->set('name', 'Test User')
            ->set('email', $user->email)
            ->call('updateProfileInformation');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.delete-user-form')
            ->set('password', 'senha')
            ->call('deleteUser');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/login');

        $this->assertGuest();
        $this->assertSoftDeleted($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $this->seed(PermissionsSeeder::class);
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.delete-user-form')
            ->set('password', 'wrong-password')
            ->call('deleteUser');

        $component
            ->assertHasErrors('password')
            ->assertNoRedirect();

        $this->assertNotSoftDeleted($user->fresh());
    }
}
