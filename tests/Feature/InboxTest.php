<?php

namespace Tests\Feature;

use App\Models\InboxMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InboxTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_inbox_form()
    {
        $response = $this->get(route('inbox.create'));
        $response->assertStatus(200);
    }

    public function test_guest_can_submit_request()
    {
        $response = $this->post(route('inbox.store'), [
            'name' => 'John Doe',
            'birthday' => '1990-01-01',
            'story_request' => 'One Piece',
            'message' => 'Please add this story!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inbox_messages', [
            'name' => 'John Doe',
            'story_request' => 'One Piece',
        ]);
    }

    /*
    public function test_admin_can_view_inbox()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        InboxMessage::create([
            'name' => 'Tester',
            'birthday' => '2000-01-01',
            'message' => 'Test Message',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.inbox.index'));
        $response->assertStatus(200);
        $response->assertSee('Test Message');
    }

    public function test_regular_user_cannot_view_admin_inbox()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('admin.inbox.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_delete_message()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $msg = InboxMessage::create([
            'name' => 'Tester',
            'birthday' => '2000-01-01',
            'message' => 'Delete Me',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.inbox.destroy', $msg));
        $response->assertRedirect();
        $this->assertDatabaseMissing('inbox_messages', ['id' => $msg->id]);
    }
    */
}
