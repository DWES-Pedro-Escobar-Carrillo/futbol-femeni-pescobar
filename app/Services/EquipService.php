<?php

namespace App\Services;

use App\Models\Equip;
use App\Repositories\EquipRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EquipService
{
    // Inyectamos el repositorio específico
    public function __construct(private EquipRepository $repo) {}

    public function llistar()
    {
        return $this->repo->getAll();
    }

    public function guardar(array $data, ?UploadedFile $escut = null): Equip
    {
        if ($escut) {
            // Guarda el archivo en 'storage/app/public/escuts'
            $data['escut'] = $escut->store('escuts', 'public');
        }
        return $this->repo->create($data);
    }

    public function actualitzar(int $id, array $data, ?UploadedFile $escut = null): Equip
    {
        $equip = $this->repo->find($id);

        if ($escut) {
            // Borra el escudo anterior si existe
            if ($equip->escut) {
                Storage::disk('public')->delete($equip->escut);
            }
            $data['escut'] = $escut->store('escuts', 'public');
        }

        return $this->repo->update($id, $data);
    }

    public function eliminar(int $id): void
    {
        $equip = $this->repo->find($id);
        if ($equip->escut) {
            Storage::disk('public')->delete($equip->escut);
        }
        $this->repo->delete($id);
    }
}