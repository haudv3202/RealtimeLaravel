import './bootstrap';


Echo.private('notifications')
    .listen('UserSessionChanged',(e) =>{
        const notificationElement = document.querySelector("#notification")
        console.log(e);
        notificationElement.innerText = e.messege
        notificationElement.classList.remove('invisible')
        notificationElement.classList.remove('alert-success')
        notificationElement.classList.remove('alert-danger')
        notificationElement.classList.add('alert-'+ e.type);
    });
