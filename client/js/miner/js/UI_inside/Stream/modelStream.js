// Реагируем на событие кнопки
// Анализаруем заполнение формы, если что выдаем ошибку.
// Обязательно имя и тип валюты
/**
 * Объекты событий
 */
const error_input_event = new CustomEvent('error_input', {
    'bubbles': true
});
const add_stream = new CustomEvent ('add_stream', {
    'bubbles': true
});
const delete_stream = new CustomEvent('delete_stream', {
    'bubbles': true
});

const UIconfig_elt = {
    'submit_btn': null,
    'stream_name_field': null,
    'stream_addr_field': null,
    'stream_currency_type': null,
    'delete_stream_btn': null
};
window.addEventListener('stream_table_load', () => {
    UIconfig_elt.submit_btn = document.getElementsByClassName('js_add_stream');
    UIconfig_elt.stream_name_field = document.getElementsByClassName('js_stream_name_field');
    UIconfig_elt.stream_addr_field = document.getElementsByClassName('js_stream_addr_field');
    UIconfig_elt.stream_currency_type = document.getElementsByClassName('js_stream_currency_type');
    UIconfig_elt.delete_stream_btn = document.getElementsByClassName('delete_stream_btn');

    Array.prototype.forEach.call(UIconfig_elt.submit_btn, elt => {
        elt.addEventListener('click', addModelHandler, false);
    });

    Array.prototype.forEach.call(UIconfig_elt.delete_stream_btn, elt => {
        elt.addEventListener('click', deleteStreamHandler, false);
    });


}, false);

function deleteStreamHandler(event){
    if(!event) event = window.event;
    if(event.preventDefault)
        event.preventDefault();
    else
        event.returnValue = false;
    let target = event.target || event.srcElement;
    let wrapper = target.parentNode.parentNode;
    wrapper.style.display = 'none';
    let count = 0;
    for(let elt = wrapper.firstChild; elt.nextSibling !== null; elt = elt.nextSibling){
        switch(elt.className){
            case 'stream_name': delete_stream_obj.stream_name = elt.innerHTML; break;
            case 'stream_addr': delete_stream_obj.stream_addr = elt.innerHTML; break;
            case 'currency_type': delete_stream_obj.stream_currency_type = elt.innerHTML; break;
            case 'currency_count': delete_stream_obj.currency_count = elt.innerHTML; break;
        }
    }
    target.dispatchEvent(delete_stream);

    // Еще нужно поменять порядок следования номеров и количество потоков(общее)
    for(let wrap = wrapper.nextSibling; wrap.nextSibling !== null; wrap = wrap.nextSibling){
        if(wrap.className === 'body_row'){
            [].forEach.call(wrap.children, child_elt => {
                if(child_elt.className === 'stream_count'){
                    let num = parseInt(child_elt.innerHTML); num -= 1;
                    child_elt.innerHTML = num;
                }
            });
        }
    }
}

function addModelHandler(event) {
    console.log('Добавление стрима');
    if (!event) event = window.event;
    let target = event.target || event.srcElement;
    for(let i = 0; i < UIconfig_elt.stream_name_field.length; i++) {
        let elt = UIconfig_elt.stream_name_field[i];
        if (!elt.value) {
            target.dispatchEvent(error_input_event);
            return;
        }
    }
    [].forEach.call(UIconfig_elt.stream_name_field, elt => {
        config_stream.stream_name = (elt.value)? elt.value: 'none';
        elt.value = '';
    });
    [].forEach.call(UIconfig_elt.stream_addr_field, elt => {
        config_stream.stream_addr = (elt.value)? elt.value : 'none';
        elt.value = '';
    });
    [].forEach.call(UIconfig_elt.stream_currency_type, elt => {
        config_stream.stream_currency = (elt.value)? elt.value : 'none';
    });

    document.dispatchEvent(add_stream);
}
