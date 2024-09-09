import React from "react";
import './TestatoInfo.css';
import AboutTestato from "./AboutTestato";
import LinkButton from "../commons/button/LinkButton";
import logo_app_store from '../../../images/icon/app-store-logo-1.png';
import logo_cafe_bazar from '../../../images/icon/logo-cafe-bazar.png';
import logo_direct_download from '../../../images/icon/direct-download.png';
import mokap_mobile_file2 from '../../../images/svgs/mokap-mobile-file2.svg';
import {fetchDownloadApp} from "../queries/version";
import {ThreeDots} from "react-loader-spinner";


const TestatoInfo = () => {
    const {downloadData, downloadIsError, downloadIsLoading} = fetchDownloadApp()


    if (downloadIsLoading) {
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

    const linksItem = [
        {id: 1, subject: "دانلود از اپ استور", src: logo_app_store, link: ""},
        {id: 2, subject: "دانلود از کافه بازار", src: logo_cafe_bazar, link: ""},
        {id: 3, subject: "دانلود مستقیم", src: logo_direct_download, link: !downloadIsError ? downloadData?.link : ''},
    ]
    const info = [
        {
            id: 1,
            title: "بخش آزمون",
            descriptions:
                `
            لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و
            ی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود. طراح
            گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه
            اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از
            نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. معمولا
            طراحان گرافیک برای صفحـه‌آرایـی، نخست از متـن‌هـای آزمایشـی و بی‌معنی
            استفاده می‌کنند تا صرفا به مشتــری یا صاحـب کــار خــود نشــان دهنـــد که
            صفحه طراحی یا صفحه بندی شده بعد از اینکه متن در آن قرار گیرد چگـونه
             `,
        },
        {
            id: 2,
            title: "بخش نمونه سوالات",
            descriptions:
                `
           لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و
           ی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود. طراح
           گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه
           اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از
           نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. معمولا
           طراحان گرافیک برای صفحـه‌آرایـی، نخست از متـن‌هـای آزمایشـی و بی‌معنی
           استفاده می‌کنند تا صرفا به مشتــری یا صاحـب کــار خــود نشــان دهنـــد که
           صفحه طراحی یا صفحه بندی شده بعد از اینکه متن در آن قرار گیرد چگـونه
            `,
        },
        {
            id: 3,
            title: "بخش فرمول ها",
            descriptions:
                `
           لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و
           ی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود. طراح
           گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه
           اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از
           نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. معمولا
           طراحان گرافیک برای صفحـه‌آرایـی، نخست از متـن‌هـای آزمایشـی و بی‌معنی
           استفاده می‌کنند تا صرفا به مشتــری یا صاحـب کــار خــود نشــان دهنـــد که
           صفحه طراحی یا صفحه بندی شده بعد از اینکه متن در آن قرار گیرد چگـونه
            `,
            src: "",
        },
    ]

    return (
        <>
            <section id="why_testato" className=" pt-10 why-testato h-max-fit pr-10 pl-10 flex  flex-col p-0  ">
                <h2 className="text-5xl  font-extrabold text-mainclr w-full "> چرا تستاتو؟</h2>
                <div className="flex-items w-full flex-col md:flex-row lg:flex-row ">
                    <div className="dec-container  lg:max-w-4xl lg:w-1/2  md:w-full ">
                        <p className="mt-6 text-xl  text-justify w-full lg:mb-20 lg:mt-10">
                            لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و
                            ی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود. طراح
                            گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه
                            اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از
                            نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. معمولا
                            طراحان گرافیک برای صفحـه‌آرایـی، نخست از متـن‌هـای آزمایشـی و بی‌معنی
                            استفاده می‌کنند تا صرفا به مشتــری یا صاحـب کــار خــود نشــان دهنـــد که
                            صفحه طراحی یا صفحه بندی شده بعد از اینکه متن در آن قرار گیرد چگـونه
                        </p>
                        <div
                            className='btn-container flex  flex-col items-center justify-center w-full md:w-full mt-4 md:flex-row lg:flex-row'>
                            {
                                linksItem.map((linkItem) => (
                                    <LinkButton key={linkItem.id} className="link-button">{linkItem}</LinkButton>
                                ))
                            }
                        </div>
                    </div>
                    <div className="flex justify-center items-center w-full lg:h-full md:w-full lg:w-1/2 img-container">
                        <img src={mokap_mobile_file2} alt="phone image"
                             className="lg:h-full w-3/4 mr-14 mt-4  lg:w-3/4 lg:m-0 lg:mr-20 md:w-full md:mr-8"/>
                    </div>
                </div>
            </section>
            <section id="familiar_us"
                     className="about-testato-container flex flex-col h-max w-full  lg:h-max p-0 pr-10 pl-10 h-max-fit">
                <h2 className="text-5xl font-extrabold pt-8 text-tclr">آشنایی با تستاتو</h2>
                <div className="childControl">
                    {
                        info.map((info) => (
                            <AboutTestato key={info.id}>{info}</AboutTestato>
                        ))
                    }
                </div>
            </section>
        </>
    );

}

export default TestatoInfo;
