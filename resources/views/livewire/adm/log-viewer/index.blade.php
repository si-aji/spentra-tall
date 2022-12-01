@section('title', 'Log Viewer')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Log Viewer</span>
    </h4>
@endsection

<div>
    {{-- In work, do what you enjoy. --}}
    <div id="browser" class=" tw__shadow tw__rounded-t-xl">
        <div class=" tw__bg-[#343a40] tw__p-2 tw__rounded-t-xl" id="header">
            <div class=" tw__flex tw__items-center tw__gap-2">
                <a href="javascript:void(0)" class=" tw__text-white tw__ml-4" onclick="reloadIframe()"><i class='bx bx-refresh'></i></a>
                <p class=" tw__mb-0 tw__mx-auto tw__px-8 tw__py-1 tw__bg-gray-200 tw__rounded tw__text-center lg:tw__max-w-[450px] tw__max-w-[250px] tw__overflow-hidden tw__whitespace-nowrap tw__text-ellipsis tw__block">
                    <span class=" href-url">{{ env('APP_URL') }}</span>
                </p>
                <a href="javascript:void(0)" class=" tw__text-white tw__mr-4" onclick="newTabIframe()"><i class='bx bx-windows'></i></a>
            </div>
        </div>
        <div class=" tw__bg-white tw__rounded-b-xl tw__overflow-hidden" id="body">
            <iframe src="{{ route('blv.index') }}" class=" tw__w-full tw__min-h-[calc(100vh-175px)]" id="iframe" onload="frameLoaded(this)"></iframe>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        const frameLoaded = (el) => {
            console.log("Frame is loaded");
            setTimeout(() => {
                if(document.querySelector('.href-url')){
                    document.querySelector('.href-url').innerHTML = el.contentWindow.location.href;
                }
            }, 0);
        }
        function reloadIframe(){
            if(document.getElementById('iframe')){
                document.getElementById('iframe').contentWindow.location.reload();
            }
        }
        function newTabIframe(){
            if(document.getElementById('iframe')){
                let url = document.getElementById('iframe').contentWindow.location.href;
                window.open(url, "_blank");
            }
        }
    </script>
@endsection