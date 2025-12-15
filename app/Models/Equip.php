<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equip extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'estadi_id', 'titols', 'escut'];

    public function estadi()
    {
        return $this->belongsTo(Estadi::class);
    }

    /**
     * Relación: Un equipo tiene un Manager (User).
     */
    public function manager()
    {
        return $this->hasOne(User::class, 'team_id');
    }

    // 1. SOLUCIÓ ERROR PRINCIPAL: Relació amb Jugadora
    public function jugadores()
    {
        return $this->hasMany(Jugadora::class);
    }

    // 2. SOLUCIÓ ERROR SECUNDARI: Accessor per a partits (Local o Visitant)
    public function getUltimsPartitsAttribute()
    {
        // Necessites importar App\Models\Partit o fer servir \App\Models\Partit
        return \App\Models\Partit::where('local_id', $this->id)
            ->orWhere('visitant_id', $this->id)
            ->orderBy('data', 'desc')
            ->take(5)
            ->get();
    }

    // 3. SOLUCIÓ ERROR SECUNDARI: Accessor per edat mitjana
    public function getEdatMitjanaAttribute()
    {
        // Calcula la mitjana utilitzant l'atribut 'edat' de les jugadores
        // Si no hi ha jugadores, retorna 0 o null per evitar divisió per zero
        if ($this->jugadores->isEmpty()) {
            return 0;
        }
        
        return $this->jugadores->avg(fn($jugadora) => $jugadora->edat);
    }
}