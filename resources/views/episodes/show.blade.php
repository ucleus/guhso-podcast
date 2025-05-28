@extends('layouts.app')

@section('title', $episode->title . ' - ' . $episode->show->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Episode Header -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="p-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('shows.show', $episode->show) }}" class="text-primary-600 hover:text-primary-700">{{ $episode->show->title }}</a></li>
                    <li class="text-gray-500">/</li>
                    <li class="text-gray-900 font-medium">{{ $episode->title }}</li>
                </ol>
            </nav>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $episode->title }}</h1>
            
            <!-- Episode Meta -->
            <div class="flex items-center space-x-6 text-sm text-gray-500 mb-6">
                @if($episode->published_at)
                    <span>{{ $episode->published_at->format('F j, Y') }}</span>
                @endif
                <span>{{ $episode->getFormattedDuration() }}</span>
                <span>{{ $episode->getFormattedFileSize() }}</span>
                <span>{{ $episode->getFavoritesCount() }} favorites</span>
            </div>
            
            <!-- Audio Player -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <audio controls class="w-full" preload="metadata">
                    <source src="{{ $episode->audio_url }}" type="{{ $episode->mime_type }}">
                    Your browser does not support the audio element.
                </audio>
            </div>
            
            <!-- Episode Actions -->
            <div class="flex items-center space-x-4 mb-6">
                @auth
                    <form action="{{ route('episodes.favorite', $episode) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ Auth::user()->hasFavorited($episode) ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }} hover:bg-opacity-80 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span>{{ Auth::user()->hasFavorited($episode) ? 'Unfavorite' : 'Favorite' }}</span>
                        </button>
                    </form>
                @endauth
                
                <button class="flex items-center space-x-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    <span>Share</span>
                </button>
            </div>
            
            <!-- Episode Description -->
            @if($episode->description)
                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold mb-3">About this episode</h3>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($episode->description)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Comments Section -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Comments ({{ $episode->getCommentsCount() }})</h2>
        </div>
        
        <!-- Add Comment Form -->
        @auth
            <div class="p-6 border-b border-gray-200">
                <form action="{{ route('episodes.comment', $episode) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating (optional)</label>
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-rating text-2xl text-gray-300 hover:text-yellow-400 focus:text-yellow-400" data-rating="{{ $i }}">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input">
                    </div>
                    
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Your comment</label>
                        <textarea name="content" id="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required></textarea>
                    </div>
                    
                    <button type="submit" class="bg-primary-500 text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition-colors">
                        Post Comment
                    </button>
                </form>
            </div>
        @else
            <div class="p-6 border-b border-gray-200 text-center">
                <p class="text-gray-600 mb-4">Please <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700">login</a> to leave a comment.</p>
            </div>
        @endauth
        
        <!-- Comments List -->
        <div class="divide-y divide-gray-200">
            @forelse($episode->comments as $comment)
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                @if($comment->hasRating())
                                    <span class="text-yellow-400">{{ $comment->getStarRating() }}</span>
                                @endif
                            </div>
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No comments yet</h3>
                    <p class="text-gray-500">Be the first to leave a comment on this episode!</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Related Episodes -->
    @if($relatedEpisodes->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">More from {{ $episode->show->title }}</h2>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($relatedEpisodes as $related)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 mb-1">
                                    <a href="{{ route('episodes.show', $related) }}" class="hover:text-primary-600 transition-colors">
                                        {{ $related->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ $related->published_at?->format('M j, Y') }} • {{ $related->getFormattedDuration() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating');
    const ratingInput = document.getElementById('rating-input');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;
            
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
});
</script>
@endsection
@endsection