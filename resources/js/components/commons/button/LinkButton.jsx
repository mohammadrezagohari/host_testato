import React from "react";
import './linkButton.css'

export default function LinkButton(props) {

    return (
        <>
            <button key={props.children.id}
                    className="w-40 h-16 md:w-40 lg:w-40 shadow-xs bg-opacity-25 bg-teal-400 m-2 rounded-2xl transition-all text-white  border-none outline-none link-button ">
                <a className="flex w-full h-full justify-center text-center gap-0 items-center"
                   href={props.children.link}>
                    <img className="mr-4" src={props.children.src} alt={props.children.subject}/>
                    <p className="ml-2 w-28 md:w-28 lg:w-28">{props.children.subject}</p>
                </a>
            </button>
        </>
    );
}
