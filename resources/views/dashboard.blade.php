<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Stream</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto space-y-6">

        {{-- Post a comment --}}
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form method="POST" action="{{ route('stream.comments.store') }}">
                @csrf
                <label class="block text-sm font-medium">Say something</label>
                <textarea name="body" rows="3" required maxlength="2000"
                          class="mt-1 w-full border rounded p-2"
                          placeholder="Type your comment..."></textarea>
                @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                <button class="mt-3 px-4 py-2 bg-gray-900 text-white rounded">Send</button>
            </form>
        </div>

        {{-- Comments feed --}}
        <div class="mt-6 space-y-6">
            @forelse($comments as $c)
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <span class="font-semibold">{{ $c->user->name }}</span>
                        <span>{{ $c->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 text-gray-900 whitespace-pre-wrap">{{ $c->body }}</p>
                </div>
            @empty
                <p class="text-gray-500">No comments yet. Be the first to say hi 👋</p>
            @endforelse

            @if(method_exists($comments,'links'))
                <div>{{ $comments->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
