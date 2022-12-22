<script>
    var vapid_pubkey = "{{ env('VAPID_PUBLIC_KEY') }}";
    var loggedIn = "{{ \Auth::check() }}";
    var subscribeBase = "{{ route('notification.subscribe') }}";
    var swBase = "{{ mix('serviceWorker.js') }}";
    var baseUrl = "{{ env('APP_URL') }}"
    // navigator.serviceWorker.getRegistrations().then(function(registrations) {
    //     for(let registration of registrations) {
    //         console.log(registration);
    //         registration.unregister();
    //     }
    // });
</script>
<script src="{{ mix('assets/js/service-worker.js') }}" defer></script>