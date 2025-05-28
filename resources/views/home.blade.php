@extends('layouts.app')

@section('title', 'Guhso - The Best Pop Culture Podcasts')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-amber-400 via-yellow-500 to-orange-500 overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-white">
                <!-- Available On Badges -->
                <div class="flex items-center space-x-4 mb-6">
                    <span class="text-sm font-medium opacity-90">Available on</span>
                    <div class="flex space-x-2">
                        <div class="w-8 h-8 bg-white/20 backdrop-blur rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold">G</span>
                        </div>
                        <div class="w-8 h-8 bg-white/20 backdrop-blur rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold">A</span>
                        </div>
                        <div class="w-8 h-8 bg-white/20 backdrop-blur rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold">S</span>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="mb-8">
                    <p class="text-sm font-semibold mb-2 opacity-90">THE BEST POP CULTURE PODCASTS TO LISTEN TO RIGHT NOW</p>
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
                        Every day we discuss the most interesting things
                    </h1>
                </div>
                
                <!-- Current Episode Player -->
                @if($latestEpisodes->isNotEmpty())
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 max-w-md">
                        @php $featured = $latestEpisodes->first() @endphp
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                                @if($featured->show->cover_image_url)
                                    <img src="{{ $featured->show->cover_image_url }}" alt="{{ $featured->show->title }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm opacity-90">{{ $featured->show->title }}</p>
                                <h3 class="font-semibold text-lg">Episode {{ $featured->episode_number ?? $featured->id }}</h3>
                                <p class="text-sm opacity-75">{{ $featured->getFormattedDuration() }}</p>
                            </div>
                        </div>
                        
                        <!-- Player Controls -->
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <button class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/>
                                    </svg>
                                </button>
                                <button class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-gray-900 hover:bg-gray-100 transition-colors">
                                    <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </button>
                                <button class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 18l8.5-6L6 6v12zM16 6v12h2V6h-2z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
                                    </svg>
                                </button>
                                <button class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Right Content - Featured Host -->
            <div class="relative">
                <div class="w-full h-96 bg-gradient-to-br from-orange-400 to-pink-500 rounded-3xl flex items-end justify-center overflow-hidden">
                    <!-- Placeholder for host image -->
                    <div class="w-64 h-80 bg-white/10 rounded-t-3xl"></div>
                </div>
                
                <!-- Keep It! Section -->
                <div class="absolute -right-4 top-8 bg-white rounded-2xl p-6 shadow-xl max-w-xs">
                    <h3 class="font-bold text-xl mb-2">Keep It!</h3>
                    <p class="text-gray-600 text-sm mb-4">Each week, the hosts get together with actors, politicians, and many others to discuss what's happening in entertainment.</p>
                    
                    <!-- More Themes -->
                    <div>
                        <h4 class="font-semibold mb-3">More themes</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <span class="bg-gray-100 px-3 py-1 rounded-full">+ Culture</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">★ Music</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">♦ Books</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">+ Movie</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">★ Celebrity</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">▲ TV</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Listen Our Best Podcast Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-start mb-12">
            <div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Listen our best podcast</h2>
                <p class="text-gray-600 max-w-2xl">The Podcast includes conversations with some of the biggest names in pop culture about movie, music, games, artist and more.</p>
            </div>
            <div class="text-sm text-gray-500">1/3</div>
        </div>
        
        <!-- Episode Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestEpisodes->take(3) as $episode)
                <div class="group cursor-pointer">
                    <div class="relative mb-4">
                        <div class="aspect-square bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl overflow-hidden">
                            @if($episode->thumbnail_url || $episode->show->cover_image_url)
                                <img src="{{ $episode->thumbnail_url ?: $episode->show->cover_image_url }}" 
                                     alt="{{ $episode->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <!-- Play Button Overlay -->
                        <button class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-900 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </button>
                    </div>
                    
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-900">Episode {{ $loop->iteration + 54 }}</h3>
                        <span class="text-sm text-gray-500">{{ $episode->getFormattedDuration() }}</span>
                    </div>
                    
                    <p class="text-gray-600 text-sm">{{ Str::limit($episode->description, 80) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Shows Section -->
@if($featuredShows->isNotEmpty())
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Featured Podcasts</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredShows as $show)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="aspect-video bg-gradient-to-br from-primary-200 to-primary-400">
                        @if($show->cover_image_url)
                            <img src="{{ $show->cover_image_url }}" alt="{{ $show->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-2">{{ $show->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($show->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">{{ $show->episodes_count }} episodes</span>
                            <a href="{{ route('shows.show', $show) }}" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                Listen
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection