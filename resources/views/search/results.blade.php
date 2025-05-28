{{-- resources/views/search/results.blade.php --}}
@extends('layouts.app')

@section('title', 'Search Results - Guhso')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Search Results</h1>
        @if($query)
            <p class="text-gray-600">Results for "{{ $query }}"</p>
        @else
            <p class="text-gray-600">Enter a search term to find podcasts and episodes</p>
        @endif
    </div>
    
    <!-- Search Form -->
    <div class="mb-12">
        <form action="{{ route('search') }}" method="GET" class="max-w-2xl">
            <div class="flex">
                <input type="text" name="q" value="{{ $query }}" placeholder="Search podcasts and episodes..." class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <button type="submit" class="bg-primary-500 text-white px-6 py-3 rounded-r-lg hover:bg-primary-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
    
    @if($query)
        <!-- Shows Results -->
        @if($shows->isNotEmpty())
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Podcast Shows ({{ $shows->count() }})</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($shows as $show)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
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
                            
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">{{ $show->title }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($show->description, 80) }}</p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">{{ $show->episodes_count ?? 0 }} episodes</span>
                                    <a href="{{ route('shows.show', $show) }}" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition-colors">
                                        View Show
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Episodes Results -->
        @if($episodes->isNotEmpty())
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Episodes ({{ $episodes->count() }})</h2>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        @foreach($episodes as $episode)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                            @if($episode->thumbnail_url || $episode->show->cover_image_url)
                                                <img src="{{ $episode->thumbnail_url ?: $episode->show->cover_image_url }}" alt="{{ $episode->title }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                                    <a href="{{ route('episodes.show', $episode) }}" class="hover:text-primary-600 transition-colors">
                                                        {{ $episode->title }}
                                                    </a>
                                                </h3>
                                                <p class="text-sm text-primary-600 mb-2">
                                                    <a href="{{ route('shows.show', $episode->show) }}" class="hover:text-primary-700">
                                                        {{ $episode->show->title }}
                                                    </a>
                                                </p>
                                                <p class="text-gray-600 mb-2">{{ Str::limit($episode->description, 200) }}</p>
                                                
                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                    @if($episode->published_at)
                                                        <span>{{ $episode->published_at->format('M j, Y') }}</span>
                                                    @endif
                                                    <span>{{ $episode->getFormattedDuration() }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="ml-4">
                                                <a href="{{ route('episodes.show', $episode) }}" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                                                    Listen
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        
        <!-- No Results -->
        @if($shows->isEmpty() && $episodes->isEmpty())
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
                <p class="text-gray-500">Try adjusting your search terms or browse our podcast categories instead.</p>
                <a href="{{ route('podcast') }}" class="inline-block mt-4 bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                    Browse Podcasts
                </a>
            </div>
        @endif
    @endif
</div>
@endsection