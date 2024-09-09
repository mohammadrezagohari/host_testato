import React from "react";
import QuestionExpTitle from "../QuestionExpTitle/QuestionExpTitle";
import AppDownload from "../AppDownload/AppDownload";
import TestatoInfo from "../TestatoInfo/TestatoInfo";
import TestatoTools from "../TestatoTools/TestatoTools";
import Footer from "../Footer/Footer";
 

const Main = () => {

    return(
        <>
            <QuestionExpTitle/>
            <TestatoInfo/>
            <TestatoTools/>
            <Footer/>
        </>
    );

}


export default Main;