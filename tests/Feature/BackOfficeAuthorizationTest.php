<?php

namespace Tests\Feature;

use App\Models\AssistanceDemand;
use App\Models\PartnerDecision;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackOfficeAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function partner(): User
    {
        return User::factory()->create(['is_admin' => false]);
    }

    private function decisionAssignedTo(User $partner): PartnerDecision
    {
        $assistance = new AssistanceDemand();
        $assistance->save();

        $demand = $assistance->demand()->create([
            'first_name' => 'Test',
            'last_name' => 'Person',
            'phone_number' => '21600000',
            'email' => 'person@example.com',
            'description' => 'needs help',
        ]);

        return PartnerDecision::create([
            'demand_id' => $demand->id,
            'user_id' => $partner->id,
            'status' => 'awaiting',
            'comment' => null,
            'file' => null,
        ]);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admins')->assertRedirect(route('login'));
        $this->get('/cancelled-demands')->assertRedirect(route('login'));
        $this->get('/assistance')->assertRedirect(route('login'));
    }

    public function test_partner_cannot_access_user_management(): void
    {
        $this->actingAs($this->partner())->get('/admins')->assertForbidden();
        $this->actingAs($this->partner())->get('/admins/create')->assertForbidden();
    }

    public function test_partner_cannot_reach_admin_only_demand_actions(): void
    {
        $partner = $this->partner();

        $this->actingAs($partner)->delete('/assistance/1')->assertForbidden();
        $this->actingAs($partner)
            ->post('/assistance/1/assign-demand', ['partner' => $partner->id])
            ->assertForbidden();
        $this->actingAs($partner)->patch('/assistance/1/accept')->assertForbidden();
        $this->actingAs($partner)->post('/demands/1/change-type')->assertForbidden();
        $this->actingAs($partner)->get('/news/create')->assertForbidden();
    }

    public function test_admin_can_access_user_management_form(): void
    {
        $this->actingAs($this->admin())->get('/admins/create')->assertOk();
    }

    public function test_partner_cannot_decide_another_partners_case(): void
    {
        $decision = $this->decisionAssignedTo($this->partner());

        $this->actingAs($this->partner())
            ->patch("/assistance/partner-decision/{$decision->id}/treated", ['comment' => 'done'])
            ->assertForbidden();

        $this->assertSame('awaiting', $decision->fresh()->status);
    }

    public function test_partner_can_decide_their_own_case(): void
    {
        $partner = $this->partner();
        $decision = $this->decisionAssignedTo($partner);

        $this->actingAs($partner)
            ->patch("/assistance/partner-decision/{$decision->id}/treated", ['comment' => 'handled'])
            ->assertRedirect();

        $this->assertSame('accepted', $decision->fresh()->status);
        $this->assertSame('handled', $decision->fresh()->comment);
    }

    public function test_admin_can_decide_any_case(): void
    {
        $decision = $this->decisionAssignedTo($this->partner());

        $this->actingAs($this->admin())
            ->patch("/assistance/partner-decision/{$decision->id}/notreated", ['comment' => 'not possible'])
            ->assertRedirect();

        $this->assertSame('refused', $decision->fresh()->status);
    }
}
