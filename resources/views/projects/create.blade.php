<x-app-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="mb-6">
            <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Projects</a>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Project</h2>

        <form method="POST" action="{{ route('projects.store') }}" class="space-y-6 bg-white rounded-lg shadow p-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Project Name *</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    required 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" 
                    placeholder="Website Redesign"
                >
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea 
                    name="description" 
                    rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                    placeholder="What is this project about?"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Project Color *</label>
                <div class="grid grid-cols-8 gap-2">
                    @php
                        $colors = [
                            '#3B82F6', // Blue
                            '#EF4444', // Red
                            '#10B981', // Green
                            '#F59E0B', // Yellow
                            '#8B5CF6', // Purple
                            '#EC4899', // Pink
                            '#14B8A6', // Teal
                            '#F97316', // Orange
                        ];
                    @endphp
                    
                    @foreach ($colors as $color)
                        <label class="cursor-pointer">
                            <input 
                                type="radio" 
                                name="color" 
                                value="{{ $color }}" 
                                class="hidden peer"
                                {{ old('color', '#3B82F6') === $color ? 'checked' : '' }}
                            >
                            <div 
                                class="w-10 h-10 rounded-full border-2 border-transparent peer-checked:border-gray-900 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-900 transition"
                                style="background-color: {{ $color }}"
                            ></div>
                        </label>
                    @endforeach
                </div>
                @error('color')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                    Create Project
                </button>
                <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300 font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>