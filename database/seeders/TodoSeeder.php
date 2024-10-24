<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run()
    {
        Todo::create([
            'title' => 'Belajar Laravel',
            'description' => 'Mempelajari framework Laravel dasar',
        ]);

        Todo::create([
            'title' => 'Membuat Aplikasi Todo',
            'description' => 'Membuat aplikasi todo list dengan Laravel',
        ]);

        Todo::create([
            'title' => 'Meeting dengan Client',
            'description' => 'Diskusi project baru',
        ]);

        Todo::create([
            'title' => 'Olahraga Pagi',
            'description' => 'Jogging 30 menit',
        ]);

        Todo::create([
            'title' => 'Belanja Bulanan',
            'description' => 'Beli kebutuhan rumah tangga',
        ]);
    }
}
