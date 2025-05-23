@props([
    'options' => [], 'name', 'selected' => null, 'label' => false
])

@if ($label)
    <label for="">{{ $label }} </label>
@endif

<select
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'form-select',
        'is-invalid' => $errors->has($name),
    ]) }}
>
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @selected($value == $selected)> {{ $text }} </option>
    @endforeach
</select>

{{-- <x-form.validation-feedback :name="$name" /> --}}


{{-- @props([
    'type'=>'options', 'name', 'value'=>'selected'
])

@if ($label)
    <label for="">{{ $label }} </label>
@endif

<select
    name="{{$name}}"
    {{$attributes->class([
        'form-control',
        'form-select',
        'is-invalid' => $errors->has($name);
    ])}}
>
        @foreach ($options as $value => $text)
            <option value="{{$value}}" @selected($value == $selected)> {{$text}} </option>
        @endforeach
</select>

<x-form.validation-feedback :name="$name" /> --}}