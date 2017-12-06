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
            console.log(xhr.response);
            // location.assign(location.protocol + '//' + location.host);
        }
    };
    return true;
}

function justOut(){
    console.log('Просто выходим');
    let protocol = location.protocol;
    let host = location.host;
    let xhr = new XMLHttpRequest();
    xhr.open('GET',protocol + '//' + host + '/user_' + USER + '/ajax_justOut/?out=true');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send();
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            // Если так не сделать интерпретатор перенапраляет страничку рашьше чем оприходит ответ.
            console.log(xhr.response);
            // location.assign(location.origin);
            return true;
        }
    }
}

export default logoutHandler;