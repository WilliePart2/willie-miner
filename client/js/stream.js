import React from 'react';

function getKey(str){
    let out = '';
    for(let i = 0; i < str.length; i++){
        out += str.charCodeAt(i);
    }
    return out;
}
function NewRow(props){
    return(
        <tr className="body_row">
            <td className="index">{props.count}</td>
            <td className="stream_name">{props.name}</td>
            <td className="stream_addr">{props.addr}</td>
            <td>0</td>
            <td className="stream_type">{props.crypt_type}</td>
            <td><a href="#" className="delete_stream_btn" onClick={props.clickHandler}>Удалить</a></td>
        </tr>
    );
}

class Stream extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            rows: '',
            name: '',
            addr: '',
            crypt: 'Monero',
            count: 1
        };

        this.nameHandler = this.nameHandler.bind(this);
        this.addrHandler = this.addrHandler.bind(this);
        this.cryptHandler = this.cryptHandler.bind(this);
        this.onAddHandler = this.onAddHandler.bind(this);
        this.deleteStreamAjax = this.deleteStreamAjax.bind(this);
    }
    componentWillMount(){
        // Ajax запрос на полуение данных из таблицы
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = () => {
            // Тут обработаем данные и вызовем setState для перерисовки таблицы
            if(xhr.readyState === 4 && xhr.status === 200){
                let streams = JSON.parse(xhr.response);
                streams.shift();
                let counter = 1;
                let rows = streams.map(elt => {
                    return(
                        <tr key={getKey(elt.stream_name)} className="body_row" >
                            <td className="index">{this.state.count++}</td>
                            <td className="stream_name">{elt.stream_name}</td>
                            <td className="stream_addr">{elt.stream_addr}</td>
                            <td>{elt.currency_count}</td>
                            <td className="stream_type">{elt.stream_currency}</td>
                            <td><a href="#" className="delete_stream_btn" onClick={this.deleteStreamAjax}>Удалить</a></td>
                        </tr>
                    );
                });
                this.setState({rows: rows});
            }
        };
        xhr.open('GET', location.protocol + '//' + location.host + this.props.match.url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(null);

        let evt_load = new CustomEvent('stream_table_load', {
            'bubbles': true
        });
        document.dispatchEvent(evt_load);
    }
    nameHandler(evt){
        this.setState({name: evt.target.value});
    }
    addrHandler(evt){
        this.setState({addr: evt.target.value});
    }
    cryptHandler(evt){
        this.setState({crypt: evt.target.value});
    }
    addStreamAjax(){
        let data = {
            name: this.state.name,
            addr: this.state.addr,
            crypt_type: this.state.crypt
        };
        let url = location.protocol + '//' + location.host + '/addStream/';
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                location.href = location.protocol + '//' + location.host + '/getFile/';
            }
        };
        xhr.send(JSON.stringify(data));
    }
    deleteStreamAjax(evt){
        let data = {
            name: '',
            addr: 'none',
            crypt_type: ''
        };
        let index = 0;
        let wrapper = evt.target.parentNode.parentNode;
        for(let elmt = wrapper.firstChild; elmt !== null; elmt = elmt.nextSibling){
            switch(elmt.className){
                case 'stream_name': data.name = elmt.innerHTML; break;
                case 'stream_addr': data.addr = elmt.innerHTML; break;
                case 'stream_type': data.crypt_type = elmt.innerHTML; break;
                case 'index': index = parseInt(elmt.innerHTML); break;
            }
        }

        let url = location.protocol + '//' + location.host + '/deleteStream/';
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                console.log(xhr.response);
            }
        };
        xhr.send(JSON.stringify(data));

        let rows = this.state.rows;
        rows.splice(index-1, 1);
        this.setState(prevState => {
            return {rows: [...rows], count: prevState.count-1};
        });

        for(let elt = wrapper.nextElementSibling; elt !== null; elt = elt.nextElementSibling) {
            for (let e = elt.firstChild; e.nextSibling !== null; e = e.nextSibling) {
                if (e.className == 'index') {
                    let num = parseInt(e.innerHTML);
                    num -= 1;
                    e.innerHTML = num;
                }
            }
            console.log('iteration');
        }
    }
    onAddHandler(){
        this.addStreamAjax();
        this.setState(prevState => {
            let data = prevState.rows;
            return {rows: [...data, <NewRow key={getKey(this.state.name)}
                                            name={this.state.name}
                                            addr={this.state.addr ? this.state.addr : 'none'}
                                            crypt_type={this.state.crypt}
                                            count={this.state.count++}
                                            clickHandler={this.deleteStreamAjax} />]};
        });
    }
    render(){

        return(
            <div>
                <h2>Имеющиеся площадки для майнинга</h2>
                <table className="js_stream_table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Название потока</th>
                            <th>Адрес потока</th>
                            <th>Количество хэшэй из потока</th>
                            <th>Тип валюты потока</th>
                            <th>Изменить</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.state.rows ? this.state.rows : null}
                    </tbody>
                </table>
                <h4>Добавить площадку для майнинга</h4>
                <form>
                    <input type="text" name="name" className="js_stream_name_field" onChange={this.nameHandler} />
                    <input type="text" name="addr" className="js_stream_addr_field" onChange={this.addrHandler} />
                    <select className="js_stream_currency_type" value={this.state.crypt} onChange={this.cryptHandler}>
                        <option value="Monero">Monero</option>
                    </select>
                    <input type="button" value="Добавить" className="js_add_stream" onClick={this.onAddHandler} />
                </form>
            </div>
        );
    }
}
export default Stream;