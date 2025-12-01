<?php
namespace App\Services;

use App\Repositories\EquipRepository;
use Illuminate\Support\Facades\Storage;

class EquipService {
    public function __construct(private EquipRepository $repo) {}

    public function llistar() {
        return $this->repo->getAll();
    }

    public function trobar($id){
        return $this->repo->find($id);
    }

    public function guardar(array $data) {
        if (isset($data['escut'])) {
            $data['escut'] = $this->pujarEscut($data['escut']);
        }
        return $this->repo->create($data);
    }

    public function actualitzar($id, array $data) {
        $equip = $this->repo->find($id);

        if (isset($data['escut'])) {
            // Esborrar l'escut antic si existeix
            if ($equip->escut) {
                Storage::disk('public')->delete($equip->escut);
            }
            $data['escut'] = $this->pujarEscut($data['escut']);
        }
        
        return $this->repo->update($id, $data);
    }

    public function eliminar($id) {
        $equip = $this->repo->find($id);
        if ($equip->escut) {
            Storage::disk('public')->delete($equip->escut);
        }
        return $this->repo->delete($id);
    }

    private function pujarEscut($fitxer): string
    {
        // Puja a storage/app/public/escuts
        return $fitxer->store('escuts', 'public');
    }
}