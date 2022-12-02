@section('title', 'Budget List')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Budget: List</span>
    </h4>
@endsection

<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="card">
        <div class="card-body tw__p-0">
            <div class="sa-header tw__bg-white tw__rounded-t-lg tw__p-4">
                <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                    @if ($paginate->total() > 0)
                        <span>Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }} result{{ $paginate->total() > 1 ? 's' : '' }}</span>
                    @else
                        <span>No data to be shown</span>
                    @endif
                    <div class="">
                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-budget">
                            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="">
                <div class=" tw__hidden lg:tw__grid tw__grid-flow-col tw__grid-cols-3 tw__items-center tw__gap-4 tw__px-4 tw__py-2 tw__border-t">
                    <span>Name</span>
                    <span>Budget</span>
                    <span class=" tw__flex tw__justify-end">Action</span>
                </div>
                <div id="budget-container" wire:ignore></div>
            </div>

            <div class="sa-footer tw__bg-white tw__rounded-b-lg tw__p-4">
                <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                    @if ($paginate->total() > 0)
                        <span>Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }} result{{ $paginate->total() > 1 ? 's' : '' }}</span>
                    @else
                        <span>No data to be shown</span>
                    @endif
                    <div class="">
                        {{ $paginate->links('vendor.livewire.sneat') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        let loadSkeleton = false;
        const loadDataSkeleton = () => {
            let container = document.getElementById('budget-container');

            if(container){
                let template = `
                    <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4 tw__animate-pulse">
                        <div class=" ">
                            <span class=" tw__bg-gray-300 tw__rounded tw__w-20 tw__h-5 tw__flex"></span>
                            <span class=" tw__flex tw__items-center tw__gap-1 tw__mt-1">
                                <span class=" tw__bg-gray-300 tw__rounded tw__w-5 tw__h-3 tw__flex"></span>
                                <span class=" tw__bg-gray-300 tw__rounded tw__w-24 tw__h-3 tw__flex"></span>
                            </span>
                        </div>
                        <div class=" tw__flex tw__items-start tw__gap-1 tw__flex-col">
                            <span class=" tw__bg-gray-300 tw__rounded tw__w-32 tw__h-5 tw__flex"></span>
                        </div>
                        <div class=" tw__flex tw__gap-2 lg:tw__justify-end">
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-20 tw__h-8"></span>
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-20 tw__h-8"></span>
                        </div>
                    </div>
                `;
                // Check if child element exists
                if(container.querySelectorAll('.list-wrapper').length > 0){
                    container.querySelectorAll('.list-wrapper').forEach((el, index) => {
                        el.innerHTML = template;
                    });
                } else {
                    // Child not yet exists, create new data instead using existing data
                    for(i = 0; i < 5; i++){
                        let el = document.createElement('div');
                        el.classList.add('list-wrapper', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                        el.dataset.index = i;
                        el.innerHTML = template;
                        container.appendChild(el);
                    }
                }
            }
        };

        loadDataSkeleton();
        document.addEventListener('DOMContentLoaded', (e) => {
            window.dispatchEvent(new Event('budgetLoadData'));

            document.getElementById('modal-budget').addEventListener('hidden.bs.offcanvas', (e) => {
                loadDataSkeleton();
                Livewire.emit('refreshComponent');
            });
        });

        window.addEventListener('budgetLoadData', (e) => {
            if(document.getElementById('budget-container')){
                // document.getElementById('budget-container').innerHTML = ``;
                generateList();
            }
        });

        // Generate Shopping List
        const generateList = () => {
            // Get data from Component
            let data = @this.get('dataBudget');
            console.log(data);
            let paneEl = document.getElementById('budget-container');
            let budgetContent = null;

            if(data.length > 0){

            } else {
                document.getElementById('budget-container').innerHTML = ``;
                // Data is empty
                budgetContent = document.createElement('div');
                budgetContent.classList.add('list-wrapper', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                budgetContent.dataset.index = '0';
                budgetContent.innerHTML = `
                    <div class=" tw__grid tw__items-center tw__gap-2 lg:tw__gap-4">
                        No data available
                    </div>
                `;

                paneEl.appendChild(budgetContent);
            }
        };
    </script>
@endsection