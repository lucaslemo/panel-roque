
<div>
    <form wire:submit.prevent="addUser">
        <div class="flex flex-row">
            <select wire:model="user" name="user" id="user" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-6/12">
                <option value="0" disabled selected>{{ __('Select an option') }}</option>
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{ $user->name }}</option>
                @endforeach
            </select>

            <div class="flex gap-4">
                <button class="inline-flex items-center p-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mt-1 ms-2">
                    {{ __('Add') }}
                </button>

                <x-action-message class="me-3 font-semibold text-green-500 self-center mt-1" on="add-user">
                    {{ __('Added successfully!') }}
                </x-action-message>
            </div>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('user')" />
    </form>
</div>
