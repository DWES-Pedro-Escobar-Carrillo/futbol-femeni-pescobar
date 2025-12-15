<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Partit;
use App\Models\Equip;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartitControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_no_pot_veure_llistat_partits()
    {
        // Intentem accedir sense fer login
        $response = $this->get(route('partits.index'));
        
        // Ara HA DE redirigir al login (Status 302)
        $response->assertStatus(302); 
        $response->assertRedirect(route('login'));
    }

    public function test_usuari_autenticat_pot_veure_llistat()
    {
        $user = User::factory()->create();
        
        // Fem login i accedim
        $response = $this->actingAs($user)->get(route('partits.index'));
        
        // Ara ha de deixar entrar (Status 200)
        $response->assertStatus(200);
        $response->assertViewIs('partits.index');
    }

    public function test_admin_pot_crear_partit()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        // Dades necessàries segons el teu factory/request
        $local = Equip::factory()->create();
        $visitant = Equip::factory()->create();
        $estadi = \App\Models\Estadi::factory()->create();

        $dades = [
            'local_id' => $local->id,
            'visitant_id' => $visitant->id,
            'estadi_id' => $estadi->id,
            'data' => now()->addDay()->format('Y-m-d H:i:s'),
            'jornada' => 1,
        ];

        $response = $this->actingAs($admin)->post(route('partits.store'), $dades);

        $response->assertRedirect(route('partits.index'));
        $this->assertDatabaseHas('partits', ['local_id' => $local->id]);
    }

    public function test_arbitre_no_pot_crear_partit()
    {
        $arbitre = User::factory()->create(['role' => 'arbitre']);
        
        $response = $this->actingAs($arbitre)->get(route('partits.create'));
        
        // Forbidden per Policy
        $response->assertStatus(403); 
    }
}