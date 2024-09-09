import React from "react";
import './TestatoInfo.css'


const AboutTestato = (props)=>{

    return(
            <div className=" info-container pt-10  h-max-fit pr-10 pl-10 flex flex-col lg:w-full lg:flex-row md:flex-col p-0 ">
                <div className="info-section w-full lg:w-1/2">
                    <h3 className="text-3xl font-extrabold titles">{props.children.title}</h3>
                    <p className="mt-6 text-xl  text-justify w-full lg:mb-20 lg:mt-10 ">{props.children.descriptions}</p>
                </div>
                <div className=" flex mt-4 justify-center image-section w-full relative lg:h-full md:w-full lg:w-1/2 md:mt-12">
                    <div className=" phoneImage  w-3/4 lg:w-3/4"/>
                </div>
            </div>
    );

}


export default AboutTestato;