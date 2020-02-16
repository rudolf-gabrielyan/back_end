import React, { Component,useEffect,useState } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch } from 'react-router-dom';
import { Provider, connect } from 'react-redux';
import store from './components/redux/reducers/index';
import { checkAuth } from './components/redux/actions/userActions';
import ProtectedRoute from './ProtectedRoute';

import Login from './components/AuthComponents/LoginComponent/Login';
import Signup from './components/AuthComponents/SignupComponent/Signup';
import Profile from './components/User/Profile';
import UserHeader from './components/User/UserHeader/UserHeader';
import MyResumes from './components/Resume/myResume';
import './index.scss'


function Index({ checkAuth }) {

    const [render, setRender] = useState(false);

    useEffect(() => {
        checkAuth().then(()=>setRender(true));
    }, []);

    if(render){
        return (
            <BrowserRouter>
                <Switch>
                    <ProtectedRoute exact path='/login' component={Login} />
                    <ProtectedRoute exact path='/signup' component={Signup} />

                    <Route to="/">
                        <UserHeader/>
                        <Switch>
                            <ProtectedRoute exact path='/profile' component={Profile} />
                            <ProtectedRoute exact path='/resumes' component={MyResumes} />
                        </Switch>
                    </Route>

                </Switch>
            </BrowserRouter>
        )
    }
    else {
        return (
            <div className="loading" style={{fontSize:"84px"}}>Loading...</div>
        )
    }
}

const mapDispatchToProps = dispatch => {
    return {
        checkAuth: () => dispatch(checkAuth())
    }
};

const MainApp = connect(null, mapDispatchToProps)(Index);

if (document.getElementById('hacktech')) {
    ReactDOM.render(
        <Provider store={store}>
            <MainApp />
        </Provider>,
        document.getElementById('hacktech'));
}


