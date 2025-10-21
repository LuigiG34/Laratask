<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if ($workspace)
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-900">{{ $workspace->name }}</h2>
                <p class="text-gray-600 mt-1">{{ $workspace->projects()->count() }} projects</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600">Welcome to your workspace! Start by creating a project.</p>
                <a href="#" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Create Project
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-600 mb-4">Welcome to your workspace!</p>
                <a href="{{ route('projects.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    View Projects
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 mb-4">No workspace selected</p>
                <a href="{{ route('workspaces.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Choose Workspace
                </a>
            </div>
        @endif
    </div>
</x-app-layout>