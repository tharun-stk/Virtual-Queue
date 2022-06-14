homeblur = document.querySelector('.home')
openbutton = document.querySelector('.loginbutton')
closebutton = document.querySelector('.closebutton')
about = document.querySelector('.about')
contact = document.querySelector('.contact')


function openForm() {
    document.getElementById("myForm").style.display = "block";


}

function closeForm() {
    document.getElementById("myForm").style.display = "none";



}

openbutton.addEventListener('click', () => {
    homeblur.classList.add('blur')
    about.classList.add('blur')
    contact.classList.add('blur')
})

closebutton.addEventListener('click', () => {
    homeblur.classList.remove('blur')
    about.classList.remove('blur')
    contact.classList.remove('blur')

})