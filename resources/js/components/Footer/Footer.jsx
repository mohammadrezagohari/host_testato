import React from "react";
import './footer.css';
import LinkButton from "../commons/button/LinkButton";
import logo_app_store from "../../../images/icon/app-store-logo-1.png";
import logo_cafe_bazar from "../../../images/icon/logo-cafe-bazar.png";
import logo_direct_download from "../../../images/icon/direct-download.png";
import {fetchDownloadApp} from "../queries/version";
import {ThreeDots} from "react-loader-spinner";

const Footer = () => {
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

    return (
        <footer id="download_app" className=" pb-20 bg-no-repeat bg-cover md:bg-no-repeat md:bg-cover">
            <h1 className="text-3xl  lg:text-6xl md:text-5xl   lg:w-2/3  font-extrabold ">
                تستاتو،<br/>
                اپلیکیشنی برای تمام دانش آموزان
            </h1>
            <div className="btn-container">
                {
                    linksItem.map((linkItem) => (
                        <LinkButton key={linkItem.id} className="link-button">{linkItem}</LinkButton>
                    ))
                }
            </div>
        </footer>
    );

}


export default Footer;
