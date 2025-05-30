{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Main Container -->
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Top Section: Hero + Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <div class="lg:col-span-2">
    <div class="hero-gradient rounded-3xl p-8 lg:p-12 text-white relative overflow-hidden h-96 lg:h-[650px]">
        
        <!-- Background Image (Optional) -->
        @if(isset($heroImage) && $heroImage)
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                 style="background-image: url('{{ $heroImage }}');">
                <!-- Dark overlay for text readability -->
                <div class="absolute inset-0 bg-black/40"></div>
            </div>
        @endif
        
        <!-- Gradient Background (Fallback or Overlay) -->
        <div class="absolute inset-0 bg-gradient-to-br from-amber-400 via-orange-400 to-red-400 {{ isset($heroImage) && $heroImage ? 'opacity-70' : 'opacity-90' }}"></div>
        
        <!-- Decorative Pattern -->
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 70% 20%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>
        
        <!-- Content -->
        <div class="relative z-10 h-full flex flex-col justify-between">
            
            <!-- Top Content -->
            <div>
                <!-- Available On Platforms -->
                <div class="flex items-center space-x-3 mb-6">
                    <span class="text-white/80 text-sm font-medium">Available on</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-google-podcasts text-xs"></i>
                        </div>
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-apple text-xs"></i>
                        </div>
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                            <i class="fab fa-spotify text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Main Heading -->
                <div class="mb-4">
                    <p class="text-white/90 text-sm lg:text-base font-medium mb-2 tracking-wide">
                        THE BEST POP CULTURE PODCASTS TO LISTEN TO RIGHT NOW
                    </p>
                    <h1 class="text-4xl lg:text-6xl font-bold leading-tight">
                        Every day we <span class="inline-flex items-center">👀</span><br>
                        discuss the most<br>
                        interesting things
                    </h1>
                </div>
            </div>

            <!-- Bottom Content - Enhanced Audio Player -->
            @if($latestEpisode ?? null)
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 max-w-2xl">
                <div class="flex items-center space-x-4">
                    
                    <!-- Album Art -->
                    <div class="w-16 h-16 bg-white/20 rounded-xl flex-shrink-0 overflow-hidden">
                        @if($latestEpisode->thumbnail_url)
                            <img src="{{ $latestEpisode->thumbnail_url }}" alt="Episode thumbnail" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-music text-white text-xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Episode Info & Controls -->
                    <div class="flex-1 min-w-0">
                        
                        <!-- Episode Details -->
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="text-white font-semibold text-sm truncate mb-1">
                                    {{ Str::limit($latestEpisode->title, 35) }}
                                </h3>
                                <p class="text-white/70 text-xs">
                                    Episode {{ $latestEpisode->episode_number ?? '1' }} • 
                                    @if($latestEpisode->duration)
                                        {{ gmdate('i', $latestEpisode->duration) }} min
                                    @else
                                        45 min
                                    @endif
                                </p>
                            </div>
                            <span class="text-white/60 text-xs bg-white/10 px-2 py-1 rounded-full">
                                Now Playing
                            </span>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-white/20 rounded-full h-1 mb-4">
                            <div class="bg-white h-1 rounded-full" style="width: 45%"></div>
                        </div>
                        
                        <!-- Player Controls -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Previous -->
                                <button class="text-white/70 hover:text-white transition-colors duration-200" id="prev-btn">
                                    <i class="fas fa-step-backward text-sm"></i>
                                </button>
                                
                                <!-- Play/Pause -->
                                <button class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-200 hover:scale-105" id="play-btn">
                                    <i class="fas fa-play text-white text-sm ml-0.5" id="play-icon"></i>
                                </button>
                                
                                <!-- Next -->
                                <button class="text-white/70 hover:text-white transition-colors duration-200" id="next-btn">
                                    <i class="fas fa-step-forward text-sm"></i>
                                </button>
                            </div>
                            
                            <!-- Volume & More -->
                            <div class="flex items-center space-x-3">
                                <button class="text-white/70 hover:text-white transition-colors duration-200">
                                    <i class="fas fa-volume-up text-sm"></i>
                                </button>
                                <button class="text-white/70 hover:text-white transition-colors duration-200">
                                    <i class="fas fa-expand text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @else
            <!-- Fallback Player when no episode -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <div class="text-center">
                    <i class="fas fa-podcast text-white/60 text-3xl mb-3"></i>
                    <h3 class="text-white font-semibold mb-2">Ready to Listen?</h3>
                    <p class="text-white/70 text-sm mb-4">Discover amazing episodes in our collection</p>
                    <button class="bg-white/20 hover:bg-white/30 text-white px-6 py-2 rounded-full text-sm font-medium transition-all duration-200">
                        Browse Episodes
                    </button>
                </div>
            </div>
            @endif
            
        </div>
    </div>
</div>

            <!-- Sidebar (Right - 1/3 width) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-sm h-96 lg:h-[650px]">
                    <!-- Featured Show -->
                    @if($featuredShow ?? null)
                    <div class="mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl mb-4 flex-shrink-0"></div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $featuredShow->title }}</h2>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ Str::limit($featuredShow->description, 120) }}
                        </p>
                    </div>
                    @endif

                    <!-- Categories -->
                    <div>
                        <h3 class="text-gray-900 font-semibold mb-4">More themes</h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($categories as $category)
                            <a href="#" 
                               class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm">
                                        @switch($category->slug ?? $category->name)
                                            @case('culture')
                                                ✦
                                                @break
                                            @case('music')
                                                ★
                                                @break
                                            @case('celebrity')
                                                ♦
                                                @break
                                            @case('tv')
                                                ▲
                                                @break
                                            @case('movies')
                                                ♦
                                                @break
                                            @default
                                                •
                                        @endswitch
                                    </span>
                                    <span class="text-gray-700 text-sm font-medium">{{ $category->name }}</span>
                                </div>
                                <span class="text-gray-400 group-hover:text-gray-600 transition-colors">
                                    @if($category->shows_count > 0)
                                        {{ $category->shows_count }}
                                    @endif
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Episodes -->
        <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">Listen our best podcast</h2>
                    <p class="text-gray-600">
                        The Podcast includes conversations with some of the biggest names in pop culture about movie, music, games, artist and more.
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="prevEpisode" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="nextEpisode" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Episodes Slider -->
            <div class="overflow-hidden" id="episodesContainer">
                <div class="flex space-x-6 transition-transform duration-300 ease-in-out" id="episodesSlider">
                    @foreach($recentEpisodes as $episode)
                    <div class="flex-shrink-0 w-80">
                        <div class="bg-gray-50 rounded-3xl p-6 h-full">
                            <div class="flex items-start space-x-4">
                                <!-- Episode Image -->
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-300 to-gray-400 rounded-2xl flex-shrink-0 overflow-hidden">
                                    @if($episode->image_url)
                                        <img src="{{ $episode->image_url }}" alt="{{ $episode->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-amber-400 to-orange-500"></div>
                                    @endif
                                </div>
                                
                                <!-- Episode Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold text-gray-900">Episode {{ $episode->episode_number ?? $loop->iteration + 54 }}</span>
                                        <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm hover:shadow-md transition-shadow">
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <h3 class="text-gray-900 font-semibold text-sm mb-1 line-clamp-2">{{ Str::limit($episode->title, 60) }}</h3>
                                    <p class="text-gray-500 text-xs">{{ $episode->duration_formatted ?? '30 minutes' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination Dots -->
            <div class="flex justify-center space-x-2 mt-6">
                <div class="w-2 h-2 bg-gray-900 rounded-full"></div>
                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Episode slider functionality
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('episodesSlider');
    const container = document.getElementById('episodesContainer');
    // const prevBtn = document.getElementById('prevEpisode');
    // const nextBtn = document.getElementById('nextEpisode');
    const playButton = document.getElementById('play-btn');
    const playIcon = document.getElementById('play-icon');
    const prevButton = document.getElementById('prev-btn');
    const nextButton = document.getElementById('next-btn');


    let isPlaying = false;
    
    if (playButton && playIcon) {
        // Play/Pause functionality
        playButton.addEventListener('click', function() {
            isPlaying = !isPlaying;
            
            if (isPlaying) {
                playIcon.className = 'fas fa-pause text-white text-sm';
                // TODO: Add actual audio play functionality
                console.log('Playing episode...');
            } else {
                playIcon.className = 'fas fa-play text-white text-sm ml-0.5';
                // TODO: Add actual audio pause functionality
                console.log('Pausing episode...');
            }
        });
    }
    
    // Previous episode
    if (prevButton) {
        prevButton.addEventListener('click', function() {
            console.log('Previous episode - ready for implementation');
        });
    }
    
    // Next episode
    if (nextButton) {
        nextButton.addEventListener('click', function() {
            console.log('Next episode - ready for implementation');
        });
    }
    
    // Check if elements exist before proceeding
    if (!slider || !container || !prevBtn || !nextBtn) {
        console.warn('Episode slider elements not found');
        return;
    }
    
    let currentIndex = 0;
    // Count episodes from DOM instead of relying on PHP variable
    const episodeCards = slider.querySelectorAll('.flex-shrink-0');
    const totalEpisodes = episodeCards.length;
    const episodesPerView = 3;
    const maxIndex = Math.max(0, totalEpisodes - episodesPerView);
    
    function updateSlider() {
        const translateX = -(currentIndex * (320 + 24)); // 320px width + 24px gap
        slider.style.transform = `translateX(${translateX}px)`;
        
        // Update button states
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIndex;
        
        // Update button opacity
        prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
    }
    
    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlider();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSlider();
        }
    });
    
    // Initialize only if we have episodes
    if (totalEpisodes > 0) {
        updateSlider();
    }
});
</script>
@endsection