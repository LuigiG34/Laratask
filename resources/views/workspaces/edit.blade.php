<x-app-layout>
    <div class="max-w-2xl mx-auto py-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Workspace Settings</h2>

        <!-- Edit workspace name -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Workspace Details</h3>

            <form method="POST" action="{{ route('workspaces.update', $workspace) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Workspace Name</label>
                    <input type="text" name="name" value="{{ $workspace->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Add members -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Members</h3>

            <div class="mb-6">
                <h4 class="font-medium text-gray-900 mb-3">Current Members</h4>
                <ul class="space-y-2">
                    @foreach ($workspace->users as $user)
                        <li class="flex justify-between items-center py-2 px-3 bg-gray-50 rounded">
                            <span class="text-gray-900">
                                {{ $user->name }} 
                                <span class="text-gray-600 text-sm">({{ $user->pivot->role }})</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if ($workspace->owner_id === auth()->id())
                <form method="POST" action="{{ route('workspaces.addMember', $workspace) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Add Member by Email</label>
                        <div class="flex gap-2">
                            <input type="email" name="email" required class="flex-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="user@example.com">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                                Add
                            </button>
                        </div>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </form>
            @endif
        </div>

        <!-- Delete workspace -->
        @if ($workspace->owner_id === auth()->id())
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-4">Danger Zone</h3>
                <form method="POST" action="{{ route('workspaces.destroy', $workspace) }}" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-medium">
                        Delete Workspace
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>