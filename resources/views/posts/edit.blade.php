<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Edit Post</h2></x-slot>
    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('posts.update',$post) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm font-medium">Title</label>
                    <input name="title" class="mt-1 w-full border rounded p-2" value="{{ old('title',$post->title) }}" required>
                    @error('title')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Body</label>
                    <textarea name="body" class="mt-1 w-full border rounded p-2" rows="3">{{ old('body',$post->body) }}</textarea>
                </div>
                <button class="px-3 py-2 bg-black text-white rounded">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
