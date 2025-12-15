<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\EquipService;
use App\Repositories\EquipRepository;
use App\Models\Equip;
use Mockery;

class EquipServiceTest extends TestCase
{
    public function test_pot_crear_un_equip()
    {
        // 1. Preparar dades
        $dades = ['nom' => 'Nou Equip', 'estadi_id' => 1];
        
        // 2. Simular (Mock) el Repository
        $repositoryMock = Mockery::mock(EquipRepository::class);
        
        // Esperem que el mètode 'create' del repositori es cridi una vegada
        $repositoryMock->shouldReceive('create')
            ->once()
            ->with($dades)
            ->andReturn(new Equip($dades));

        // 3. Executar el Servei injectant el Mock
        $service = new EquipService($repositoryMock);
        
        // CORRECCIÓ: Fem servir 'guardar' en lloc de 'crear'
        $resultat = $service->guardar($dades);

        // 4. Comprovacions
        $this->assertInstanceOf(Equip::class, $resultat);
        $this->assertEquals('Nou Equip', $resultat->nom);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}