const card = document.querySelectorAll('.card');
    card.forEach((element)=>{
      element.addEventListener('click',()=>{
        removeClass()
        element.classList.add('active');
      })
    })

    const removeClass=()=>{
      card.forEach((element)=>{
        element.classList.remove('active')
      })
    }