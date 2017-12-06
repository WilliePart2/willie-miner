var miner;
var miner_config_obj;
const start = new CustomEvent('miner_started', {
    'bubbles': true
});
var USER;
if(location.pathname.length > 1) {
    window.addEventListener('load', function () {
        USER = document.getElementById('username').innerHTML.trim(); // Я так делаю не часто... вродебы
    }, false);
}

window.addEventListener('stop_mining', stopMiningHandler, false);
window.addEventListener('start_mining', function(event){
    if(!miner) {
        firstStartMiningHandler(event);
    }
    else {
        startMinerHandler();
    }

}, false);
window.addEventListener('threads_plus', threads_plusHandler, false);
window.addEventListener('threads_minus', threads_minusHandler, false);
window.addEventListener('power_up', power_upHandler, false);
window.addEventListener('power_down', power_downHandler, false);
window.addEventListener('set_auto_threads', AutoThreadsHandler, false);

function firstStartMiningHandler(event){
    if(!event) event = window.event;
    let target = event.target || event.srcElement;
    miner_config_obj = event.detail;

    miner = new CoinHive.User('wvolo3wcsofZ0QWawBkpuIxyh5kiYzEk', USER, miner_config_obj);
    miner.start();
    target.dispatchEvent(start);
}
function stopMiningHandler(){
    if(miner) {
        miner.stop();
    }
    else{
        return;
    }
}
function startMinerHandler(){
    miner.start();
}
function threads_plusHandler(event){
    if(!event) event = window.event;
    if(miner){
        miner.setNumThreads(miner_config_obj.threads);
    }
}
function threads_minusHandler(){
    if(miner){
        miner.setNumThreads(miner_config_obj.threads);
    }
}
function power_upHandler(event){
    if(!event) event = window.event;
    if(miner){
        miner.setThrottle(event.detail);
    }
}
function power_downHandler(event){
    if(!event) event = window.event;
    if(miner){
        miner.setThrottle(miner_config_obj);
    }
}
function AutoThreadsHandler(event){
    if(!event) event = window.event;
    if(miner){
        miner.setAutoThreadsEnabled(miner_config_obj.autoThreads);
    }
}