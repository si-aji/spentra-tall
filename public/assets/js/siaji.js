"use strict";

/**
 * Print Indonesia default amount format
 * 
 * @param {*} angka 
 * @param {*} prefix 
 * @returns 
 */
 function formatRupiah(angka, prefix = 'Rp'){
    let negative = angka < 0 ? true : false;

    let balanceHide_state = false;
    if(balanceHide_state !== null && balanceHide_state === 'true'){
        var rupiah = '---';
        return prefix == undefined ? rupiah : prefix+" "+rupiah;
    }

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
    
    return `${(prefix == undefined ? `${negative ? '-' : ''}${rupiah}` : `${prefix} ${negative ? '-' : ''}${rupiah}`)}`;
}