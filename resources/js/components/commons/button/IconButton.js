import React from 'react';
import './button.scss';
const IconButton = ({type, icon, subject}) => {
    return (
        <>
            <button className="icon-button" type={type}>
                {subject}
                <img src={icon} alt={subject} className="w-4"/>
            </button>
        </>
    )
}

export default IconButton;
