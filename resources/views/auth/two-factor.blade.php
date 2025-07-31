<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Two-Factor Authentication</h2>

        <p class="mb-4">We sent a 6-digit code to your email. Please enter it below:</p>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.store') }}">
            @csrf
            <input type="text" name="two_factor_code" placeholder="Enter 6-digit code"
                class="border rounded w-full p-2 mb-4">

            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Verify
            </button>
        </form>
    </div>
</x-guest-layout>
