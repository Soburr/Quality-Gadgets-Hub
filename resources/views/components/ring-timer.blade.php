@props(['endsAt'])

{{--
    Renders the H / M / S ring dials. JS in public/js/app.js reads #flashCountdown's
    data-ends-at attribute and ticks the numbers + stroke-dashoffset every second.
--}}
<div class="countdown" id="flashCountdown" data-ends-at="{{ $endsAt->toIso8601String() }}">
    <div>
        <div class="ring-timer">
            <svg width="52" height="52">
                <circle class="bg" cx="26" cy="26" r="22" stroke-width="5" fill="none"/>
                <circle class="fg" id="ringH" cx="26" cy="26" r="22" stroke-width="5" fill="none" stroke-dasharray="138"/>
            </svg>
            <div class="num" id="numH">00</div>
        </div>
        <div class="timer-label">Hrs</div>
    </div>
    <div>
        <div class="ring-timer">
            <svg width="52" height="52">
                <circle class="bg" cx="26" cy="26" r="22" stroke-width="5" fill="none"/>
                <circle class="fg" id="ringM" cx="26" cy="26" r="22" stroke-width="5" fill="none" stroke-dasharray="138"/>
            </svg>
            <div class="num" id="numM">00</div>
        </div>
        <div class="timer-label">Min</div>
    </div>
    <div>
        <div class="ring-timer">
            <svg width="52" height="52">
                <circle class="bg" cx="26" cy="26" r="22" stroke-width="5" fill="none"/>
                <circle class="fg" id="ringS" cx="26" cy="26" r="22" stroke-width="5" fill="none" stroke-dasharray="138"/>
            </svg>
            <div class="num" id="numS">00</div>
        </div>
        <div class="timer-label">Sec</div>
    </div>
</div>
