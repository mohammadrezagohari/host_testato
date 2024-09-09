import React, {useContext} from 'react';
import './app_layout.scss'

const AppLayout = ({children}) => {
    return (
        <div className="wrapper">
            {children}
        </div>
    );
}

export default AppLayout;
