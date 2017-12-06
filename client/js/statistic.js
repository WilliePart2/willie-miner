import React from 'react';
class Statistic extends React.Component{
    constructor(props){
        super(props);
        this.state = {self: 0, stream: 0, stream_count: 0, ref_crypt: 0, ref_count: 0, all: 0};
    }
    getDataAjax(){
        let url = location.protocol + '//' + location.host + this.props.match.url;
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = () => {
            if(xhr.readyState === 4 && xhr.status === 200){
                let data = JSON.parse(xhr.response);
                this.setState({
                    self: data.self_all,
                    stream: data.stream_all,
                    stream_count: data.stream_count,
                    ref_crypt: data.all_crypt_from_ref,
                    ref_count: data.ref_count,
                    all: data.all});
            }
        };
        xhr.send('null');
    }
    componentWillMount(){
        this.getDataAjax();
    }
    render(){
        return(
            <div>
                <div>
                    <h4>Статистика self майнинга</h4>
                    <div>
                        <h5>Общее количество хэшэй из self-майнинга</h5>
                        <div>{this.state.self ? this.state.self : 0}</div>
                    </div>
                </div>
                <div>
                    <h4>Статистика майнинга из потоков</h4>
                    <div>
                        <h5>Общее количество хэшэй из потоков</h5>
                        <div>
                            {this.state.stream ? this.state.stream : 0 }
                        </div>
                    </div>
                    <div>
                        <h5>Общее количество потоков</h5>
                        <div>{this.state.stream_count ? this.state.stream_count : 0}</div>
                    </div>
                </div>
                <div>
                    <h4>Статистика активности рефералов</h4>
                    <div>
                        <h5>Всего рефералов</h5>
                        <div>
                            {this.state.ref_count ? this.state.ref_count : 0}
                        </div>
                    </div>
                    <div>
                        <h5>Всего добыто из рефералов</h5>
                        <div>
                            {this.state.ref_crypt ? this.state.ref_crypt : 0}
                        </div>
                    </div>
                </div>
                <div>
                    <h3>Всего валюты на счету: N</h3>
                    <div>
                        {this.state.all ? this.state.all : 0}
                    </div>
                </div>
            </div>
        );
    }
}
export default Statistic;