<x-app-layout>
    <div 
        x-data="{ loading: false, success: false }"
        class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
    >
        <div class="bg-blue-500 border border-gray-200 rounded-xl p-6 shadow-lg">
            <!-- Success Message -->
            <div 
                x-show="success" 
                x-transition 
                class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded"
            >
                Announcement created successfully!
            </div>

            <!-- Title -->
            <h2 class="font-bold text-3xl text-center text-white mb-6">Create Announcement</h2>

            <!-- Form -->
            <form 
                x-ref="form"
                @submit.prevent="
                    loading = true;
                    let form = new FormData($refs.form);
                    fetch('{{ route('announcements.store') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: form
                    })
                    .then(res => res.ok ? res.text() : Promise.reject(res))
                    .then(() => { 
                        loading = false;
                        success = true;
                        $refs.form.reset();
                        // Optionally reload the sidebar if present
                        if (window.Alpine && Alpine.store('sidebar')) {
                            Alpine.store('sidebar').refresh();
                        }
                    })
                    .catch(() => { 
                        loading = false; 
                        alert('Something went wrong while posting.');
                    })"
                enctype="multipart/form-data"
                class="space-y-8 bg-transparent px-6 py-6 rounded-xl"
            >
                <!-- Title -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-yellow-300">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        required
                        class="w-full border-gray-300 focus:ring-0 focus:border-yellow-400 rounded-md p-3 text-sm shadow-sm" 
                    />
                </div>

                <!-- Content -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-white">Content</label>
                    <textarea 
                        name="content" 
                        rows="6" 
                        required
                        class="w-full border-gray-300 focus:ring-0 focus:border-yellow-400 rounded-md p-3 text-sm shadow-sm resize-none"
                    ></textarea>
                </div>

                <!-- Attachment -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-yellow-200">Attachment (optional)</label>
                    <input 
                        type="file" 
                        name="attachment"
                        class="w-full text-sm text-yellow-200 border border-white rounded-md cursor-pointer focus:outline-none focus:border-yellow-400 p-2" 
                    />
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ url()->previous() }}"
                        class="px-5 py-2 text-sm font-bold bg-yellow-400 hover:bg-yellow-200 text-gray-700 hover:text-gray-800 rounded-lg transition">
                        Cancel
                    </a>
                    <button 
                        type="submit"
                        x-bind:disabled="loading"
                        class="px-5 py-2 text-sm font-bold bg-yellow-400 hover:bg-yellow-300 text-black rounded-lg transition"
                    >
                        <span x-show="!loading">Post</span>
                        <span x-show="loading" class="animate-pulse">Posting...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
