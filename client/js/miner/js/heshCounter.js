function totalHashes(){
    // let hashRate = miner;
    let event = new CustomEvent('totalHashes', {
        'bubbles': true,
        'cancelable': true,
        'detail': hashRate
    });
    document.dispatchEvent(event);
    console.log('Отправил heshrate');
}
var onCoinHiveSimpleUIReady = function(){
    setInterval(totalHashes, 1000);
};