<div class="btn-border-dash drag-area {{ isset($class) ? $class : '' }}" style="{{ isset($style) ? $style : '' }}">
    <div class="icon text-center">
        {!! $slot !!}
    </div>
    {!!isset($text) ? '<span class="support text-center">'.$text.' <span class="drag-area-description"></span></span>' : ''!!}
</div>
