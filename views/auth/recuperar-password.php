<h1 
   class="nombre-pagina text-5xl font-bold text-center my-20 mx-0"
>Recuperar Password</h1>
<p class="descripcion-pagina text-center mb-10">Coloca tu nuevo password a continuación</p>


<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
<?php if(!$error): ?>
   <form 
      method="POST" 
      class="formulario w-full"
      novalidate
   >
      <div 
         class="campo flex items-center mb-8 "
      >
         <label 
            for="password"
            class="flex grow-0 shrink-0 basis-40"
         >Password</label>
         <input 
            class="flex-1 text-gray-700 py-3 px-3 border appearance-none rounded-2xl border-2xl leading-tight focus:outline-none focus:shadow-outline" 
            type="password" 
            name="password" 
            id="password" 
            placeholder="Tu Nuevo Password" 
            required
         />
      </div>
      <input 
         value="Guardar Nuevo Password"
         class="block w-full md:w-auto uppercase cursor-pointer bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-6 px-16 rounded focus:outline-none focus:shadow-outline transition-all duration-300 ease-in-out my-10"
         type="submit"   
      />
   </form>

   <div class="acciones text-center my-20 md:flex md:justify-between">
      <a 

         class="block text-cyan-500 hover:text-cyan-700 mb-5 text-center" 
         href="/"
      >¿Ya tienes cuenta? Iniciar Sesión</a>
      <a 
         class="block text-cyan-500 hover:text-cyan-700 mb-5 text-center" 
         href="/register"
      >¿Aun no tienes una cuenta? Obtener una</a>
   </div>
<?php endif; ?>

