import React, {useState} from 'react';
/// step 1 create context
const ThemeContext = React.createContext(false);
// step 2 create a provider
const ThemeProvider = ({children}) => {
    const [toggle, setToggle] = useState(false);
    const toggleFunction = () => {
        setToggle(!toggle);
    };
    const values = {
        toggle, toggleFunction
    }
    return (
        <ThemeContext.Provider value={values}>
            {children}
        </ThemeContext.Provider>
    )
}
export {ThemeContext, ThemeProvider};
