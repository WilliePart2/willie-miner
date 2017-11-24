/*Выгрузка на сревер при закрытии вкладки и нажатии кнопки выхода*/
// window.addEventListener('beforeunload', saveHandler, false);
window.addEventListener('load', function() {
    const logout_btn = document.getElementsByClassName('js_logout');
    Array.prototype.forEach.call(logout_btn, elt => {
        elt.addEventListener('click', logoutHandler, false);
    });
});
/*Регулярные сохранения в localStorage каждые 1 секунду*/
window.addEventListener('miner_started', function(){
    setInterval(function(){
        let total_hashes = miner.getTotalHashes();
        localStorage.setItem('miner_total_hashes', total_hashes);
    }, 1000);
}, false);
/*Регулятные сохранения на сервер каждые 10 секунд*/
window.addEventListener('miner_started', function(){
    setInterval(saveHandler, 10000);
}, false);

function saveHandler(){
    let data = (localStorage.getItem('miner_total_hashes'))? localStorage.getItem('miner_total_hashes'): 0;
    if(!data){
        location.assign(location.origin);
        return;
    }
    localStorage.setItem('miner_total_hashes', 0);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'save/');
    xhr.setRequestHeader('X-Requested-WIth', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(`data=${encodeURI(data)}`);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
        }
    }
}

function logoutHandler(event){
    if(miner) miner.stop();

    if(!event) event = window.event;
    if(event.preventDefault){
        event.preventDefault();
    }
    else {
        event.returnValue = false;
    }

    let result = saveToServerEndOut();
    if(result === false){
        let asc = confirm('Не удалось подключится к серверу!\n' +
            'Некоторые данне погут быть утеряны.\n' +
            'Если вы понинете страницу сейчас некоторые данные могут быть утеряны.\n' +
            'Вы действительно хотите покинуть станицу?');
        if(!asc) logoutHandler();
    }
}
function saveToServerEndOut(){
    let data = (localStorage.getItem('miner_total_hashes'))? localStorage.getItem('miner_total_hashes'): 0;
    if(!data) {
        location.assign(location.origin);
        return;
    }
    localStorage.setItem('miner_total_hashes', 0);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax_logout/');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send('data=' + encodeURI(data));
    xhr.onreadystatechange = function(){
        if(xhr.readyState !== 4) return;
        if(xhr.status !== 200) {
            alert(`Ошибка соединения с сервером!\n
            Код ошибки: ${xhr.status}.\n
            Текст ошибки: ${xhr.statusText}.`);
        }
        if(xhr.readyState === 4 && xhr.status === 200){
            location.assign(decodeURI(xhr.response));
        }
    };
    return true;
}
