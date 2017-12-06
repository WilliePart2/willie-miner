/*Выгрузка на сревер при закрытии вкладки и нажатии кнопки выхода*/
// window.addEventListener('beforeunload', saveHandler, false);
if(location.pathname.length > 1) {
    window.addEventListener('load', function () {
        const logout_btn = document.getElementsByClassName('js_logout');
        Array.prototype.forEach.call(logout_btn, elt => {
            elt.addEventListener('click', logoutHandler, false);
        });
    });
}
/*Регулярные сохранения в localStorage каждые 1 секунду*/
window.addEventListener('miner_started', function(){
    setInterval(function(){
        if(window.localStorage) {
            let total_hashes = miner.getTotalHashes();
            localStorage.setItem('miner_total_hashes', total_hashes);
        }
    }, 1000);
}, false);
/*Регулятные сохранения на сервер каждые 10 секунд*/
window.addEventListener('miner_started', function(){
    setInterval(saveHandler, 10000);
}, false);

function saveHandler(){
    let url = location.protocol + '//' + location.host + '/save/';
    let data;
    if(window.localStorage) {
        data = (localStorage.getItem('miner_total_hashes')) ? localStorage.getItem('miner_total_hashes') : 0;
    }
    else {
        data = this.state.miner.getTotalHashes();
    }
    if(!data){
        location.assign(location.protocol + '//' + location.host);
        return;
    }
    localStorage.setItem('miner_total_hashes', 0);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('X-Requested-WIth', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('data=' + encodeURI(data));
}

function logoutHandler(event){
    if(miner) miner.stop();
    if(!event) event = window.event;
    (event.preventDefault)? event.preventDefault(): event.returnValue = false;
    saveToServerEndOut();
}
function saveToServerEndOut(){
    let url = location.protocol + '//' + location.host + '/ajax_logout/';
    let data = (localStorage.getItem('miner_total_hashes'))? localStorage.getItem('miner_total_hashes'): 0;
    if(data == false) {
        // Нужно сформировать запрос без отправки данных, просто на выход и закрытие сесии.
        justOut();
        return true;
    }
    localStorage.setItem('miner_total_hashes', 0);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send('data=' + encodeURI(data));
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            location.assign(location.protocol + '//' + location.host);
        }
    };
    return true;
}
function justOut(){
    console.log('Просто выходим');
    let protocol = location.protocol;
    let host = location.host;
    let xhr = new XMLHttpRequest();
    xhr.open('GET',protocol + '//' + host + '/ajax_justOut/');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(null);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            location.assign(location.protocol + '//' + location.host);
            return true;
        }
    }
}
