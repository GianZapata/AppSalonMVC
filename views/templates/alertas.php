<?php 
   foreach($alertas as $tipo => $mensajes): 
      foreach($mensajes as $mensaje): 
         $clases = '';
         switch($tipo) {
            case 'error': 
               $clases = 'bg-red-800';
            break;
            case 'success': 
               $clases = 'bg-green-800';
            break;
         }
?>      
      <div class="p-2 text-white w-full block mb-8 text-center font-bold uppercase <?= $clases ?>">
         <?= $mensaje ?>
      </div>
<?php    
      endforeach; 
   endforeach; 
?>
