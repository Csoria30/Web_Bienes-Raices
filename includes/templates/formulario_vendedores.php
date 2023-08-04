<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor['nombre']" placeholder="Ingrese su nombre" value="<?php echo sanitizar($vendedor->nombre); ?>">

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor['apellido']" placeholder="Ingrese su apellido" value="<?php echo sanitizar($vendedor->apellido); ?>">

</fieldset>

<fieldset>
    <legend>Informacion de contacto</legend>

    <label for="telefono">Telefono:</label>
    <input type="numbre" id="telefono" name="vendedor['telefono']" placeholder="Ingrese su telefono" value="<?php echo sanitizar($vendedor->telefono); ?>">
    
</fieldset>