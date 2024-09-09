import React from "react";

const QuestionTitles = (props)=>{
    return(
        <div className="lg:text-3xl md:text-2xl text-xs  font-extrabold flex flex-items flex-col h-max lg:gap-6 md:gap-6 gap-2 text-center text-white ">
            <h2 className="font-bold text-white">نمونه سوال های {props.children}</h2>
            <h2 className="lg:text-5xl md:3xl text-2xl  font-extrabold">{props?.count ?? 1000}+</h2>
        </div>
    );

}
export default QuestionTitles;
