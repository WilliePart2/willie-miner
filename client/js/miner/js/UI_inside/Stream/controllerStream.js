const add_stream_to_server = new CustomEvent('add_stream_to_server', {
    'bubbles': true
});
const glob_obj = {
    'user': null
};
const config_stream = {
    'stream_name': null,
    'stream_addr': null,
    'stream_currency': null
};
const delete_stream_obj = {
    'stream_name': null,
    'stream_addr':null,
    'stream_currency_type': null,
    'currency_count': null
};

window.addEventListener('add_stream', function(){
    document.dispatchEvent(add_stream_to_server);
}, false);

window.addEventListener('stream_table_load', function(){
    glob_obj.user = document.getElementById('username')[0].innerHTML.trim(); // Я так не делаю,!... только разик
}, false);