<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <article>
            <header class="font-bold text-xl">
                Year {{ $year_level }}
            </header>
        </article>

    <div class="py-6">
        <div class="space-y-4">
            {{-- Dashboard Button --}}
                <div class="mb-4">
                    <a href="{{ route('dashboard') }}"
                    class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-md">
                    
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-medium mb-4">Your Classes</h3>

                @if($classes->isEmpty())
                    <p>No classes found for this year.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($classes as $class)
                            <li class="flex justify-between items-center py-2">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-gray-800">{{ $class->name }}</span>
                                    <span class="text-sm text-gray-500">Section: {{ $class->section ?? 'N/A' }}</span>
                                </div>

                              <div class="flex justify-center gap-3">
                                    {{-- Open Button --}}
                                    <a href="{{ route('classes.show', $class->id) }}" 
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white hover:bg-gray-500 hover:text-white text-blue-600 transition duration-300 shadow-sm"
                                    title="Open Class">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                                        </svg>
                                    </a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('classes.edit', $class->id) }}" 
                                    class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-600 transition duration-300 shadow-sm"
                                    title="Edit Class">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                        </svg>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this class?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 hover:bg-red-500 hover:text-white text-red-600 transition duration-300 shadow-sm"
                                                title="Delete Class">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>



                            </li>
                        @endforeach
                    </ul>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
