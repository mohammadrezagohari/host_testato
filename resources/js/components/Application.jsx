import React, {useContext} from 'react';
import ReactDOMClient from 'react-dom/client';
import ReactDOM from 'react-dom';
import {BrowserRouter} from 'react-router-dom';
import {ThemeContext} from "./stateManagements/ThemeContext";
import AppLayout from "./commons/layout/AppLayout";
import Header from "./commons/header/Header";
import Router from './router/Router';
import Main from './Main/Main';
// import QuestionExpTitle from './QuestionExpTitle/QuestionExpTitle';
import './app.css';
import {QueryClient, QueryClientProvider} from "react-query";

function Application() {
    const queryClient = new QueryClient();
    const {toggle, toggleFunction} = useContext(ThemeContext)
    return (
        <AppLayout>
            <QueryClientProvider client={queryClient}>
                <Header>
                    <Router/>
                </Header>
                <Main/>
            </QueryClientProvider>
        </AppLayout>
    );
}

export default Application;


if (document.getElementById('app')) {
    const Index = ReactDOMClient.createRoot(document.getElementById("app"));
    Index.render(
        <React.StrictMode>
            <BrowserRouter>
                <Application/>
            </BrowserRouter>
        </React.StrictMode>
    )
}
