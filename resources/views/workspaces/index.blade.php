<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Workspaces</h2>
            <a href="{{ route('workspaces.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                New Workspace
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($workspaces as $workspace)
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $workspace->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $workspace->projects_count ?? 0 }} projects</p>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('workspaces.switch', $workspace) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                Switch
                            </button>
                        </form>
                        <a href="{{ route('workspaces.edit', $workspace) }}" class="px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300 text-sm">
                            Edit
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-600 mb-4">No workspaces yet</p>
                    <a href="{{ route('workspaces.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Create Workspace
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>