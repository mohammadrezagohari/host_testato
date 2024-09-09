import React from 'react';
import  './header.scss'
export default function Header ({children}){
    return (
        <header>
            <div className="flex justify-between">
                {children}
            </div>
        </header>
    );
}
