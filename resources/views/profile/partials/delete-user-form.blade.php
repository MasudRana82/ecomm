<section class="space-y-6">
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <div class="mt-6">
            <label for="password" class="sr-only">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="{{ __('Password') }}"
            />
            @if($errors->userDeletion->get('password'))
                <div class="mt-2 text-sm text-red-600">
                    {{ $errors->userDeletion->first('password') }}
                </div>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Delete Account') }}
            </button>
        </div>
    </form>
</section>
