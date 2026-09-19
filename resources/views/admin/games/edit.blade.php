<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Edit: {{ $game->title }}</h1>
            <a href="{{ route('admin.games.index') }}" class="text-gray-300 hover:text-white text-sm transition">&larr; Back to Games</a>
        </div>

        <form method="POST" action="{{ route('admin.games.update', $game) }}" class="bg-gray-800 rounded-lg p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $game->title) }}" required
                           class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="publisher" class="block text-sm font-medium text-gray-300 mb-2">Publisher *</label>
                    <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $game->publisher) }}" required
                           class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="developer" class="block text-sm font-medium text-gray-300 mb-2">Developer *</label>
                    <input type="text" id="developer" name="developer" value="{{ old('developer', $game->developer) }}" required
                           class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="release_date" class="block text-sm font-medium text-gray-300 mb-2">Release Date *</label>
                    <input type="date" id="release_date" name="release_date" value="{{ old('release_date', $game->release_date->format('Y-m-d')) }}" required
                           class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price (USD) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $game->price) }}" required
                           class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="discount_price" class="block text-sm font-medium text-gray-300 mb-2">Discount Price (Optional)</label>
                    <input type="number" id="discount_price" name="discount_price" step="0.01" min="0" value="{{ old('discount_price', $game->discount_price) }}"
                           class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-300 mb-2">Cover Image URL (Optional)</label>
                    <input type="url" id="cover_image" name="cover_image" value="{{ old('cover_image', $game->cover_image) }}"
                           class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="genres" class="block text-sm font-medium text-gray-300 mb-2">Genres</label>
                    <select id="genres" name="genres[]" multiple
                            class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm h-32">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" @selected($game->genres->contains($genre->id))>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description *</label>
                <textarea id="description" name="description" rows="6" required
                          class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('description', $game->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status *</label>
                    <select id="status" name="status" class="block w-full rounded-md border-gray-600 bg-gray-900 text-white focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="active" @selected(old('status', $game->status) == 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $game->status) == 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="flex items-center mt-6">
                    <input type="checkbox" id="featured" name="featured" value="1" @checked(old('featured', $game->featured))
                           class="h-4 w-4 text-blue-600 border-gray-600 rounded">
                    <label for="featured" class="ml-2 text-sm text-gray-300">Featured on homepage</label>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 rounded-md text-sm font-semibold text-white hover:bg-blue-500 transition">
                    Update Game
                </button>
                <a href="{{ route('admin.games.index') }}" class="text-sm text-gray-300 hover:text-white transition">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>