@extends('layouts.app')

@section('title', $show->title . ' - Guhso')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Show Header -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="md:flex">
            <div class="md:flex-shrink-0">
                <div class="h-48 w-full md:w-48 bg-gradient-to-br from-primary-200 to-primary-400 flex items-center justify-center">
                    @if($show->cover_image_url)
                        <img src="{{ $show->cover_image_url }}" alt="{{ $show->title }}" class="h-full w-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    @endif
                </div>
            </div>
            
            <div class="p-8">
                <div class="uppercase tracking-wide text-sm text-primary-500 font-semibold mb-1">
                    @if($show->isRssFeed()) RSS Feed @else Manual Show @endif
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $show->title }}</h1>
                @if($show->author)
                    <p class="text-gray-600 mb-4">by {{ $show->author }}</p>
                @endif
                <p class="text-gray-700 mb-4">{{ $show->description }}</p>
                
                <!-- Categories -->
                @if($show->categories->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($show->categories as $category)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
                
                <!-- Stats -->
                <div class="flex items-center space-x-6 text-sm text-gray-500">
                    <span>{{ $show->getEpisodeCount() }} episodes</span>
                    <span>{{ $show->language }}</span>
                    @if($show->last_fetched_at)
                        <span>Updated {{ $show->last_fetched_at->diffForHumans() }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Episodes List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Episodes</h2>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($episodes as $episode)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start space-x-4">
                        <!-- Episode Thumbnail -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                @if($episode->thumbnail_url)
                                    <img src="{{ $episode->thumbnail_url }}" alt="{{ $episode->title }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Episode Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        <a href="{{ route('episodes.show', $episode) }}" class="hover:text-primary-600 transition-colors">
                                            {{ $episode->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 mb-2">{{ Str::limit($episode->description, 200) }}</p>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        @if($episode->published_at)
                                            <span>{{ $episode->published_at->format('M j, Y') }}</span>
                                        @endif
                                        <span>{{ $episode->getFormattedDuration() }}</span>
                                        <span>{{ $episode->getFavoritesCount() }} favorites</span>
                                        <span>{{ $episode->getCommentsCount() }} comments</span>
                                    </div>
                                </div>
                                
                                <!-- Episode Actions -->
                                <div class="flex items-center space-x-2 ml-4">
                                    @auth
                                        <form action="{{ route('episodes.favorite', $episode) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 rounded-full {{ Auth::user()->hasFavorited($episode) ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600' }} hover:bg-opacity-80 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endauth
                                    
                                    <button class="p-2 bg-primary-500 text-white rounded-full hover:bg-primary-600 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No episodes yet</h3>
                    <p class="text-gray-500">This podcast doesn't have any episodes yet. Check back later!</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($episodes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $episodes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection