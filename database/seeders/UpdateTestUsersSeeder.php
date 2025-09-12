<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateTestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Atualizar ou criar usuário administrador
        $admin = User::updateOrCreate(
            ['email' => 'admin@blog.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@blog.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'is_admin' => true
            ]
        );
        
        echo "Usuário admin atualizado/criado: {$admin->email}\n";
        
        // Atualizar ou criar usuário comum
        $user = User::updateOrCreate(
            ['email' => 'user@blog.com'],
            [
                'name' => 'Usuário Teste',
                'email' => 'user@blog.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'is_admin' => false
            ]
        );
        
        echo "Usuário comum atualizado/criado: {$user->email}\n";
        
        echo "\nCredenciais de teste atualizadas com sucesso!\n";
        echo "Admin: admin@blog.com / admin123\n";
        echo "User: user@blog.com / user123\n";
    }
}