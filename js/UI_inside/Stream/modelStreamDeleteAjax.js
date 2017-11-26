window.addEventListener('delete_stream', deleteStreamFromServer, false);

function deleteStreamFromServer(){
    let xhr = new XMLHttpRequest();
    let host = location.host;
    let protocol = location.protocol;
    xhr.open('POST', protocol + '//' + host + '/user_' + glob_obj.user +'/deleteStream/');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('data=' + encodeURI(JSON.stringify(delete_stream_obj)));
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            let response = Boolean(xhr.response);
            if(response === true)
                alert('Успешное удаление потока');
            else alert('Удаление потока неудалось');
        }
    }
}