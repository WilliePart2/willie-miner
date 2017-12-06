import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Link, Switch } from 'react-router-dom';
import WorkspaceBase from '../workspace';

/**
 * В этом блоке собраны служебные функции нужные для функционирования системы
 */
function formLoginData(form){
    let elm = form.elements;
    let data = {};
    [].forEach.call(elm, elt =>{
        switch(elt.name){
            case 'login': data.login = elt.value; break;
            case 'password': data.password = elt.value; break;
        }
    });
    return data;
}
function validateRegistration(form){
    let elt = form.elements;
    let errors = [];
    let data = {
        login: '',
        password: '',
        password_repeat: '',
        email: ''
    };
    [].forEach.call(elt, formElt => {
        switch(formElt.name){
            case 'password': data.password = formElt.value; break;
            case 'login': data.login = formElt.value.trim(); break;
            case 'email': data.email = formElt.value.trim(); break;
            case 'password_repeat': data.password_repeat = formElt.value; break;
        }
    });
    if(data.password.length < 6) {
        alert('Пароль должен быть больше 6 символов');
        return false;
    }
    if(data.password_repeat != data.password) {
        elt.password.classList.add('js_error');
        elt.password_repeat.classList.add('js_error');
        errors.push('+');
    }
    if(errors.length != 0) {
        console.log(data);
        return false;
    }
    return data;
}
/**
 * В этом разделе размещены компоненты
 */
class Base extends React.Component{
    sendAjax(url, data){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
                if(Boolean(xhr.response)){
                    location.href = location.protocol + '//' + location.host + '/workspace';
                }
                else{
                    let answer = xhr.response;
                    let data;
                    switch(typeof answer){
                        case 'string': data = alert(JSON.parse(answer)); break;
                        case 'boolean': alert('Сервер перегружен, попробуйте позже.'); break;
                    }
                }
            }
        };
        xhr.send(JSON.stringify(data));
    }
    render(){
        return(
            <div className="main_wrapper">
                <header className="head">
                    <div className="main_logo">
                        {/* Разметка в логотипе возможно еще будет дорабатываеться */}
                        Willie-Miner.net
                    </div>
                    <div className="main_btn">
                        <ul>
                            <li><Link to="/">Главная</Link></li>
                            <li><Link to="/login">Вход</Link></li>
                            <li><Link to="/register">Регистрация</Link></li>
                            <li><Link to="/workspace">Рабочий кабинет</Link></li>
                        </ul>
                    </div>
                </header>
                <main className="body">
                    <div className="left_sidebar">
                        <h4>Левый сайдбар</h4>
                        <Switch>
                            <Route path="/login" render={() => <LoginForm load={this.sendAjax} />} />
                            <Route path="/register" render={() => <RegisterForm load={this.sendAjax} />}/>
                        </Switch>
                    </div>
                    <div className="main_content">
                        <h4>Тут будет основной контент</h4>
                    </div>
                </main>
                <footer className="footer">
                    Это футер...
                </footer>
            </div>
        );
    }
}

class LoginForm extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            login: '',
        };

        this.onLoginChange = this.onLoginChange.bind(this);
        this.onFormSubmit = this.onFormSubmit.bind(this);
    }
    onLoginChange(evt){
        this.setState({login: evt.target.value});
    }
    onFormSubmit(evt){
        evt.preventDefault();
        this.props.load(location.protocol + '//' + location.host + '/signin/authorization/', formLoginData(evt.currentTarget));
    }
    render(){
        const login = this.state.login;
        return(
            <div>
                <form onSubmit={this.onFormSubmit}>
                    <label>
                        Login: <input type="text" name="login" value={login} onChange={this.onLoginChange} />
                    </label>
                    <label>
                        Password: <input type="password" name="password" />
                    </label>
                    <input type="submit" name="submit" value="Вход"/>
                </form>
            </div>
        );
    }
}
class RegisterForm extends React.Component{
    constructor(props){
        super(props);
        this.state = {login: '', email: '', ref: false};

        this.onFormSubmit = this.onFormSubmit.bind(this);
        this.onLoginChange = this.onLoginChange.bind(this);
        this.onEmailChange = this.onEmailChange.bind(this);
    }
    componentWillMount(){
        let data = location.search;
        if(!data) return;
        let part = data.substring(data.indexOf('=')+1);
        this.setState({ref: part});
    }
    onFormSubmit(evt) {
        evt.preventDefault();
        let data = validateRegistration(evt.currentTarget);
        if(data == false) {
            alert('Введены некоректные данные');
            return false;
        }
        data.ref = this.state.ref;
        this.props.load(location.protocol + '//' + location.host + '/signup/registration/', data);
        this.setState({login: null, email: null});
    }
    onEmailChange(evt){
        this.setState({email: evt.target.value});
    }
    onLoginChange(evt){
        this.setState({login: evt.target.value});
    }
    render(){
        const login = this.state.login;
        const email = this.state.email;
        return(
            <div className="register_form">
                <form onSubmit={this.onFormSubmit}>
                    <label>
                        Login: <input type="text" name="login" value={login} onChange={this.onLoginChange} />
                    </label>
                    <label>
                        Email: <input type="email" name="email" value={email} onChange={this.onEmailChange} />
                    </label>
                    <label>
                        Password: <input type="password" name="password" />
                    </label>
                    <label>
                        Repeat password: <input type="password" name="password_repeat" />
                    </label>
                    <input type="submit" name="register" value="Регистрация" />
                </form>
            </div>
        );
    }
}
function IndexPage(){
    return(
        <div>
            <Route component={Base} />
        </div>
    )
}

// Тут будет происходить вся сборка роутов.
function App(props){
    return (
        <Switch>
            <Route path="/workspace" component={WorkspaceBase} />
            <Route path="/" component={IndexPage} />
        </Switch>
    );
}
ReactDOM.render(<Router>
    <App />
</Router>, document.getElementById('root'));