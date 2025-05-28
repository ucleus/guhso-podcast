@extends('layouts.app')

@section('title', 'Podcasts - Guhso')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Podcast Shows</h1>
        <p class="text-xl text-gray-600">Discover amazing podcasts across various categories</p>
    </div>
    
    <!-- Filters -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-4">
            <button class="px-4 py-2 bg-primary-500 text-white rounded-lg">All</button>
            @foreach($categories as $category)
                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    {{ $category->name }} ({{ $category->shows_count }})
                </button>
            @endforeach
        </div>
    </div>
    
    <!-- Shows Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($shows as $show)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="aspect-square bg-gradient-to-br from-primary-200 to-primary-400">
                    @if($show->cover_image_url)
                        <img src="{{ $show->cover_image_url }}" alt="{{ $show->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2">{{ $show->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($show->description, 80) }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ $show->episodes_count }} episodes</span>
                        <a href="{{ route('shows.show', $show) }}" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-600 transition-colors">
                            Listen
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-12">
        {{ $shows->links() }}
    </div>
</div>
@endsection