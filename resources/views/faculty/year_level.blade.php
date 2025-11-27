<x-app-layout>
<div 
    x-data="{
        showEditModal: false,
        editClass: { id: null, name: '', section: '', subject: '', schedule: '', year_level: {{ $year_level }} },
        openEditModal(cls) {
            this.editClass = { ...cls };
            this.showEditModal = true;
        }
    }" 
    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6"
>
    <!-- Header -->
    <header class="font-bold text-2xl mb-4">
        Year {{ $year_level }}
    </header>

    <!-- Dashboard Back Button -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}"
           class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"/>
            </svg>
        </a>
    </div>

    <!-- Classes List -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-medium mb-4">Your Classes</h3>

        @if($classes->isEmpty())
            <p>No classes found for this year.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($classes as $class)
                    <li class="flex justify-between items-center py-3">
                        <div>
                            <div class="font-semibold text-gray-800">{{ $class->name }}</div>
                            <div class="text-sm text-gray-500">Section: {{ $class->section ?? 'N/A' }}</div>
                        </div>

                        <div class="flex gap-3">
                            <!-- Open -->
                            <a href="{{ route('classes.show', $class->id) }}" 
                               class="w-10 h-10 flex items-center justify-center rounded-full text-blue-600 bg-white hover:bg-gray-500 hover:text-white shadow-sm transition"
                               title="Open Class">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47V4.262A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z"/>
                                </svg>
                            </a>

                            <!-- Edit (overlay trigger) -->
                            <button 
                                @click="openEditModal({ 
                                    id: {{ $class->id }},
                                    name: '{{ $class->name }}',
                                    section: '{{ $class->section ?? '' }}',
                                    subject: '{{ $class->subject ?? '' }}',
                                    schedule: '{{ $class->schedule ?? '' }}',
                                    year_level: {{ $class->year_level }}
                                })"
                                class="w-10 h-10 flex items-center justify-center rounded-full text-yellow-600 bg-yellow-100 hover:bg-yellow-500 hover:text-white shadow-sm transition"
                                title="Edit Classes">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0L16.862 3.43l3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712L3.651 16.637a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/>
                                </svg>
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Delete this class?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-10 h-10 flex items-center justify-center rounded-full text-red-600 bg-red-100 hover:bg-red-500 hover:text-white shadow-sm transition"
                                        title="Delete Class">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227A48.816 48.816 0 0 1 20.378 5.217a.75.75 0 1 1-.256 1.478L19.913 6.66l-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- 🟦 Edit Modal Overlay -->
    <div x-show="showEditModal" 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         x-transition>
        <div @click.away="showEditModal = false" class="bg-gradient-to-br from-blue-600 to-blue-700 shadow-xl rounded-2xl p-8 border border-blue-500 w-full max-w-2xl text-white">
            <h2 class="text-2xl font-bold text-center mb-6">Edit Class</h2>
            
            <form :action="`/classes/${editClass.id}`" method="POST" class="space-y-6 pt-2">
                @csrf
                @method('PUT')

                <!-- Course Description -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Course Description</label>
                    <input type="text" name="name" x-model="editClass.name"
                        class="w-full rounded-lg border border-blue-300 p-3.5 text-sm text-black focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 placeholder-gray-500 shadow-sm"
                        required placeholder="e.g. Keyboarding 1">
                </div>

                <!-- Section -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Section</label>
                    <input type="text" name="section" x-model="editClass.section"
                        class="w-full rounded-lg border border-blue-300 p-3.5 text-sm text-black focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 placeholder-gray-500 shadow-sm"
                        placeholder="e.g. 1A – 1st Laboratory">
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Subject</label>
                    <input type="text" name="subject" x-model="editClass.subject"
                        class="w-full rounded-lg border border-blue-300 p-3.5 text-sm text-black focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 placeholder-gray-500 shadow-sm"
                        placeholder="e.g. ITE 359">
                </div>

                <!-- Schedule -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Schedule</label>
                    <input type="text" name="schedule" x-model="editClass.schedule"
                        class="w-full rounded-lg border border-blue-300 p-3.5 text-sm text-black focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 placeholder-gray-500 shadow-sm"
                        placeholder="e.g. Mon & Wed 10:00–11:30 AM">
                </div>

                <input type="hidden" name="year_level" :value="editClass.year_level">

                <!-- Action Buttons -->
                <div class="pt-6 mt-4 flex justify-end gap-3 border-t border-blue-400/40">
                    <button type="submit"
                        class="px-6 py-2.5 bg-yellow-400 hover:bg-yellow-300 text-black font-bold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-150">
                        Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
</x-app-layout>
