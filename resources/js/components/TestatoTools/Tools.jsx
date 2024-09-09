import React from "react";



const Tools = (props) => {

    return(
        <section className="  pr-8 pl-8 pt-14 pb-14 md:pt-8 md:pb-8  tools-itmems m-4 flex flex-col justify-center items-center  gap-8" key={props.children.id}>
            <img src={props.children.src} className="w-24" alt="عکس"/>
            <h3 className="text-2xl text-center font-bold">{props.children.title}</h3>
            <p className="text-l text-center">{props.children.details}</p>
        </section>
    );

}


export default Tools;
