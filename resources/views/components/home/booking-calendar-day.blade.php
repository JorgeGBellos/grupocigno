@props([])

{{-- Single-root Alpine x-for cell: empty placeholders keep the grid aligned. --}}
<button
    type="button"
    class="booking-calendar-day"
    :class="{
        'booking-calendar-day--edge': ! cell.empty && cell.state === 'edge',
        'booking-calendar-day--between': ! cell.empty && cell.state === 'between',
        'opacity-30': ! cell.empty && cell.disabled,
        'invisible pointer-events-none': cell.empty,
    }"
    :disabled="cell.empty || cell.disabled"
    @click="selectCalendarDay(cell.iso)"
>
    <span class="type-btn-md no-underline leading-none" x-text="cell.empty ? '' : cell.day"></span>
</button>
