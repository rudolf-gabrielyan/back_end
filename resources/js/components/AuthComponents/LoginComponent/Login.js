import React, { useState } from 'react';
import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import { BrowserRouter, Route, Switch,Link,useHistory } from 'react-router-dom';
import Grid from '@material-ui/core/Grid';
import Box from '@material-ui/core/Box';
import LockOutlinedIcon from '@material-ui/icons/LockOutlined';
import Typography from '@material-ui/core/Typography';
import { makeStyles } from '@material-ui/core/styles';
import Container from '@material-ui/core/Container';
import { login } from '../../redux/actions/userActions';
import { connect } from 'react-redux';


import './login.scss'


const useStyles = makeStyles(theme => ({
  paper: {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
  },
  avatar: {
    margin: theme.spacing(1),
    backgroundColor: theme.palette.secondary.main,
  },
  form: {
    width: '100%',
  },
  input: {
    marginBottom: "30px"
  },
  submit: {
    marginBottom: "30px"
  }
}));

function Login({ login, loginErrors }) {
  const classes = useStyles();
  const history = useHistory();

  const [loginData, setLoginData] = useState({email: '', password: '' });

  const handleLoginDataChange = event => {
    event.persist();
    setLoginData({ ...loginData, [event.target.id]: event.target.value});
  };

  const handleLogin = event => {

    event.preventDefault();
    login(loginData)
    .then(response => response === 'success' ? history.push('/profile') : null);

  };


  return (
    <Container component="main" maxWidth="xs">
      <CssBaseline />
      <div className={classes.paper}>
        <Avatar className={classes.avatar}>
          <LockOutlinedIcon />
        </Avatar>
        <Typography component="h1" variant="h5">
          Sign in
        </Typography>
        <form className={classes.form} noValidate>
        {typeof loginErrors === 'string' && <p className="loginError">{loginErrors}</p>}
          <TextField
            variant="outlined"
            margin="normal"
            required
            fullWidth
            id="email"
            label="Email Address"
            name="email"
            autoComplete="email"
            autoFocus
            onChange={handleLoginDataChange}
            value={loginData.email}
            className={classes.input}
          />

          <TextField
            variant="outlined"
            margin="normal"
            required
            fullWidth
            name="password"
            label="Password"
            type="password"
            id="password"
            autoComplete="current-password"
            onChange={handleLoginDataChange}
            value={loginData.password}
            className={classes.input}
          />
          <Button
            type="submit"
            fullWidth
            variant="contained"
            color="primary"
            className={classes.submit}
            onClick={handleLogin}
          >
            Sign In
          </Button>
          <Grid container>
            <Grid item>
              <Link className="goSignup" to="/signup" variant="body2">
                {"Don't have an account? Sign Up"}
              </Link>
            </Grid>
          </Grid>
        </form>
      </div>
    </Container>
  );
}


const mapStateToProps = state => {
    return {
        loginErrors: state.user.loginErrors,
    }
};

const mapDispatchToProps = dispatch => {
    return {
        login: data => dispatch(login(data))
    }
};

export default connect(mapStateToProps, mapDispatchToProps)(Login)

