"use strict";

/**
 * Check if Object is empty
 * 
 * @param {*} obj 
 * @returns 
 */
const isEmptyObject = (obj) => {
    return Object.keys(obj).length === 0 && obj.constructor === Object;
};

/**
 * Print Indonesia default amount format
 * 
 * @param {*} angka 
 * @param {*} prefix 
 * @returns 
 */
function formatRupiah(angka, prefix = 'Rp'){
    let negative = angka < 0 ? true : false;

    // let balanceHide_state = false;
    // if(balanceHide_state !== null && balanceHide_state === 'true'){
    //     var rupiah = '---';
    //     return prefix == undefined ? rupiah : prefix+" "+rupiah;
    // }

    angka = Math.round(angka * 100) / 100;
    let split = angka.toString().split('.');
    let decimal = 0;
    if(split.length > 1){
        angka = split[0];
        decimal = split[1];
    }
    var	reverse = angka.toString().split('').reverse().join(''),
	rupiah 	= reverse.match(/\d{1,3}/g);
    rupiah	= rupiah.join('.').split('').reverse().join('');

    if(split.length > 1){
        rupiah += `,${decimal}`;
    }
    
    return `${(prefix == undefined ? `${negative ? '(-' : ''}${rupiah}${negative ? ')' : ''}` : `${prefix} ${negative ? '(-' : ''}${rupiah}${negative ? ')' : ''}`)}`;
}

/**
 * Make All First Character Uppercase
 * 
 * @param {string} str 
 * @returns 
 */
function ucwords(str){
    str = str.toLowerCase().replace(/\b[a-z]/g, (letter) => {
        return letter.toUpperCase();
    });

    return str;
}

/**
 * Convert Timezone
 * Convert specific date (default is UTC+7) to match user timezone
 * 
 * @param {*} date 
 * @param {*} timezone 
 * @returns 
 */
 function convertDateTime(date, timezone = null){
    if(timezone === null){
        // Get user Timezone if timezone is not specified
        timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    }

    return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: timezone}));
}

/**
 * Convert default new Date() format to MomentJs mormat
 * 
 * @param {*} date 
 * @param {*} format 
 * @param {*} timezone 
 * @returns 
 */
 function momentDateTime(date, format = null, timezone = null, offsetFormat = true){
    let defaultTimezone = new Date(`${date} GMT+0000`);
    if(navigator.userAgent.indexOf("Safari") != -1) {
        // Fix date format on safari browser
        defaultTimezone = new Date(`${moment(date).format('ddd, DD MMM YYYY HH:mm:ss')} GMT+0000`);
    }

    const tzOffset = defaultTimezone.getTimezoneOffset();
    let formatedDate = format;

    // Get Timezone symbol (ex: UTC+7 etc)
    if(timezone !== null){
        let offsetSymbol = tzOffset < 0 ? '+' : '-';
        let offsetNum = tzOffset / 60;
        if(offsetNum < 0){
            offsetNum *= -1;
        }

        if(offsetFormat){
            // Apply symbol to existing string format
            formatedDate += ` (UTC${offsetSymbol}${offsetNum})`;
        }
    }

    if(format === null){
        return moment(convertDateTime(defaultTimezone));
    }

    return moment(convertDateTime(defaultTimezone)).format(formatedDate);
}

function clipboardTooltip(el, action = 'show', message = '')
{
    var triggerEl = el;
    var tooltip = bootstrap.Tooltip.getOrCreateInstance(triggerEl) // Returns a Bootstrap tooltip instance

    if(action === 'show'){
        // Show tooltip
        triggerEl.setAttribute('title', message);
        triggerEl.setAttribute('data-bs-original-title', message);
        tooltip.show();
    } else {
        // Hide tooltip
        tooltip.dispose();
    }
    return true;
}