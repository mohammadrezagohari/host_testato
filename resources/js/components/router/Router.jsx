import React, {useContext} from 'react';
import ReactDOM from 'react-dom';
import {Link} from "react-router-dom";
import {ThemeContext} from "../stateManagements/ThemeContext";
import './router.css';
import Logo from "../icons/logo/logo";
import mobileImage from '../../../images/header.png';
// import IconButton from '../commons/button/IconButton';
import LinkButton from '../commons/button/LinkButton';
import SideMenu from './SideMenu/SideMenu';
import {useRef, useState} from 'react';
import ContactUs from '../ContactUs/ContactUs';
import logo_app_store from '../../../images/icon/app-store-logo-1.png';
import logo_cafe_bazar from '../../../images/icon/logo-cafe-bazar.png';
import logo_direct_download from '../../../images/icon/direct-download.png';

const Router = () => {

    const [openModal, setOpenModal] = useState(false);
    let contactUsRef = useRef();
    const modalRef = useRef();
    const {toggle, toggleFunction} = useContext(ThemeContext);

    const linksItem = [
        {id: 1, subject: "دانلود از اپ استور", src: logo_app_store, link: ""},
        {id: 2, subject: "دانلود از کافه بازار", src: logo_cafe_bazar, link: ""},
        {id: 3, subject: "دانلود مستقیم", src: logo_direct_download, link: ""},
    ];

    if (openModal) {
        document.body.classList.add('unscrollable');
    } else {
        document.body.classList.remove('unscrollable');
    }
    return (
        <div className="flex flex-start flex-wrap  w-full container-holder">
            <div className="btnCt w-full relative top-0 flex justify-between pr-8 pl-8 lg:hidden">
                <div onClick={() => setOpenModal(true)}
                     className=" bg-cntclt4  2xl:hidden xl:hidden lg:hidden p-1 flex justify-center items-center w-10 h-10 rounded-full  cursor-pointer">
                    <button className=" text-white">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74L9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33Z"
                                stroke="white" strokeWidth="1.5" strokeMiterlimit="10"/>
                            <path d="M16.1992 7.8H20.9992M16.1992 7.8V3V7.8Z" stroke="white" strokeWidth="1.5"
                                  strokeLinecap="round" strokeLinejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div
                    className="bg-cntclt4 2xl:hidden xl:hidden lg:hidden p-1 flex justify-center items-center w-10 h-10 rounded-full cursor-pointer">
                    <button className=" text-white">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.32031 11.6802L11.8803 14.2402L14.4403 11.6802" stroke="white" strokeWidth="1.5"
                                  strokeMiterlimit="10" strokeLinecap="round" strokeLinejoin="round"/>
                            <path d="M11.8809 4V14.17" stroke="white" strokeWidth="1.5" strokeMiterlimit="10"
                                  strokeLinecap="round" strokeLinejoin="round"/>
                            <path d="M20 12.1802C20 16.6002 17 20.1802 12 20.1802C7 20.1802 4 16.6002 4 12.1802"
                                  stroke="white" strokeWidth="1.5" strokeMiterlimit="10" strokeLinecap="round"
                                  strokeLinejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
            <Link
                className="logo-link absolute right-1/2 translate-x-1/2 md md:right-1/2 md:translate-x-1/2 lg:right-24 lg:top-8 lg:w-20 lg:h-20  w-16 h-16 top-4"
                to="/"><Logo className="w-2 h-2"/></Link>
            <nav
                className="w-full hidden md:hidden lg:flex lg:justify-center relative navigation-bar lg:right-1/2 lg:translate-x-1/2 ">
                <ul className="flex flex-menu ">
                    <li><a className="main-route" href='#why_testato'>چرا تستاتو</a></li>
                    <li><a className="main-route" href="#familiar_us">آشنایی با تستاتو</a></li>
                    <li><a className="main-route" href="#facilities_us">امکانات تستاتو</a></li>
                    <li><a className="main-route" href="#download_app">دانلود</a></li>
                    <li ref={contactUsRef} onClick={() => {
                        setOpenModal(true);
                    }}><a href="#" className="main-route">تماس با ما</a></li>
                </ul>
            </nav>
            <div className="icon-mobile-holder  w-full  flex justify-items-center flex-col md:flex-col lg:flex-row">
                <div
                    className=" container-text flex flex-col w-full p-10 margin-main-heading-text lg:pt-0 lg:mt-0 lg:h-full lg:pr-24 mt-28 w-30">
                    <h1 className=' font-extrabold lg:mt-20 text-white text-5xl m-0 leading-snug lg:text-7xl lg:min-w-max'>با
                        تستاتـــو، <br/>
                        تستاتو خودت بزن!</h1>
                    <p className='font-hairline text-4xl leading-snug text-white lg:text-5xl lg:w-full lg:leading-normal'>تستاتو
                        اپلیکیشن تخصصی تست ریاضی
                        و فیزیک</p>
                </div>
                <div className="main-image-box relative  flex p-0 justify-center items-start w-full ">
                    <img className='lg:ml-48' src={mobileImage} alt="mobile icon testato"/>
                </div>
            </div>
            <div
                className='button-container lg:right-20 flex justify-center items-center flex-col  md:flex-row w-full  lg:max-w-fit'>
                {
                    linksItem.map((linkItem) => (
                        <LinkButton key={linkItem.id} className="link-button">{linkItem}</LinkButton>
                    ))
                }

            </div>
            {openModal && <ContactUs closeModal={setOpenModal}/>}
        </div>
    )
}
export default Router;
