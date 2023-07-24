<?php
    require '../../includes/config/database.php';

    conectarDB();

    require '../../includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear Propiedad</h1>

        <form class="formulario">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo<label>
                <input type="text" id="titulo" placeholder="Titulo de la propiedad">

                <label for="precio">Precio<label>
                <input type="number" id="precio" placeholder="Precio de la propiedad">

                <label for="imagen">Imagen<label>
                <input type="file" id="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripcion<label>
                <textarea id="descripcion"></textarea>
            </fieldset>
            
            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones<label>
                <input type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9">

                <label for="wc">Baños<label>
                <input type="number" id="wc" placeholder="Ej: 3" min="1" max="9">

                <label for="estacionamiento">Estacionamiento<label>
                <input type="number" id="estacionamiento" placeholder="Ej: 3" min="1" max="9">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select>
                    <option value="1">Juan</option>
                    <option value="2">Carla</option>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

        <a href="/admin" class="boton boton-verde">Volver</a>
    </main>

<?php
    incluirTemplate('footer');
?>