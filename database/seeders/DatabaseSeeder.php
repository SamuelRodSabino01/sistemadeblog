<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@blog.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ]);
        
        // Criar usuários adicionais
        $users = User::factory(5)->create();
        
        // Criar categorias
        $categories = [
            ['name' => 'Tecnologia', 'description' => 'Artigos sobre tecnologia e inovação'],
            ['name' => 'Programação', 'description' => 'Tutoriais e dicas de programação'],
            ['name' => 'Design', 'description' => 'Tendências e técnicas de design'],
            ['name' => 'Marketing', 'description' => 'Estratégias de marketing digital'],
            ['name' => 'Negócios', 'description' => 'Insights sobre empreendedorismo']
        ];
        
        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description']
            ]);
        }
        
        // Criar tags
        $tags = [
            'Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'CSS', 'HTML',
            'MySQL', 'API', 'Frontend', 'Backend', 'Mobile', 'Web Development',
            'UI/UX', 'SEO', 'E-commerce', 'Startup', 'Produtividade'
        ];
        
        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName)
            ]);
        }
        
        // Criar posts
        $allUsers = User::all();
        $allCategories = Category::all();
        $allTags = Tag::all();
        
        for ($i = 1; $i <= 20; $i++) {
            $title = "Post de Exemplo #{$i}";
            $post = Post::create([
                'title' => $title,
                'slug' => Str::slug($title . '-' . $i),
                'excerpt' => "Este é um resumo do post de exemplo número {$i}. Aqui você encontrará informações interessantes sobre o tema abordado.",
                'content' => "<p>Este é o conteúdo completo do post de exemplo número {$i}.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>",
                'status' => $i <= 15 ? 'published' : 'draft',
                'published_at' => $i <= 15 ? now()->subDays(rand(1, 30)) : null,
                'user_id' => $allUsers->random()->id,
                'category_id' => $allCategories->random()->id
            ]);
            
            // Associar tags aleatórias ao post
            $randomTags = $allTags->random(rand(2, 5));
            $post->tags()->attach($randomTags->pluck('id'));
            
            // Criar comentários para posts publicados
            if ($post->status === 'published') {
                for ($j = 1; $j <= rand(2, 8); $j++) {
                    Comment::create([
                        'content' => "Este é um comentário de exemplo para o post '{$post->title}'. Muito interessante o conteúdo!",
                        'author_name' => fake()->name(),
                        'author_email' => fake()->email(),
                        'status' => rand(0, 1) ? 'approved' : 'pending',
                        'post_id' => $post->id,
                        'user_id' => rand(0, 1) ? $allUsers->random()->id : null
                    ]);
                }
            }
        }
    }
}
