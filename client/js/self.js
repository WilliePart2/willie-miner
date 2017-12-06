import React from 'react';
class Self extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            'threads': 1,
            'throttle': 0.9,
            'autoThreads': false,
            'miner': false,
            'mining_speed': 0,
            'mining_total': 0,
            'check_speed': null,
            'check_total': null,
            'micro_save': null,
            'macro_save': null
        };
        this.threadsPlus = this.threadsPlus.bind(this);
        this.threadsMinus = this.threadsMinus.bind(this);
        this.throttlePlus = this.throttlePlus.bind(this);
        this.throttleMinus = this.throttleMinus.bind(this);
        this.autoThreads = this.autoThreads.bind(this);
        this.getMiningTotal = this.getMiningTotal.bind(this);
        this.getMiningSpeed = this.getMiningSpeed.bind(this);
        this.startMining = this.startMining.bind(this);
        this.stopMining = this.stopMining.bind(this);
        this.saveHandler = this.saveHandler.bind(this);
    }
    threadsPlus(){
        this.setState(prevState => {
            return {threads: prevState.threads +=1 };
        });
        if(this.state.miner) {
            let miner = this.state.miner;
            miner.setNumThreads(this.state.threads);
            this.setState({miner: miner});
            console.log(this.state.miner.getNumThreads());
        }
    }
    threadsMinus(){
        if(this.state.threads === 1) return;
        this.setState(prevState => {
            return {threads: prevState.threads -=1 };
        });
        if(this.state.miner) {
            let  miner = this.state.miner;
            miner.setNumThreads(this.state.threads);
            this.setState({miner: miner});
            console.log(this.state.miner.getNumThreads());
        }
    }
    throttleMinus(){
        if(this.state.throttle >= 0 && this.state.throttle < 0.1) return;
        this.setState(prevState => {
            return {throttle: (prevState.throttle -= 0.1)};
        });
        if(this.state.miner) {
            let miner = this.state.miner;
            miner.setThrottle(this.state.threads);
            this.setState({miner: miner});
            console.log(this.state.miner.getThrottle());
        }
    }
    throttlePlus(){
        if(this.state.throttle >= 0.9 && this.state.throttle <= 1) return;
        this.setState(prevState => {
            return {throttle: (prevState.throttle += 0.1)};
        });
        if(this.state.miner) {
            let miner = this.state.miner;
            miner.setThrottle(this.state.threads);
            this.setState({miner: miner});
            console.log(this.state.miner.getThrottle());
        }
    }
    autoThreads(){
        this.setState(prevState => {
            return {autoThreads: prevState.autoThreads?false:true};
        });
        if(this.state.miner) {
            let miner = this.state.miner;
            miner.setAutoThreadsEnabled(this.state.autoThreads);
            this.setState({miner: miner});
        }
    }

    getMiningSpeed(){
        this.setState({mining_speed: this.state.miner.getHashesPerSecond()});
    }
    getMiningTotal(){
        this.setState({mining_total: this.state.miner.getTotalHashes()});
    }
    startMining(){
        let miner = new CoinHive.User('wvolo3wcsofZ0QWawBkpuIxyh5kiYzEk',this.props.user,{
            threads: this.state.threads,
            throttle: this.state.throttle,
            autoThreads: this.state.autoThreads
        });
        miner.start();
        this.setState({miner: miner});
        this.setState({check_speed: setInterval(this.getMiningSpeed, 1000)});
        this.setState({check_total: setInterval(this.getMiningTotal, 1000)});
        this.setState({micro_save: setInterval(() => {
            if(window.localStorage) {
                localStorage.setItem('miner_total_hashes', this.state.miner.getTotalHashes());
            }
        }, 1000)});
        this.setState({macro_save: setInterval(this.saveHandler, 20000)});
    }
    stopMining(){
        this.state.miner.stop();
        clearInterval(this.state.check_speed);
        clearInterval(this.state.check_total);
        clearInterval(this.state.micro_save);
        clearInterval(this.state.macro_save);
        this.setState({mining_speed: 0});
    }
    componentWillUnmount(){
        this.stopMining();
    }
    saveHandler(){
        let url = location.protocol + '//' + location.host + '/save/';
        let data;
        if(window.localStorage) {
            data = (localStorage.getItem('miner_total_hashes')) ? localStorage.getItem('miner_total_hashes') : 0;
        }
        else {
            data = this.state.miner.getTotalHashes();
        }
        if(!data){
            // location.assign(location.protocol + '//' + location.host);
            return;
        }
        localStorage.setItem('miner_total_hashes', 0);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('X-Requested-WIth', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('data=' + encodeURI(data));
    }
    render(){
        return(
            <div className="wrapper_self">
                <div className="self_header">
                    <p>Шапка селф кабинета</p>
                    <div>
                        <div>
                            <h4>Смайнено за сесию:</h4>
                            <span className="js_miner_total">{`${this.state.mining_total} H`}</span>
                        </div>
                        <div>
                            <h4>Скорость майнинга:</h4>
                            <span className="js_miner_speed">{`${Math.round(this.state.mining_speed)} H/s`}</span>
                        </div>
                    </div>
                    <div>
                        <h4>Интерфейс настройки бройзерного майнера</h4>
                        <div>
                            <h5>Количество потоков</h5>
                            <button className="js_threads_plus" onClick={this.threadsPlus}>+</button>
                            <div className="js_threads_monitor">{this.state.threads}</div>
                            <button className="js_threads_minus" onClick={this.threadsMinus}>-</button>
                        </div>
                        <div>
                            <h5>Мощность майнера</h5>
                            <button className="js_throttle_minus" onClick={this.throttleMinus}>+</button>
                            <div className="js_throttle_monitor">{`${Math.round(100-(this.state.throttle*100))}%`}</div>
                            <button className="js_throttle_plus" onClick={this.throttlePlus}>-</button>
                        </div>
                        <div>
                            <label>
                                Автоматическая подстроцка скорости майнинга:
                                <input type="radio" className="js_autoThreads" name="auto_threads" checked={this.state.autoThreads} onClick={this.autoThreads} />
                            </label>
                        </div>
                        <div>
                            <button className="js_start_mining" onClick={this.startMining}>Start_mining</button>
                            <button className="js_stop_mining" onClick={this.stopMining}>Stop mining</button>
                        </div>
                    </div>
                </div>
                <div className="self_monitor">
                    <p>График майнига</p>
                    <canvas></canvas>
                </div>
            </div>
        );
    }
}
export default Self;