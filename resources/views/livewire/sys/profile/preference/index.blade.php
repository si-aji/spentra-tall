@section('title', 'Preference')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>Profile</span>
        <span class="active">Preference</span>
    </h4>
@endsection

<div id="user-preference">
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="row">
        <div class="col-lg-3 col-12 order-first order-lg-last">
            <div class="card lg:tw__sticky lg:tw__top-[6.5rem]">
                <div class="card-body">
                    <ul class="nav nav-pills tw__flex tw__flex-col">
                        @foreach ($extraMenu as $menu)
                            <li class="nav-item">
                                <a class="nav-link {{ $submenuState === $menu['state'] ? 'active' : '' }}" href="{{ isset($menu['route']) && !empty($menu['route']) ? route($menu['route']) : 'javascript:void(0);' }}"><i class="{{ $menu['icon'] }} me-1"></i> {{ $menu['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group tw__mb-4">
                        <label>Timezone</label>
                        <div wire:ignore>
                            <select class="form-control" name="timezone" id="input_preference-timezone">
                                <option value="">Search for Timezone Data</option>
                                @foreach ($timezone_list as $item)
                                    <option value="{{ $item->timezone }}">{{ $item->timezone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="timezone-detail"></div>
                    </div>

                    <div class="form-group">
                        <label>Daily Reminder</label>
                        <div wire:ignore>
                            <input type="text" class="form-control flatpickr" id="input_preference-daily_reminder" placeholder="Daily Reminder">
                        </div>
                        <small class=" text-muted tw__italic">Receive reminder to add your daily record</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        // Choices
        let preferenceTimezoneListChoice = null;
        // Flatpickr
        let preferenceDailyReminder;

        document.addEventListener('DOMContentLoaded', (e) => {
            // Choices
            if(document.getElementById('input_preference-timezone')){
                const timezoneEl = document.getElementById('input_preference-timezone');
                preferenceTimezoneListChoice = new Choices(timezoneEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Timezone Data",
                    placeholder: true,
                    placeholderValue: 'Search for Timezone Data',
                    shouldSort: false
                });
                preferenceTimezoneListChoice.passedElement.element.addEventListener('change', (e) => {
                    let value = e.target.value;

                    if(value){
                        @this.set('timezone_selected', value);
                    }
                    @this.set('preferenceKey', 'timezone');
                    @this.set('preferenceValue', value);
                    @this.save();
                });
                preferenceTimezoneListChoice.setChoiceByValue(@this.get('timezone_selected'));
            }

            // Flatpickr
            preferenceDailyReminder = flatpickr(document.getElementById('input_preference-daily_reminder'), {
                enableTime: true,
                altFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 1,
                allowInput: true,
                noCalendar: true,
                defaultDate: @this.get('reminder'),
                onValueUpdate: function(selectedDates, dateStr, instance){
                    @this.set('preferenceKey', 'record-reminder');
                    @this.set('preferenceValue', dateStr);
                    @this.save();
                }
            });

            window.dispatchEvent(new Event('getTimezoneDetail'));
        });

        window.addEventListener('getTimezoneDetail', (e) => {
            console.log('Get Timezone Detail is running...');
            let detail = @this.get('timezone_detail');
            if(detail){
                let tz = detail.timezone.timezone;
                let abb = detail.abbreviation;
                let offset = detail.utc_offset;
                if(document.getElementById('timezone-detail')){
                    let detail = document.createElement('small');
                    detail.classList.add('text-muted', 'tw__italic')
                    detail.innerHTML = `
                        <span>Timezone: <strong>${tz}</strong></span>
                        <span>Abbreviation: <strong>${abb}</strong></span>
                        <span>UTC Offset: <strong>${offset}</strong></span>
                    `;

                    document.getElementById('timezone-detail').appendChild(detail);
                }
            }
        });
    </script>
@endsection