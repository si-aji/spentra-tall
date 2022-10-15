"use strict";

/**
 * 
 * @param {*} val 
 * @param {*} index 
 * @returns 
 */
function recordContainerFormat(val, index){
    return `
        <div class=" tw__p-4 tw__text-center">
            <!-- This is for date -->
            <div class="tw__sticky tw__top-24 md:tw__top-40">
                <span class="tw__font-semibold">${momentDateTime(val.datetime, 'ddd')}</span>
                <div class=" tw__min-h-[40px] tw__min-w-[40px] tw__bg-[#7166ef] tw__bg-opacity-60 tw__rounded-full tw__flex tw__leading-none tw__items-center tw__justify-center tw__align-middle">
                    <p class="tw__mb-0 tw__font-bold tw__text-xl tw__text-white">${momentDateTime(val.datetime, 'DD')}</p>
                </div>
                <small>${momentDateTime(val.datetime, 'MMM')} '${momentDateTime(val.datetime, 'YY')}</small>
            </div>
        </div>
        <div class=" tw__bg-gray-50 tw__rounded-lg tw__w-full content-list tw__p-4" data-date="${momentDateTime(val.datetime, 'YYYY-MM-DD')}">
            <!-- List Goes Here -->
        </div>
    `;
}
function recordContentFormat(val, index, action = []){
    // console.log(val);
    // console.log(val.datetime);
    // console.log(momentDateTime(val.datetime, 'HH:mm'));

    // Wallet
    let walletName = `${val.wallet.parent ? `${val.wallet.parent.name} - ` : ''}${val.wallet.name}`;
    let toWalletName = val.to_wallet_id ? `${val.wallet_transfer_target.parent ? `${val.wallet_transfer_target.parent.name} - ` : ''}${val.wallet_transfer_target.name}` : null;
    // Extra Information
    let smallInformation = [];
    if(val.category){
        smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bxs-category tw__mr-1"></i>${val.category.parent_id ? `${val.category.parent.name} - ` : ''}${val.category.name}</small></span>`);
    }
    if(val.receipt !== null){
        smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bx-paperclip bx-rotate-90 tw__mr-1"></i>Receipt</small></span>`);
    }
    if(val.note !== null){
        smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bx-paragraph tw__mr-1"></i>Note</small></span>`);
    }
    if(val.tags !== null && val.tags !== undefined && val.tags.length > 0){
        smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bxs-tag-alt tw__mr-1"></i>Tags</small></span>`);
    }
    // Handle Action
    let actionBtn = '';
    if(action.length > 0){
        actionBtn = `
            <div class="dropdown tw__leading-none tw__flex">
                <button class="dropdown-toggle arrow-none" type="button" data-bs-auto-close="outside" id="record_dropdown-${index}" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="record_dropdown-${index}">
                    ${action.join('')}
                </ul>
            </div>
        `;
    }

    return `
        <div class="tw__flex tw__items-center tw__leading-none tw__gap-1">
            <small class="tw__flex tw__flex-col md:tw__flex-row md:tw__items-center tw__gap-1">
                <span class="tw__text-gray-500 tw__flex tw__items-center tw__gap-2"><i class="bx bx-time"></i>${momentDateTime(val.datetime, 'HH:mm')}</span>
                <span class="tw__hidden md:tw__block"><i class="bi bi-dot"></i></span>
                <span class="tw__flex tw__items-center tw__leading-none tw__gap-1 tw__flex-wrap tw__text-[#293240]"><span class=""><i class="bx bx-wallet-alt"></i></span>${walletName} ${toWalletName !== null ? `<small><i class="bx bx-caret-${val.type === 'income' ? 'left' : 'right'} "></i></small>${toWalletName}` : ''}</span>
            </small>

            <div class="tw__ml-auto tw__flex itw__items-center tw__gap-2">
                <span class="${val.type === 'income' ? 'tw__text-green-600' : 'tw__text-red-600'} tw__text-base tw__hidden md:tw__block">${val.type === 'expense' ? `(${formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))})` : formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))}</span>
            
                ${actionBtn}
            </div>
        </div>

        <div class="tw__my-2 tw__mt-4 lg:tw__mt-2 tw__flex tw__items-center tw__gap-4">
            <div class="tw__min-h-[35px] tw__min-w-[35px] tw__rounded-full tw__text-white ${val.to_wallet_id ? 'tw__bg-gray-400' : (val.type === 'expense' ? 'tw__bg-red-400' : 'tw__bg-green-400')} tw__bg-opacity-75 tw__flex tw__items-center tw__justify-center">
                <i class="bx bxs-${val.to_wallet_id ? 'arrow-to-bottom' : (val.type === 'expense' ? 'arrow-from-bottom' : 'arrow-from-bottom')}"></i>
            </div>
            <div class="tw__flex tw__items-center tw__gap-4 tw__w-full">
                <div class="tw__mr-auto">
                    <p class="tw__text-base tw__text-semibold tw__mb-0 tw__text-[#293240]">${val.to_wallet_id ? 'Transfer - ' : ''}${ucwords(val.type)}</p>
                    <small class="tw__italic tw__text-gray-500 tw__hidden lg:tw__inline">
                        <i class='bx bx-align-left'></i>
                        <span>${val.note ? val.note : 'No description'}</span>
                    </small>
                </div>
            </div>
        </div>
        <div class=" lg:tw__hidden">
            <small class="tw__italic tw__text-gray-500">
                <i class='bx bx-align-left'></i>
                <span>${val.note ? val.note : 'No description'}</span>
            </small>
        </div>

        <div class="md:tw__hidden tw__mt-4">
            <span class="${val.type === 'income' ? 'tw__text-green-600' : 'tw__text-red-600'} tw__text-base">${val.type === 'expense' ? `(${formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))})` : formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))}</span>
        </div>
        ${smallInformation.length > 0 ? `<div class=" tw__leading-none tw__flex tw__items-center tw__gap-2 tw__flex-wrap tw__mt-2 lg:tw__mt-0">${smallInformation.join('<i class="bi bi-slash"></i>')}</div>` : ''}
    `;
}