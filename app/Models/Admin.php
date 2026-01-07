<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
     /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cin',
        'nom',
        'prenom',
        'email',
        'password',
        'tel'
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

     public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
