/*Объект конфигурации майнера*/
const miner_configuration = {
    'threads': 1,
    'throttle': 0.9,
    'autoThreads': false
};

/*События для представления (viewMiner)*/
const threads_plus = new CustomEvent('threads_plus', {
    'bubbles': true,
    'detail': miner_configuration.threads
});
const threads_minus = new CustomEvent('threads_minus', {
    'bubbles': true,
    'deatail': miner_configuration.threads
});
const power_down = new CustomEvent('power_down', {
    'bubbles': true,
    'detail': miner_configuration.throttle
});
const power_up = new CustomEvent('power_up', {
    'bubbles': true,
    'detail': miner_configuration.throttle
});
const set_auto_threads = new CustomEvent('set_auto_threads', {
    'bubbles': true
});
const start_mining = new CustomEvent('start_mining', {
    'bubbles': true,
    'detail': miner_configuration
});
const stop_mining = new CustomEvent('stop_mining', {
    'bubbles': true
});

function threads_plus_handler(){
    console.log('handler +');
    miner_configuration.threads++;
}
function threads_minus_handler(){
    miner_configuration.threads--;
}
function power_up_handler(){
    miner_configuration.throttle -= 0.1;
}
function power_down_handler(){
    miner_configuration.throttle += 0.1;
}

const configurationUI = {
    'threads_plus_btn': null,
    'threads_minus_btn': null,
    'power_up_btn': null,
    'power_down_btn': null,
    'autoThreads': null,
    'start_btn': null,
    'stop_btn': null
};

/*
window.addEventListener('self_load', function() {
    configurationUI.threads_plus_btn = document.getElementsByClassName('js_threads_plus');
    configurationUI.threads_minus_btn = document.getElementsByClassName('js_threads_minus');
    configurationUI.power_down_btn = document.getElementsByClassName('js_throttle_plus');
    configurationUI.power_up_btn = document.getElementsByClassName('js_throttle_minus');
    configurationUI.autoThreads = document.getElementsByClassName('js_autoThreads');
    configurationUI.start_btn = document.getElementsByClassName('js_start_mining');
    configurationUI.stop_btn = document.getElementsByClassName('js_stop_mining');

    Array.prototype.forEach.call(configurationUI.stop_btn, elt => {
        elt.addEventListener('click', event => {
            if(!event) event = window.event;
            let target = event.target || event.srcElement;
            target.dispatchEvent(stop_mining);
        }, false);
    });

    Array.prototype.forEach.call(configurationUI.start_btn, elt => {
        elt.addEventListener('click', (event) => {
            if(!event) event = window.event;
            let target = event.target || event.srcElement;
            target.dispatchEvent(start_mining);
        }, false);
    });

    Array.prototype.forEach.call(configurationUI.autoThreads, elt => {
        elt.addEventListener('change', function(event){
            if(!event) event = window.event;
            let target = event.target || event.srcElement;
            miner_configuration.autoThreads = true;
            target.dispatchEvent(set_auto_threads);
        }, false);
    });

    Array.prototype.forEach.call(configurationUI.power_up_btn, elt => {
        elt.addEventListener('click', function(event){
            if(miner_configuration.throttle <= 0.1) return;
            if(!event) event = window.event;
            let target = event.target || event.srcElement;
            power_up_handler();
            target.dispatchEvent(power_up);
        }, false);
    });
    Array.prototype.forEach.call(configurationUI.power_down_btn, elt => {
        elt.addEventListener('click', function(event){
            if(miner_configuration.throttle >= 0.9) return;
            if(!event) event = window.event;
            let target = event.target || event.srcElement;
            power_down_handler();
            target.dispatchEvent(power_down);
        }, false);
    });

    Array.prototype.forEach.call( configurationUI.threads_plus_btn, elt => {
        elt.addEventListener('click', function(event){
            if(!event) event = window.event;
            let target = event.target || event.srcElement;
            threads_plus_handler();
            target.dispatchEvent(threads_plus);
        }, false);
    });
    Array.prototype.forEach.call( configurationUI.threads_minus_btn, elt => {
        elt.addEventListener('click', function(event){
            if(miner_configuration.threads <= 1) return;
            if(!event) event = window.event;
            let target = event.target || event.srcElement;
            threads_minus_handler();
            target.dispatchEvent(threads_minus);
        }, false);
    });
});
*/