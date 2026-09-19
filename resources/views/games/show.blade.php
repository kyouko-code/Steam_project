<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="text-sm text-gray-300 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('games.index') }}" class="hover:text-white">Store</a>
            <span class="mx-2">/</span>
            <span class="text-gray-300">{{ $game->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-gray-800 rounded-lg overflow-hidden">
                    @if($game->cover_image)
                        <img src="{{ $game->cover_image }}" alt="{{ $game->title }}" class="w-full aspect-video object-cover">
                    @else
                        <div class="w-full aspect-video bg-gray-700 flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="mt-8 bg-gray-800 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-white mb-4">About This Game</h2>
                    <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $game->description }}</p>
                </div>

                <div class="mt-8 bg-gray-800 rounded-lg p-6">
                    <h2 class="text-xl font-bold text-white mb-4">Reviews ({{ $game->reviews->count() }})</h2>

                    @if(auth()->check())
                        @php $myReview = $game->reviews->where('user_id', auth()->id())->first(); @endphp

                        @if(!$myReview)
                            <div class="mb-8 p-4 bg-gray-700/50 rounded-lg">
                                <h3 class="text-white font-semibold mb-3">Write a Review</h3>
                                <form method="POST" action="{{ route('reviews.store', $game->id) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm text-gray-300 mb-2" for="rating">Rating</label>
                                        <select name="rating" id="rating" class="block w-full max-w-xs rounded-md border-gray-600 bg-gray-900 text-white text-sm" required>
                                            <option value="5">5 - Excellent</option>
                                            <option value="4">4 - Great</option>
                                            <option value="3">3 - Good</option>
                                            <option value="2">2 - Fair</option>
                                            <option value="1">1 - Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm text-gray-300 mb-2" for="comment">Your Review</label>
                                        <textarea name="comment" id="comment" rows="4" class="block w-full rounded-md border-gray-600 bg-gray-900 text-white text-sm" placeholder="Share your experience with this game..." required></textarea>
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">Submit Review</button>
                                </form>
                            </div>
                        @endif
                    @endif

                    @if($game->reviews->count())
                        <div class="space-y-6">
                            @foreach($game->reviews as $review)
                                <div class="border-b border-gray-700 pb-5 last:border-0 last:pb-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="text-white font-medium text-sm">{{ $review->user->name }}</span>
                                                <span class="text-gray-400 text-xs ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118l-2.8-2.034c-.784-.57-.381-1.81.588-1.81h3.462a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @else
                                                        <svg class="h-4 w-4 fill-current text-gray-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.363-1.118l-2.8-2.034c-.784-.57-.381-1.81.588-1.81h3.462a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->isAdmin()))
                                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-400 text-sm transition">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                    <p class="text-gray-300 text-sm">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400">No reviews yet. Be the first to review this game!</p>
                    @endif
                </div>
            </div>

            <div>
                <div class="bg-gray-800 rounded-lg p-6 sticky top-4">
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $game->title }}</h1>
                    <p class="text-gray-300 text-sm mb-4">{{ $game->developer }}</p>

                    @if($game->genres->count())
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($game->genres as $genre)
                                <a href="{{ route('games.index', ['genre' => $genre->slug]) }}" class="px-3 py-1 bg-gray-700 rounded-full text-xs text-gray-300 hover:bg-gray-600 hover:text-white transition">
                                    {{ $genre->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-6">
                        @if($game->is_discounted)
                            <div class="flex items-center gap-3">
                                <span class="bg-green-600 text-white text-sm font-bold px-2 py-1 rounded">-{{ $game->discount_percent }}%</span>
                                <span class="text-gray-400 line-through">${{ number_format($game->price, 2) }}</span>
                                <span class="text-2xl font-bold text-green-400">${{ number_format($game->discount_price, 2) }}</span>
                            </div>
                        @else
                            <div class="text-2xl font-bold text-white">${{ number_format($game->price, 2) }}</div>
                        @endif
                    </div>

                    @if(auth()->check())
                        <form method="POST" action="{{ route('cart.add', $game->id) }}" class="mb-4">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                                </svg>
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition mb-4">
                            Login to Purchase
                        </a>
                    @endif

                    <div class="border-t border-gray-700 pt-4 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-300">Publisher</span>
                            <span class="text-white">{{ $game->publisher }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Developer</span>
                            <span class="text-white">{{ $game->developer }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Release Date</span>
                            <span class="text-white">{{ $game->release_date->format('M j, Y') }}</span>
                        </div>
                        @if($game->average_rating)
                            <div class="flex justify-between">
                                <span class="text-gray-300">Rating</span>
                                <span class="text-yellow-400">{{ number_format($game->average_rating, 1) }} / 5</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($relatedGames->count())
            <div class="mt-12">
                <h2 class="text-xl font-bold text-white mb-6">You Might Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedGames as $game)
                        @include('games._card', ['game' => $game])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>