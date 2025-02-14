@props(['disabled' => false])

@php
$isNumber = $attributes->get('type') === 'number';
$isRadio = $attributes->get('type') === 'radio';
$numberClasses = $isNumber ? 'appearance-none [&::-webkit-inner-spin-button]:appearance-none
[&::-webkit-outer-spin-button]:appearance-none [&::-moz-appearance:textfield]' : '';

$oldValue = old($attributes->get('name'));


$checked = $isRadio && ($oldValue == $attributes->get('value') || (is_null($oldValue) && $attributes->get('value')
==='true_false')) ? 'checked' : '';


@endphp

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500
focus:ring-indigo-500 rounded-md shadow-sm' . $numberClasses]) }} {{$checked}} >