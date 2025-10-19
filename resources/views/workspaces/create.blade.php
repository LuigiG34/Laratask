<x-app-layout>
    <div class="max-w-md mx-auto py-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create Workspace</h2>

        <form method="POST" action="{{ route('workspaces.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Workspace Name</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="My Awesome Team">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                Create
            </button>
        </form>
    </div>
</x-app-layout>