import React, {useRef} from "react";
import {ReactDOM} from "react";
import './ContactUs.css';
import {fetchContactData} from "../queries/contact";
import {ThreeDots} from "react-loader-spinner";
import {replace} from "lodash/string";
import vectorInfo from "../../../images/svgs/vector-info-call.svg";

const ContactUs = ({closeModal}) => {
    const {contactData, contactIsError, contactIsLoading} = fetchContactData()

    const flag = false;
    const modalRef = useRef(null);
    const closeModalRef = useRef(null);

    const closeModalFunc = () => {
        modalRef.current.style.opacity = 0;
        modalRef.current.style.visibility = "hidden";
        modalRef.current.style.transform = "scale(0)";
    }
    if (contactIsLoading) {
        return (<div className="flex items-center justify-center py-60">
            <ThreeDots
                height="80"
                width="80"
                radius="9"
                color="#4fa94d"
                ariaLabel="three-dots-loading"
                wrapperStyle={{}}
                wrapperClassName=""
                visible={true}
            />
        </div>)
    }

    return (<div ref={modalRef} className="w-full h-full fixed contactModal  top-0 z-50 overflow-x-hidden  bg-white">
        <div ref={closeModalRef} onClick={() => closeModal(false)}
             className="w-12 h-12 lg:w-14 lg:h-14 md:w-14 md:h-14 relative lg:top-10 md:top-10 top-8 lg:right-24 md:right-24 right-8 rounded-full cursor-pointer bg-mainclr0 flex justify-center items-center">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.4297 5.93018L20.4997 12.0002L14.4297 18.0702" stroke="#595B5D" strokeWidth="1.5"
                      strokeMiterlimit="10" strokeLinecap="round" strokeLinejoin="round"/>
                <path d="M3.5 12H20.33" stroke="#595B5D" strokeWidth="1.5" strokeMiterlimit="10"
                      strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
        </div>
        <div className="w-full lg:w-full md:w-full h-full flex flex-col lg:flex-row md:flex-row ">
            {contactIsError ? (<h2>خطایی در اتصال به سرور دارید</h2>) : (<div
                className="contactInfo lg:w-1/2 md:w-1/2 w-full relative top-10 right-8 lg:top-20 lg:right-24 md:top-20 md:right-24">
                <h2 className="text-4xl m-4 text-mainclr">اطلاعات تماس</h2>
                <ul className="flex gap-4 flex-col lg:w-full md:w-full lg:gap-4">
                    <li className=" flex  gap-4 items-center w-full text-extrabold">
                        <div
                            className="w-12 h-12 lg:w-14 lg:h-14 md:w-14 md:h-14 flex justify-center items-center rounded-full  bg-cntclr">
                            <svg width="26" height="32" viewBox="0 0 26 32" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M25 8.5V23.5C25 29.5 23.5 31 17.5 31H8.5C2.5 31 1 29.5 1 23.5V8.5C1 2.5 2.5 1 8.5 1H17.5C23.5 1 25 2.5 25 8.5Z"
                                    stroke="white" strokeWidth="1.5" strokeLinecap="round"
                                    strokeLinejoin="round"/>
                                <path d="M16 6.25H10" stroke="white" strokeWidth="1.5" strokeLinecap="round"
                                      strokeLinejoin="round"/>
                                <path
                                    d="M13.0008 26.65C14.2848 26.65 15.3258 25.6091 15.3258 24.325C15.3258 23.0409 14.2848 22 13.0008 22C11.7167 22 10.6758 23.0409 10.6758 24.325C10.6758 25.6091 11.7167 26.65 13.0008 26.65Z"
                                    stroke="white" strokeWidth="1.5" strokeLinecap="round"
                                    strokeLinejoin="round"/>
                            </svg>
                        </div>

                        <span className="text-2xl "><a
                            href={`tel:${contactData?.data?.mobile}`}>{contactData?.data?.mobile}</a></span>
                    </li>
                    <li className="flex  gap-4 items-center w-full md:w-full lg:w-full ">
                        <div
                            className="w-12 h-12 lg:w-14 lg:h-14 md:w-14 md:h-14 flex justify-center items-center rounded-full  bg-cntclr1">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.666 27.3334H9.33268C5.33268 27.3334 2.66602 25.3334 2.66602 20.6667V11.3334C2.66602 6.66675 5.33268 4.66675 9.33268 4.66675H22.666C26.666 4.66675 29.3327 6.66675 29.3327 11.3334V20.6667C29.3327 25.3334 26.666 27.3334 22.666 27.3334Z"
                                    stroke="white" strokeWidth="1.5" strokeMiterlimit="10" strokeLinecap="round"
                                    strokeLinejoin="round"/>
                                <path
                                    d="M22.6673 12L18.494 15.3333C17.1206 16.4267 14.8673 16.4267 13.494 15.3333L9.33398 12"
                                    stroke="white" strokeWidth="1.5" strokeMiterlimit="10" strokeLinecap="round"
                                    strokeLinejoin="round"/>
                            </svg>
                        </div>
                        <span className="text-2xl ">
                                    <a href={`mailto:${contactData?.data?.email}`}>{contactData?.data?.email}</a>
                                </span>
                    </li>
                    <li className="flex  gap-4 items-center w-full">
                        <div
                            className="w-12 h-12 lg:w-14 lg:h-14 md:w-14 md:h-14 flex justify-center items-center rounded-full bg-cntclr2">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.75" y="0.75" width="26.1889" height="26.5" rx="5.25" stroke="white"
                                      strokeWidth="1.5"/>
                                <circle cx="13.6871" cy="13.9988" r="6.22222" stroke="white" strokeWidth="1.5"/>
                                <ellipse cx="21.6232" cy="6.06585" rx="1.71111" ry="1.71111" fill="white"/>
                            </svg>
                        </div>
                        <span className="text-2xl"> <a
                            href={contactData?.data?.instagram}>{contactData?.data?.instagram.replace("https://instagram.com/", "").replace("/", '')}</a></span>
                    </li>
                    <li className="flex  gap-4 items-center w-full">
                        <div
                            className="w-12 h-12 lg:w-14 lg:h-14 md:w-14 md:h-14 flex justify-center items-center rounded-full bg-cntclr">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.9998 17.9067C18.2973 17.9067 20.1598 16.0442 20.1598 13.7467C20.1598 11.4492 18.2973 9.58667 15.9998 9.58667C13.7023 9.58667 11.8398 11.4492 11.8398 13.7467C11.8398 16.0442 13.7023 17.9067 15.9998 17.9067Z"
                                    stroke="white" strokeWidth="1.5"/>
                                <path
                                    d="M4.82758 11.3201C7.45425 -0.226582 24.5609 -0.213249 27.1742 11.3334C28.7076 18.1068 24.4942 23.8401 20.8009 27.3868C18.1209 29.9734 13.8809 29.9734 11.1876 27.3868C7.50758 23.8401 3.29425 18.0934 4.82758 11.3201Z"
                                    stroke="white" strokeWidth="1.5"/>
                            </svg>
                        </div>
                        <span className="text-2xl ">{contactData?.data?.address}</span>
                    </li>
                </ul>
            </div>)}
            <div
                className="imageHolde lg:w-1/2 md:w-1/2 w-full relative top-20 lg:top-0 md:top-0 flex justify-center items-center">
                <img src={vectorInfo} className="lg:w-3/4 md:3/4 w-3/4"
                     alt="تماس با ما"/>
            </div>
        </div>
    </div>);

}


export default ContactUs;
