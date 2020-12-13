$(document).ready(function(){
    console.log('rrrr');
    $('input.phone').mask('(000) 000 00 00');
    $('input.money').mask('000,000,000.00', {reverse: true});
    $('input.ccnumber').mask('0000 0000 0000 0000');
    $('input.expiration_date').mask('00/00');
});
