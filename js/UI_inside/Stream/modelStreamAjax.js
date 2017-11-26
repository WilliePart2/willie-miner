const data_to_server = {
    'json': null,
    'user': null
};
window.addEventListener('load', function(){
    data_to_server.user = document.getElementsByClassName('sidebar_user_name');
}, false);
window.addEventListener('add_stream_to_server', sendToServerHandler, false);
// ФОрмируем JSON для отправки на сервер
function sendToServerHandler(){
    data_to_server.json = JSON.stringify(config_stream);
    // Отправляем на сервер.
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'addStream/');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/json'); // Тут могут быть траблы
    xhr.send(data_to_server.json);
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.response);
        }
    };
    // Отправляем в представление.
    // document.dispatchEvent(add_stream);
}

// Отправляем JSON на сервер