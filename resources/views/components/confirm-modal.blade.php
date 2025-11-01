@props(['id', 'title' => 'Are you sure?', 'message' => 'This action cannot be undone.'])

<div 
    x-data="{ open: false }"
    @confirm-{{ $id }}.window="open = true"
    x-show="open"
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    style="display: none;"
>
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" @click.away="open = false">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
        <p class="text-gray-600 mb-6">{{ $message }}</p>
        
        <div class="flex gap-3">
            <button 
                @click="$dispatch('confirmed-{{ $id }}'); open = false"
                class="flex-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-medium"
            >
                Delete
            </button>
            <button 
                @click="open = false"
                class="flex-1 px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300 font-medium"
            >
                Cancel
            </button>
        </div>
    </div>
</div>