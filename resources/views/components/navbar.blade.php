<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-gray-900">TaskFlow</h1>
            </div>

            <div class="flex items-center gap-4">
                <!-- Workspace Switcher -->
                @auth
                    <div class="relative group">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            {{ session('workspace_id') && auth()->user()->workspaces()->find(session('workspace_id')) 
                                ? auth()->user()->workspaces()->find(session('workspace_id'))->name 
                                : 'Select Workspace' }}
                        </button>

                        <div class="hidden group-hover:block absolute right-0 mt-0 w-48 bg-white border border-gray-200 rounded shadow-lg z-50">
                            @foreach (auth()->user()->workspaces as $ws)
                                <form method="POST" action="{{ route('workspaces.switch', $ws) }}" class="block w-full text-left">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-900">
                                        {{ $ws->name }}
                                    </button>
                                </form>
                            @endforeach

                            <a href="{{ route('workspaces.create') }}" class="block px-4 py-2 border-t border-gray-200 text-blue-600 hover:bg-gray-100">
                                + New Workspace
                            </a>
                        </div>
                    </div>

                    <!-- User menu -->
                    <div class="relative group">
                        <button class="px-4 py-2 text-gray-700 hover:text-gray-900">
                            {{ auth()->user()->name }}
                        </button>
                        <div class="hidden group-hover:block absolute right-0 mt-0 w-48 bg-white border border-gray-200 rounded shadow-lg z-50">
                            <a href="{{ route('workspaces.edit', session('workspace_id')) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Workspace Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block w-full text-left">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 border-t border-gray-200">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>