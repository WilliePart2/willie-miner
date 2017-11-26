const view_obj = {
    'table': null,
    'streamCount': null,
    'empty_label': null
};
window.addEventListener('load', function(){
    view_obj.table = document.getElementsByClassName('js_stream_table');
    view_obj.streamCount = document.getElementsByClassName('user_stream_count');
    view_obj.empty_label = document.getElementsByClassName('empty_row');
}, false);
window.addEventListener('error_input', error_inputHandler, false);
window.addEventListener('add_stream', addViewHandler, false);

function error_inputHandler(){
    alert('Форма добавления потока заполнена неверно.\nОбязательным для заполнения является поле имени потока.');
}

function addViewHandler(){
    const obj_to_view = {
        'stream_name': null,
        'stream_addr': null,
        'stream_currency': null,
        'stream_number': null
    };
    obj_to_view.stream_name = document.createTextNode(config_stream.stream_name);
    obj_to_view.stream_addr = (config_stream.stream_addr)?document.createTextNode(config_stream.stream_addr): '';
    obj_to_view.stream_currency = document.createTextNode(config_stream.stream_currency);
    Array.prototype.forEach.call(view_obj.streamCount, elt => {
        obj_to_view.stream_number = (parseInt(elt.innerHTML.replace(/[^\d]*(\d{1,10})/i,'$1')) > 0)? parseInt(elt.innerHTML.replace(/[^\d]*(\d{1,10})/i,'$1')) : 0;
    });

    let tr = document.createElement('tr');
    let td_number = document.createElement('td');
    let td_name = document.createElement('td');
    let td_addr = document.createElement('td');
    let td_currency_count = document.createElement('td');
        td_currency_count.innerHTML = 0;
    let td_currency = document.createElement('td');

    td_number.appendChild(document.createTextNode(obj_to_view.stream_number += 1));
    td_name.appendChild(obj_to_view.stream_name);
    if(obj_to_view.stream_addr) {
        td_addr.appendChild(obj_to_view.stream_addr);
    }
    else {
        td_addr.innerHTML = 'none';
    }
    td_currency.appendChild(obj_to_view.stream_currency);

    tr.appendChild(td_number);
    tr.appendChild(td_name);
    tr.appendChild(td_addr);
    tr.appendChild(td_currency_count);
    tr.appendChild(td_currency);

    Array.prototype.forEach.call(view_obj.table, elt => {
        elt.appendChild(tr);
    });

    Array.prototype.forEach.call(view_obj.streamCount, elt => {
        elt.innerHTML = 'Количество потоков: ' + obj_to_view.stream_number;
    });

    Array.prototype.forEach.call(view_obj.empty_label, elt => {
        elt.style.display = 'none';
    });
}