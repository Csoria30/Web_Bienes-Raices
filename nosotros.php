<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 años de experiencia
                </blockquote>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam nobis dolores suscipit excepturi quasi? Consequuntur, nostrum dolor aliquid, eaque obcaecati officiis corrupti laborum sequi iste fuga suscipit soluta libero quia.</p>

                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est possimus hic voluptate, corrupti voluptatibus ipsa tenetur nobis modi quis autem quidem quam non repellendus impedit laudantium officiis, maxime excepturi fugiat.</p>
            </div>
        </div><!-- .contenido-nosotros -->

    </main>

    <section class="contenedor seccion">
        <h1>Mas Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa, libero nesciunt voluptates cumque animi dolores explicabo quos, ipsum non odit maxime dicta exercitationem rem nihil quibusdam, impedit voluptatum minus labore.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa, libero nesciunt voluptates cumque animi dolores explicabo quos, ipsum non odit maxime dicta exercitationem rem nihil quibusdam, impedit voluptatum minus labore.</p>
            </div>
        
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa, libero nesciunt voluptates cumque animi dolores explicabo quos, ipsum non odit maxime dicta exercitationem rem nihil quibusdam, impedit voluptatum minus labore.</p>
            </div>

        </div>

    </section>

<?php
    incluirTemplate('footer');
?>