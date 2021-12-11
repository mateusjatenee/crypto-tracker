<p {{ $attributes->merge(['class' => "flex items-baseline text-sm font-semibold text-{$color}-600"]) }}>
              
    <svg class="self-center flex-shrink-0 h-5 w-5 text-{{ $color }}-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
<path fill-rule="evenodd" d="{{ $svgContent }}" clip-rule="evenodd"></path>
</svg>
  {{ $percentage }}%
</p>