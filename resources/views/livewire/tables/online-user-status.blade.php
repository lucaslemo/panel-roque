<div class="flex items-center">
    @if ((bool)$row->last_activity === true)
        <div class="w-4 h-4 rounded-full bg-green-500/50 ring-1 ring-inset ring-green-600/20 shadow-sm hover:bg-green-500/80"></div>
    @else
        <div class="w-4 h-4 rounded-full bg-red-500/50 ring-1 ring-inset ring-red-600/20 shadow-sm hover:bg-red-500/80"></div>
    @endif
</div>
