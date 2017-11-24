const monitorsUI = {
    'threads_monitor': null,
    'throttle_monitor': null,
    'miner_speed': null,
    'miner_total': null
};

window.addEventListener('load', function(){
    monitorsUI.threads_monitor = document.getElementsByClassName('js_threads_monitor');
    monitorsUI.throttle_monitor = document.getElementsByClassName('js_throttle_monitor');
    monitorsUI.miner_speed = document.getElementsByClassName('js_miner_speed');
    monitorsUI.miner_total = document.getElementsByClassName('js_miner_total');

    window.addEventListener('miner_started', function(){
        setInterval(function(){
            Array.prototype.forEach.call(monitorsUI.miner_speed, elt => {
                let speed = parseInt(miner.getHashesPerSecond());
                elt.innerHTML = `${speed} H/s`;
            });
        }, 1000);
        setInterval(function(){
            Array.prototype.forEach.call(monitorsUI.miner_total, elt => {
                let tot = miner.getTotalHashes();
                elt.innerHTML = tot;
            })
        }, 1000);
    }, false);

    window.addEventListener('power_up', function(){
        Array.prototype.forEach.call(monitorsUI.throttle_monitor, elt => {
            let percent = parseInt(elt.innerHTML);
            if(percent >= 100) return;
            percent += 10;
            elt.innerHTML = `${percent}%`;
        });
    }, false);
    window.addEventListener('power_down', function(){
        Array.prototype.forEach.call(monitorsUI.throttle_monitor, elt => {
            let persent = parseInt(elt.innerHTML);
            persent -= 10;
            elt.innerHTML = `${persent}%`;
        });
    }, false);

    window.addEventListener('threads_plus', function(){
       Array.prototype.forEach.call(monitorsUI.threads_monitor, elt => {
           let num = parseInt(elt.innerHTML);
           num++;
           elt.innerHTML = num;
       })
    }, false);
    window.addEventListener('threads_minus', function(){
        Array.prototype.forEach.call(monitorsUI.threads_monitor, elt => {
            let num = parseInt(elt.innerHTML);
            num--;
            elt.innerHTML = num;
        })
    }, false);

}, false);
