@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Roque - Portal do Cliente')
<img src="{{ asset('build/assets/imgs/logo_principal.png') }}" class="logo" alt="Logo da Roque">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
