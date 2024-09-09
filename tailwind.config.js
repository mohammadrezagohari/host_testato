/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./resources/**/*.tsx",
        "./resources/**/*.ts",
    ],
    theme: {
      extend:{
        colors:{
            tclr:'#A490E7',
            tclr2:'#474747',
            tclr3:'#4B4B4B',
            tclr4:'#e2e2e2',
            txtclr5:'#595B5D0',
            mainclr0:'#EFEFEF',
            mainclr:'#1C75BC',
            bgbody:'f8fafc',
            cntclr:'#A490E7',
            cntclr1:'#E79990',
            cntclr2:'#E79990',
            cntclr3:'#E790A7',
            cntclt4:'#3F3F3F',
        }
      }
        
    },
    plugins: [],
}
