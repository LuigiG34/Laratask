<div>
    <!-- Comments List -->
    <div class="space-y-4 mb-6">
        @forelse ($task->comments as $comment)
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    @if ($comment->user_id === auth()->id())
                        <div class="flex gap-2">
                            @if ($editingCommentId === $comment->id)
                                <button 
                                    wire:click="cancelEdit"
                                    class="text-gray-600 hover:text-gray-800 text-sm"
                                >
                                    Cancel
                                </button>
                            @else
                                <button 
                                    wire:click="editComment({{ $comment->id }})"
                                    class="text-blue-600 hover:text-blue-800 text-sm"
                                >
                                    Edit
                                </button>
                                <button 
                                    wire:click="deleteComment({{ $comment->id }})"
                                    wire:confirm="Are you sure you want to delete this comment?"
                                    class="text-red-600 hover:text-red-800 text-sm"
                                >
                                    Delete
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                @if ($editingCommentId === $comment->id)
                    <!-- Edit Form -->
                    <div>
                        <textarea 
                            wire:model="editingCommentBody"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
                        ></textarea>
                        @error('editingCommentBody')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <button 
                            wire:click="updateComment"
                            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
                        >
                            Save
                        </button>
                    </div>
                @else
                    <!-- Comment Body -->
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $comment->body }}</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>

    <!-- Add Comment Form -->
    <div class="border-t border-gray-200 pt-6">
        <h4 class="font-medium text-gray-900 mb-3">Add a comment</h4>
        <form wire:submit.prevent="addComment">
            <textarea 
                wire:model="newComment"
                rows="3"
                placeholder="Write a comment..."
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"
            ></textarea>
            @error('newComment')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <button 
                type="submit"
                class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium"
            >
                Post Comment
            </button>
        </form>
    </div>
</div>