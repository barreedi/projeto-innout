
/*criamos um javascript  js q e simples pegamos o botao q e menutoggle*/
/*este codigo ele vai fazer com q os 3 tracos some e aparece*/
(function (){
    const menuToggle = document.querySelector('.menu-toggle')/*aqui a class menu-toggle movimentar tres tracos*/
    menuToggle.onclick = function (e) {    /*onclick para da um clique*/
    const body = document.querySelector('body')
    body.classList.toggle('hide-sidebar')/*aqui class hide sidebar para 3 ponto sumir*/
}
})()


function activateClock() {
    //este e espan
    const activeClock = document.querySelector('[active-clock]')
    if(!activeClock) return

    function addOneSecond(hours, minutes, seconds) {//funcao de horas
        const d = new Date()//data constante new date e data 
        d.setHours(parseInt(hours))//converte as horas em inteiro o parseint
        d.setMinutes(parseInt(minutes))
        d.setSeconds(parseInt(seconds) + 1)//acrescenta 1 para exemplo for  59s vai para 60 e zera
    
        const h = `${d.getHours()}`.padStart(2, 0)//metodo padstart para definir exemplo 3 fica 03
        const m = `${d.getMinutes()}`.padStart(2, 0)
        const s = `${d.getSeconds()}`.padStart(2, 0)
    
        return `${h}:${m}:${s}`//template string
    }

    //este codigo para atualiza a cada segundo o relogio
    setInterval(function() {
        // '07:27:19' => ['07', '27', '19'] o codigo de baixo transforme no array as horas
        const parts = activeClock.innerHTML.split(':')
        activeClock.innerHTML = addOneSecond(...parts)
    }, 1000)
}
activateClock()
