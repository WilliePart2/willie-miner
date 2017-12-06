import React from 'react';
import { Link, Route } from 'react-router-dom';
import Self from './self';
import Stream from './stream';
import Statistic from './statistic';
import Payment from './payment';

class WorkspaceBase extends React.Component{
    constructor(props){
        super(props);
        this.state = {data: '', loader: true};

        this.loadDataAjax = this.loadDataAjax.bind(this);
        this.logoutHandler = this.logoutHandler.bind(this);
    }
    loadDataAjax(url){
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = () => {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if(parseInt(xhr.response) == false){
                    location.assign(location.protocol + '//' + location.host);
                }
                else {
                    let data = JSON.parse(xhr.response);
                    this.setState({data: data, loader: false});
                }
            }
        };
        xhr.send(null);
    }
    logoutHandler(){
        if(this.state.miner) this.stopMining();
        let url = location.protocol + '//' + location.host + '/ajax_logout/';
        let data;
        if(window.localStorage) {
            data = (localStorage.getItem('miner_total_hashes')) ? localStorage.getItem('miner_total_hashes') : 0;
        }
        else {
            data = this.state.miner.getTotalHashes();
        }
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
        function justOut(){
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
    }
    componentWillMount(){
        let url = location.protocol + '//' + location.host + this.props.match.url;
        this.loadDataAjax(url);
    }
    render(){
        const data = this.state.data;
        return(
            <div className="workspace_wrapper" >
                <div className={this.state.loader ? 'loader' : 'hide'}>
                    Идет загрузка данных...
                </div>
                <div className="header">
                    <h4>Тут шапка рабочего кабинта</h4>
                    <h4 id="username">{data.user? data.user: null}</h4>
                    <p>{data.crypt_count? data.crypt_count : null}</p>
                    <button className="logout" onClick={this.logoutHandler}>Выход</button>
                </div>
                <div className="sidebar">
                    <ul>
                        <li><Link to={this.props.match.url + '/self'}>Self-mining</Link></li>
                        <li><Link to={this.props.match.url + '/streams'}>Stream</Link></li>
                        <li><Link to={this.props.match.url + '/statistic'}>Statistic</Link></li>
                        <li><Link to={this.props.match.url + '/payment'}>Payment</Link></li>
                    </ul>
                </div>
                <div className="content">
                    <h4>Контент страницы</h4>
                    <Route path={this.props.match.url + '/self'} render={() => <Self user={data.user} />} />
                    <Route path={this.props.match.url + '/streams'} component={Stream} />
                    <Route path={this.props.match.url + '/statistic'} component={Statistic} />
                    <Route path={this.props.match.url + '/payment'} component={Payment} />
                </div>
            </div>
        )
    }
}
export default WorkspaceBase;