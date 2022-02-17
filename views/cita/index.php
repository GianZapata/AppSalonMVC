<h1 
   class="text-5xl font-bold text-center my-20 mx-0"
>Crear Nueva Cita</h1>
<p class="text-center mb-10">Elige tus servicios y coloca tus datos</p>

<div id="app">
   <nav class="tabs md:flex">
      <button class="bg-white text-sky-600  cursor-pointer  p-4 block w-full mb-4 uppercase font-bold ease-in-out transition-all duration-300 " type="button" data-paso="1">Servicios</button>
      <button class="bg-sky-600 hover:bg-sky-700 cursor-pointer text-white p-4 block w-full mb-4 uppercase font-bold ease-in-out transition-all duration-300 " type="button" data-paso="2">Información Cita</button>
      <button class="bg-sky-600 hover:bg-sky-700 cursor-pointer text-white p-4 block w-full mb-4 uppercase font-bold ease-in-out transition-all duration-300 " type="button" data-paso="3">Resumen</button>
   </nav>
   <div id="paso-1" class="seccion py-10">
      <h2 class="text-5xl font-bold text-center my-20 mx-0">Servicios</h2>
      <p class="text-center">Elige tus servicios a continuación</p>
      <div id="servicios" class="listado-servicios"></div>
   </div>
   <div id="paso-2" class="seccion py-10 hidden">
      <h2 class="text-5xl font-bold text-center my-20 mx-0">Tus Datos y Cita</h2>
      <p class="text-center">Coloca tus datos y fecha de tu cita</p>
      <form action="/cita" class="formulario">
         <div 
            class="campo flex items-center mb-8 "
         >
            <label   
               class="flex grow-0 shrink-0 basis-40"
               for="name"
            >Nombre</label>
            <input 
               class="flex-1 py-3 px-3 border appearance-none rounded-2xl border-2xl leading-tight focus:outline-none focus:shadow-outline disabled:opacity-50 disabled:cursor-not-allowed text-white" 
               type="text" 
               name="name" 
               id="name" 
               placeholder="Tu Nombre" 
               required
               value="<?= $name ?>"
               disabled
            />
         </div>
         <div 
            class="campo flex items-center mb-8 "
         >
            <label   
               class="flex grow-0 shrink-0 basis-40"
               for="date"
            >Fecha</label>
            <input 
               class="flex-1 text-gray-700 py-3 px-3 border appearance-none rounded-2xl border-2xl leading-tight focus:outline-none focus:shadow-outline" 
               type="date" 
               name="date" 
               id="date" 
            />
         </div>
         <div 
            class="campo flex items-center mb-8 "
         >
            <label   
               class="flex grow-0 shrink-0 basis-40"
               for="time"
            >Hora</label>
            <input 
               class="flex-1 text-gray-700 py-3 px-3 border appearance-none rounded-2xl border-2xl leading-tight focus:outline-none focus:shadow-outline" 
               type="time" 
               name="time" 
               id="time" 
            />
         </div>
      </form>
      
   </div>
   <div id="paso-3" class="seccion py-10 hidden">
      
      <h2>Resumen</h2>
      <p>Verifica que la información sea correcta</p>
   </div>
   <div id="paginacion" class="py-3 px-0 md:flex md:justify-between">
      <button 
         class="block w-full md:w-auto uppercase cursor-pointer bg-sky-500 hover:bg-sky-700 text-white font-bold py-6 px-16 rounded focus:outline-none focus:shadow-outline transition-all duration-300 ease-in-out my-10" 
         id="anterior"
      >&laquo; Anterior</button>
      <button 
         class="block w-full md:w-auto uppercase cursor-pointer bg-sky-500 hover:bg-sky-700 text-white font-bold py-6 px-16 rounded focus:outline-none focus:shadow-outline transition-all duration-300 ease-in-out my-10" 
         id="siguiente"
      >Siguiente &raquo;</button>
   </div>
</div>