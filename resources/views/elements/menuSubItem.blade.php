@if (\Request::is($href))
    <li class="q-menu-active">
@else
    <li class="q-menu-item">
@endif
    <a class="menu-text" href="{{$href}}" >
        {{$text}}
    </a>
</li>
