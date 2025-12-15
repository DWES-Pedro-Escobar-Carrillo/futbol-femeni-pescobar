<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;
use App\Http\Requests\StoreJugadoraRequest;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class StoreJugadoraRequestTest extends TestCase
{
    // Funció auxiliar per validar regles
    private function validar($dades)
    {
        $request = new StoreJugadoraRequest();
        return Validator::make($dades, $request->rules());
    }

    public function test_validacio_falla_si_jugadora_te_menys_de_16_anys()
    {
        $dades = [
            'nom' => 'Maria',
            'equip_id' => 1,
            'dorsal' => 10,
            'data_naixement' => Carbon::now()->subYears(15)->format('Y-m-d'), // 15 anys
        ];

        $validator = $this->validar($dades);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('data_naixement', $validator->errors()->toArray());
    }

    public function test_validacio_passa_si_jugadora_te_16_anys_o_mes()
    {
        $dades = [
            'nom' => 'Maria',
            'equip_id' => 1,
            'dorsal' => 10,
            'data_naixement' => Carbon::now()->subYears(16)->format('Y-m-d'), // 16 anys
        ];

        // Nota: Assumim que l'equip existeix a la BD o fem servir regles 'ignore' per unit tests,
        // però com estem testejant Feature, necessitem la BD o mockear la regla 'exists'.
        // Per simplicitat en validació pura, ens centrem en la data.
        
        $validator = $this->validar($dades);
        // Ignorem l'error d'equip_id (exists) per centrar-nos en l'edat
        $errors = $validator->errors()->toArray();
        $this->assertArrayNotHasKey('data_naixement', $errors);
    }

    public function test_validacio_falla_si_foto_no_es_png()
    {
        $dades = [
            'nom' => 'Anna',
            'equip_id' => 1,
            'dorsal' => 5,
            'data_naixement' => '2000-01-01',
            'foto' => UploadedFile::fake()->image('avatar.jpg'), // JPG incorrecte
        ];

        $validator = $this->validar($dades);
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('foto', $validator->errors()->toArray());
    }
}