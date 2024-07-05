<div class="flex flex-col space-y-1">
    @if (isset($row->active))
    <div>
        @if ((bool)$row->active)
            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                {{ __('Activated') }}
            </span>
        @else
            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                {{ __('Disabled') }}
            </span>
        @endif

    </div>
    @endif
    @if (isset($row->type))
    <div>
        @if ($row->type === 'administrator')
            <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                {{ __('Administrator') }}
            </span>
        @else
            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/10">
                {{ __('Customer') }}
            </span>
        @endif
    </div>
    @endif
</div>

