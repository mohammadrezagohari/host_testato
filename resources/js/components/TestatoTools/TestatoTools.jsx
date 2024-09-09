import React from "react";
import './TestatoTools.css'
import Tools from "./Tools";
import moneyIcon from "../../../images/svgs/wallet-money-1.svg"
import bookmarkIcon from "../../../images/svgs/bookmark-folder-1.svg"
import FAQIcon from "../../../images/svgs/faq-4147338.svg"
import writeDocumentIcon from "../../../images/svgs/write-document-icon-3d.svg"

const TestatoTools = () => {

    const toolsItems = [
        {
            id: 1,
            src: moneyIcon,
            title: "پرداخت امن",
            details: `لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و`
        },
        {
            id: 2,
            src: bookmarkIcon,
            title: "امکان ذخیره سوالات ",
            details: `لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و`
        },
        {
            id: 3,
            src: FAQIcon,
            title: "مشاهده حل سوالات",
            details: `لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و`
        },
        {
            id: 4,
            src: writeDocumentIcon,
            title: "مشاهده پاسخنامه",
            details: `لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنـی آزمایشـی و`
        },
    ]

    return (
        <section id="facilities_us" className="flex justify-center p-8 flex-col w-full tl-container lg:h-max  ">
            <h3 className="text-2xl md:text-3xl lg:text-5xl   m-6 font-extrabold text-mainclr">امکانات تستاتو</h3>
            <div
                className="grid  lg:grid-cols-4 md:grid-cols-2 testato-tools-container justify-center lg:m-0 md:m-0 w-full">
                {
                    toolsItems.map((tool) => (
                        <Tools key={tool.id}>{tool}</Tools>
                    ))
                }
            </div>
        </section>
    );

}


export default TestatoTools;
