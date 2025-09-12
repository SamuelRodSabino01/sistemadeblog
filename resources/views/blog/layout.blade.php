<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog') - Sistema de Blog</title>
    <meta name="description" content="@yield('description', 'Um blog moderno e funcional')">
    <meta name="keywords" content="@yield('keywords', 'blog, artigos, tecnologia')">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .prose img { border-radius: 0.5rem; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('blog.index') }}" class="text-2xl font-bold text-gray-900 hover:text-blue-600 transition-colors">
                        <i class="fas fa-blog mr-2 text-blue-600"></i>
                        Blog System
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('blog.index') ? 'text-blue-600' : '' }}">
                        Início
                    </a>
                    <a href="{{ route('blog.index') }}#categories" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Categorias
                    </a>
                    <a href="{{ route('blog.search') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                        Buscar
                    </a>
                </nav>
                
                <!-- Search & Auth -->
                <div class="flex items-center space-x-4">
                    <!-- Search Form -->
                    <form action="{{ route('blog.search') }}" method="GET" class="hidden sm:block">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" 
                                   placeholder="Buscar posts..." 
                                   class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Auth Links -->
                    @auth
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Entrar
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Registrar
                        </a>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden text-gray-700 hover:text-blue-600" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 py-4">
                <div class="space-y-2">
                    <a href="{{ route('blog.index') }}" class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                        Início
                    </a>
                    <a href="{{ route('blog.index') }}#categories" class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                        Categorias
                    </a>
                    <a href="{{ route('blog.search') }}" class="block text-gray-700 hover:text-blue-600 font-medium py-2">
                        Buscar
                    </a>
                    
                    <!-- Mobile Search -->
                    <form action="{{ route('blog.search') }}" method="GET" class="pt-2">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" 
                                   placeholder="Buscar posts..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">
                        <i class="fas fa-blog mr-2 text-blue-400"></i>
                        Blog System
                    </h3>
                    <p class="text-gray-300 mb-4">
                        Um sistema de blog moderno e funcional, desenvolvido com Laravel e Tailwind CSS. 
                        Compartilhamos conhecimento e experiências através de artigos de qualidade.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Início</a></li>
                        <li><a href="{{ route('blog.search') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Buscar</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Entrar</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Registrar</a></li>
                        @endauth
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contato</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li>
                            <i class="fas fa-envelope mr-2 text-blue-400"></i>
                            contato@blog.com
                        </li>
                        <li>
                            <i class="fas fa-phone mr-2 text-blue-400"></i>
                            (11) 99999-9999
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt mr-2 text-blue-400"></i>
                            São Paulo, SP
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} Blog System. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = event.target.closest('button');
            
            if (!menu.contains(event.target) && !button) {
                menu.classList.add('hidden');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>