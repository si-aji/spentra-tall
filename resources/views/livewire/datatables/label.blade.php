<div class="tw__table-cell tw__px-6 tw__py-2 tw__whitespace-no-wrap @if($column['headerAlign'] === 'right') tw__text-right @elseif($column['headerAlign'] === 'center') tw__text-center @else tw__text-left @endif {{ $this->cellClasses($row, $column) }}">
    {!! $column['content'] ?? '' !!}
</div>