<?php

namespace Tests\Feature\Policies;

use Tests\TestCase;
use App\Models\User;
use App\Models\Partit;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartitPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pot_editar_qualsevol_partit()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $partit = Partit::factory()->create();

        $this->assertTrue($admin->can('update', $partit));
    }

    public function test_arbitre_assignat_pot_editar_resultat()
    {
        $arbitre = User::factory()->create(['role' => 'arbitre']);
        $partit = Partit::factory()->create(['arbitre_id' => $arbitre->id]);

        $this->assertTrue($arbitre->can('update', $partit));
    }

    public function test_arbitre_no_assignat_no_pot_editar()
    {
        $arbitre1 = User::factory()->create(['role' => 'arbitre']);
        $arbitre2 = User::factory()->create(['role' => 'arbitre']);
        
        // Partit assignat a arbitre1
        $partit = Partit::factory()->create(['arbitre_id' => $arbitre1->id]);

        // Arbitre2 intenta editar
        $this->assertFalse($arbitre2->can('update', $partit));
    }
}