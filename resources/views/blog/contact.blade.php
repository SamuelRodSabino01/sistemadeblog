@extends('blog.layout')

@section('title', 'Contato')
@section('description', 'Entre em contato conosco. Envie suas dúvidas, sugestões ou feedback.')
@section('keywords', 'contato, fale conosco, suporte, feedback')

@section('content')
<!-- Contact Header -->
<div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <nav class="mb-4">
                <ol class="flex items-center justify-center space-x-2 text-sm text-indigo-100">
                    <li><a href="{{ route('blog.index') }}" class="hover:text-white">Início</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-white font-medium">Contato</li>
                </ol>
            </nav>
            
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Entre em Contato</h1>
            <p class="text-xl text-indigo-100 max-w-3xl mx-auto leading-relaxed">
                Tem alguma dúvida, sugestão ou feedback? Adoraríamos ouvir de você!
            </p>
        </div>
    </div>
</div>

<!-- Contact Content -->
<div class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envie sua Mensagem</h2>
                
                @if(session('contact_success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ session('contact_success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('contact_error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>{{ session('contact_error') }}</span>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail *</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('phone') border-red-500 @enderror" 
                               placeholder="(11) 99999-9999">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Assunto *</label>
                        <select name="subject" 
                                id="subject" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('subject') border-red-500 @enderror" 
                                required>
                            <option value="">Selecione um assunto</option>
                            <option value="duvida" {{ old('subject') == 'duvida' ? 'selected' : '' }}>Dúvida</option>
                            <option value="sugestao" {{ old('subject') == 'sugestao' ? 'selected' : '' }}>Sugestão</option>
                            <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                            <option value="parceria" {{ old('subject') == 'parceria' ? 'selected' : '' }}>Parceria</option>
                            <option value="problema" {{ old('subject') == 'problema' ? 'selected' : '' }}>Problema Técnico</option>
                            <option value="outro" {{ old('subject') == 'outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mensagem *</label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="6" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('message') border-red-500 @enderror" 
                                  placeholder="Escreva sua mensagem aqui..." 
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Mínimo de 10 caracteres</p>
                    </div>
                    
                    <!-- Privacy Policy Checkbox -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" 
                                   name="privacy_accepted" 
                                   class="mt-1 mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded @error('privacy_accepted') border-red-500 @enderror" 
                                   {{ old('privacy_accepted') ? 'checked' : '' }} 
                                   required>
                            <span class="text-sm text-gray-700">
                                Concordo com a <a href="#" class="text-indigo-600 hover:text-indigo-800 underline">Política de Privacidade</a> 
                                e autorizo o uso dos meus dados para responder esta mensagem. *
                            </span>
                        </label>
                        @error('privacy_accepted')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-clock mr-1"></i>
                            Responderemos em até 24 horas
                        </p>
                        <button type="submit" 
                                class="bg-indigo-600 text-white px-8 py-3 rounded-md hover:bg-indigo-700 transition-colors font-semibold">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Enviar Mensagem
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Details -->
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informações de Contato</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-envelope text-indigo-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">E-mail</h3>
                                <p class="text-gray-600">contato@meublog.com</p>
                                <p class="text-gray-500 text-sm mt-1">Resposta em até 24 horas</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-phone text-indigo-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Telefone</h3>
                                <p class="text-gray-600">(11) 9999-9999</p>
                                <p class="text-gray-500 text-sm mt-1">Segunda a sexta, 9h às 18h</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-indigo-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Endereço</h3>
                                <p class="text-gray-600">São Paulo, SP<br>Brasil</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-indigo-600 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Horário de Atendimento</h3>
                                <p class="text-gray-600">Segunda a sexta: 9h às 18h</p>
                                <p class="text-gray-600">Sábado: 9h às 12h</p>
                                <p class="text-gray-500 text-sm mt-1">Fechado aos domingos</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Redes Sociais</h2>
                    <p class="text-gray-600 mb-6">Siga-nos nas redes sociais para ficar por dentro das novidades!</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all">
                            <i class="fab fa-facebook text-blue-600 text-2xl mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Facebook</p>
                                <p class="text-gray-500 text-sm">@meublog</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-all">
                            <i class="fab fa-twitter text-blue-400 text-2xl mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Twitter</p>
                                <p class="text-gray-500 text-sm">@meublog</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-pink-300 hover:bg-pink-50 transition-all">
                            <i class="fab fa-instagram text-pink-600 text-2xl mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Instagram</p>
                                <p class="text-gray-500 text-sm">@meublog</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-700 hover:bg-blue-50 transition-all">
                            <i class="fab fa-linkedin text-blue-700 text-2xl mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">LinkedIn</p>
                                <p class="text-gray-500 text-sm">@meublog</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- FAQ Quick Links -->
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Perguntas Frequentes</h2>
                    <div class="space-y-4">
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <h3 class="font-semibold text-gray-900 mb-1">Como posso sugerir um tópico?</h3>
                            <p class="text-gray-600 text-sm">Use o formulário ao lado selecionando "Sugestão" como assunto.</p>
                        </div>
                        
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <h3 class="font-semibold text-gray-900 mb-1">Vocês aceitam guest posts?</h3>
                            <p class="text-gray-600 text-sm">Sim! Entre em contato selecionando "Parceria" como assunto.</p>
                        </div>
                        
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <h3 class="font-semibold text-gray-900 mb-1">Como reportar um problema?</h3>
                            <p class="text-gray-600 text-sm">Selecione "Problema Técnico" e descreva o que aconteceu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section (Optional) -->
<section class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nossa Localização</h2>
            <p class="text-gray-600">Estamos localizados no coração de São Paulo</p>
        </div>
        
        <!-- Placeholder for map - you can integrate Google Maps or similar -->
        <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600">Mapa será carregado aqui</p>
                <p class="text-gray-500 text-sm">São Paulo, SP - Brasil</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Phone mask
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 11) {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (value.length >= 7) {
        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
    }
    e.target.value = value;
});

// Character counter for message
const messageTextarea = document.getElementById('message');
const messageContainer = messageTextarea.parentElement;

if (messageTextarea) {
    const counter = document.createElement('p');
    counter.className = 'mt-1 text-sm text-gray-500 text-right';
    messageContainer.appendChild(counter);
    
    function updateCounter() {
        const length = messageTextarea.value.length;
        counter.textContent = `${length} caracteres`;
        
        if (length < 10) {
            counter.className = 'mt-1 text-sm text-red-500 text-right';
        } else {
            counter.className = 'mt-1 text-sm text-gray-500 text-right';
        }
    }
    
    messageTextarea.addEventListener('input', updateCounter);
    updateCounter();
}

// Form validation
const form = document.querySelector('form');
if (form) {
    form.addEventListener('submit', function(e) {
        const message = document.getElementById('message').value;
        if (message.length < 10) {
            e.preventDefault();
            alert('A mensagem deve ter pelo menos 10 caracteres.');
            return false;
        }
    });
}

// Auto-fill form if user is logged in
@auth
document.addEventListener('DOMContentLoaded', function() {
    const nameField = document.getElementById('name');
    const emailField = document.getElementById('email');
    
    if (nameField && !nameField.value) {
        nameField.value = '{{ Auth::user()->name ?? '' }}';
    }
    if (emailField && !emailField.value) {
        emailField.value = '{{ Auth::user()->email ?? '' }}';
    }
});
@endauth
</script>
@endpush