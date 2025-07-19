let icon=document.querySelector('.password i');
let passwordinput=document.querySelector('.passwordinput');
var click=0;
icon.onclick=()=>{

    if (passwordinput.type=="password") {
        passwordinput.type="text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }else{
        passwordinput.type="password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }

}




let secoundicon=document.querySelector('.passwordconfirm i');
let confirmpasswordinput=document.querySelector('.passwordconfirminput');
secoundicon.onclick=()=>{
    if (confirmpasswordinput.type=="password") {
        confirmpasswordinput.type="text";
        secoundicon.classList.remove("fa-eye");
        secoundicon.classList.add("fa-eye-slash");
    }else{
        confirmpasswordinput.type="password";
        secoundicon.classList.remove("fa-eye-slash");
        secoundicon.classList.add("fa-eye");
    }

}