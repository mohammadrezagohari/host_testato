import React from "react";     
import './AppDownload.css'


const AppDownload = ()=>{

    
    return(
        <div className="AppDownload w-full h-16 flex justify-center lg:hidden xl:hidden">
            <a className="flex items-center justify-center w-full h-full text-white gap-2 bg-tclr" href="/">
                <span className="downloadIcon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.32031 11.6802L11.8803 14.2402L14.4403 11.6802" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11.8809 4V14.17" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 12.1799C20 16.5999 17 20.1799 12 20.1799C7 20.1799 4 16.5999 4 12.1799" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span className="downloadTitle">دانلود اپلیکیشن تستاتو</span> 
            </a>
        </div>
    );

}

export default AppDownload;
