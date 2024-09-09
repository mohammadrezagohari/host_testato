import React,{ useRef } from "react";
import { ReactDOM } from "react";
import './SideMenu.css';


const SideMenu = ()=>{
    
    const asideRef= useRef(null);
    const mainMenuRef= useRef(null);
    const fadeOpacityRef= useRef(null);
    let flag= false;

    const openNav = ()=> {
       if(flag === false){
         asideRef.current.style.transition = ".3s";
         asideRef.current.style.width= "300px";
        asideRef.current.style.marginRight = "0";
        asideRef.current.style.opacity = "1";
        asideRef.current.style.visibility = "visible";
        flag=true;
      }
    }
      const closeNav = ()=> {
         asideRef.current.style.transition = ".3s";
          asideRef.current.style.width = "0";
          asideRef.current.style.marginRight = "-350";
          asideRef.current.style.opacity = "0";
          asideRef.current.style.visibility = "hidden";

          flag=false;
       
      }

    return(
      <>
          <div  ref={mainMenuRef} className="mainMenu  2xl:hidden xl:hidden lg:hidden p-1 flex justify-center items-center w-10 h-10 rounded-full fixed top-6 right-6 cursor-pointer" >
              <button className="openBtn text-white" onClick={openNav}>
                <svg width="18" height="12" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <line x1="0.75" y1="14.4502" x2="21.25" y2="14.4502" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                  <line x1="0.75" y1="7.8501" x2="21.25" y2="7.8501" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                  <line x1="0.75" y1="1.25" x2="21.25" y2="1.25" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
              </button>
          </div>
          <div ref={asideRef} className="aside fixed right-0 top-0 bottom-0 text-white text-base z-50 rounded-tl-2xl rounded-bl-2xl p-6" >
          <div ref={fadeOpacityRef} className="cursor-pointer fadeOpacity"   onClick={closeNav}>
            <svg className="svgArrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#A7A7A7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9.16992 14.8299L14.8299 9.16992" stroke="#A7A7A7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M14.8299 14.8299L9.16992 9.16992" stroke="#A7A7A7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <ul className="menu mt-4">
              <a href="#">
                <li>چرا تستاتو</li>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.9998 19.9201L8.47984 13.4001C7.70984 12.6301 7.70984 11.3701 8.47984 10.6001L14.9998 4.08008" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                </a>
              <a href="#">
                <li>آشنایی با تستاتو</li>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.9998 19.9201L8.47984 13.4001C7.70984 12.6301 7.70984 11.3701 8.47984 10.6001L14.9998 4.08008" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
              <a href="#">
                <li>امکانات تستاتو</li>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.9998 19.9201L8.47984 13.4001C7.70984 12.6301 7.70984 11.3701 8.47984 10.6001L14.9998 4.08008" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
              <a href="#">
                <li>دانلود</li>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.9998 19.9201L8.47984 13.4001C7.70984 12.6301 7.70984 11.3701 8.47984 10.6001L14.9998 4.08008" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
          </ul>
        </div>
      </>
    );

 }


 export default SideMenu;