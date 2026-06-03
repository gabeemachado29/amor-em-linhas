<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Cria o usuário administrador padrão.
     * Execute: php artisan db:seed --class=AdminSeeder
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@amoremlinhas.com'],
            [
                'name' => 'Ana Lia (Admin)',
                'password' => Hash::make('Admin@2026'),
                'tipo_perfil' => 'ADMIN',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Usuário admin criado!');
        $this->command->info('   Email: admin@amoremlinhas.com');
        $this->command->info('   Senha: Admin@2026');
        $this->command->warn('   ⚠️  Troque a senha após o primeiro login!');
    }
}
