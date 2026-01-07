<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Etudiant extends Authenticatable{ 


     /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id', 
        'filiere_id',
        'cin',
        'nom',
        'prenom',
        'email',
        'password',
        'tel',
        'niveau'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * // This creates 10 fake students in the database instantly
     * Student::factory()->count(10)->create();
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
     public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

}
