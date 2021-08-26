<div>
    <div x-data="{
        running: false,
        time: '10',
        timer: null,
        timeTimer: null,
        href: '{{ $shortlink->target->url }}', cancelTimer() { clearTimeout(this.timer);
        clearInterval(this.timeTimer); this.running=false; }, resumeTimer() { this.timeTimer=setInterval(()=> {
        this.time = this.time - 1;
        }, 1000);
        this.timer = setTimeout(() => {
        window.location.href = this.href;
        }, this.time * 1000);
        this.running = true;
        }
        }" x-init="resumeTimer()">
        <h1 class="text-center">Redirect in <span x-text="time">10</span>s.</h1>
        <h2 class="text-center"><a href="{{ $shortlink->target->url }}">{{ $shortlink->target->url }}</a></h2>
        <x-disclaimer class="text-center" :shortlink="$shortlink" />
        </br>
        <button class="btn btn-danger w-100" x-on:click="cancelTimer()"
            x-show="running">{{ __('Cancel Redirect!') }}</button>
        <button class="btn btn-success w-100" x-on:click="resumeTimer()"
            x-show="!running">{{ __('Resume Redirect!') }}</button>
    </div>

</div>
