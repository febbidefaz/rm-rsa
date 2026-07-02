<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserRM extends Authenticatable
{
    protected $table = 'UserRM';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Nama',
        'Username',
        'Password',
        'Role',
        'Aktif',
        'CreatedAt',
    ];

    // Password disimpan pada kolom Password
    public function getAuthPassword()
    {
        return $this->Password;
    }

    // Username digunakan untuk login
    public function getAuthIdentifierName()
    {
        return 'Username';
    }

    // Agar AdminLTE tetap bisa memakai Auth::user()->name
    public function getNameAttribute()
    {
        return $this->Nama;
    }

    // Opsional, agar avatar AdminLTE tidak error
    public function adminlte_image()
    {
        return asset('vendor/adminlte/dist/img/user2-160x160.jpg');
    }

    public function adminlte_desc()
    {
        return $this->Role;
    }
}