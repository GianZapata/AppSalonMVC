// Using Classes TailwindCSS
let paso : number = 1;
const pasoInicial : number = 1;
const pasoFinal : number = 3;

document.addEventListener('DOMContentLoaded', function() {
   initApp();
});

function initApp() {
   mostrarSeccion(); // Muestra y oculta las secciones
   tabs(); // Cambia la sección cuando se presionan los tabs
   botonesPaginador(); // Cambia la sección cuando se presionan los botones de paginación
   paginaSiguiente(); // Cambia la sección cuando se presiona el botón de siguiente
   paginaAnterior(); // Cambia la sección cuando se presiona el botón de anterior
}

function mostrarSeccion() {
   // Ocultar la sección que tenga la clase de mostrar
   const seccionAnterior = document.querySelector('.seccion.mostrar');
   if (seccionAnterior) {
      seccionAnterior.classList.remove('mostrar');
      seccionAnterior.classList.add('hidden');      
   }
   const pasoSelector = `#paso-${paso}`;
   const seccion : HTMLElement = document.querySelector(pasoSelector) as HTMLElement;   
   seccion.classList.add('mostrar');  
   seccion.classList.remove('hidden');

   // Quita la clase de seleccionado a todos los tabs
   const tabAnterior = document.querySelector('button.actual');
   if (tabAnterior) {
      tabAnterior.classList.remove('actual');  
      tabAnterior.classList.remove('bg-white','text-sky-600'); 
      tabAnterior.classList.add('bg-sky-600','hover:bg-sky-700','text-white')
   }

   // Resalta el tab actual
   const tab = <HTMLDivElement>document.querySelector(`[data-paso="${paso}"]`);
   tab.classList.add('actual');  
   tab.classList.remove('bg-sky-600','hover:bg-sky-700','text-white');
   tab.classList.add('bg-white','text-sky-600');                                      
}

function tabs() {
   const tabs = <HTMLDivElement>document.querySelector('.tabs'); // HTMLDivElement es un alias de HTMLDivElement
   tabs?.addEventListener('click', (e: MouseEvent) => { // Con MouseEvent se puede capturar el evento del botón
      const target = e.target as HTMLElement; // Con HTMLElement podemos acceder a todos los elementos HTML
      // Check if  the clicked element is button
      if (target.tagName.toLowerCase() === 'button') {
         paso = Number(target.dataset.paso); // Obtenemos el paso desde el atributo data-paso
         mostrarSeccion();
         botonesPaginador();
      }
   })
}

function botonesPaginador(){ 
   const paginaAnterior = <HTMLButtonElement>document.querySelector('#anterior');
   const paginaSiguiente = <HTMLButtonElement>document.querySelector('#siguiente');

   if(paso === 1 ) { // Si estamos en el primer paso, deshabilitamos el botón de página anterior
      paginaAnterior.classList.add('invisible');
      paginaSiguiente.classList.remove('invisible');
   } else if (paso === 3) { // Si estamos en el último paso, deshabilitamos el botón de página siguiente
      paginaAnterior.classList.remove('invisible');
      paginaSiguiente.classList.add('invisible');
   } else { // Si estamos en cualquier otro paso, habilitamos ambos botones
      paginaAnterior.classList.remove('invisible');
      paginaSiguiente.classList.remove('invisible');
   }
}

function paginaAnterior() {
   const paginaAnterior = <HTMLButtonElement>document.querySelector('#anterior');
   paginaAnterior.addEventListener('click', () => {
      if(paso <= pasoInicial) return;
      paso--;
      mostrarSeccion();
      botonesPaginador();
   })
}

function paginaSiguiente() {
   const paginaSiguiente = <HTMLButtonElement>document.querySelector('#siguiente');
   paginaSiguiente.addEventListener('click', () => {
      if(paso >= pasoFinal) return;
      paso++;
      mostrarSeccion();
      botonesPaginador();
   })
}