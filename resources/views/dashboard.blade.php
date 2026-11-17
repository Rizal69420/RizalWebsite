<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Dynamic Greeting based on role -->
                    <h1 class="text-2xl font-bold mb-2">
                        @if(auth()->user()->role === 'admin')
                            Hello Admin 🚀
                        @else
                            Hello World 👋
                        @endif
                    </h1>
                    <p class="text-gray-600">You're logged in as: <span class="font-semibold">{{ auth()->user()->email }}</span></p>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>