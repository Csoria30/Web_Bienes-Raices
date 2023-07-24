<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Guia para la decoracion de tu hogar</h1>
               
        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="Anuncio">
        </picture>

        <p class="informacion-meta" >Escrito el: <span>20/05/2023</span> por: <span>Admin</span> </p>

        <div class="resumen-propiedad">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, voluptatum ratione? Eum laudantium nemo commodi hic doloremque quia fugiat cum excepturi accusantium, tempore, animi quasi sunt nihil minus. Consequuntur, recusandae. Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo illum obcaecati minima harum voluptatibus quae tempore deleniti dolor sapiente voluptatem, ea repellat magni blanditiis hic quas fugit accusantium enim corporis? Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo nostrum dolor maxime optio tempore quis reiciendis nemo consequatur tenetur alias cupiditate libero vero nam, officiis quas tempora! Fugiat, hic nisi?</p>

            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Maiores delectus natus perspiciatis unde fugiat, neque sit cupiditate amet, dolore, aut numquam labore est tenetur minima tempora fugit ut! Ipsam, tempora.
            Pariatur, id? Provident nesciunt ea est cumque minima voluptate molestiae, repudiandae qui veritatis consequuntur laborum vel, quidem pariatur autem ipsam sit et quam? Cupiditate laboriosam, earum labore rerum animi vero.
            Dignissimos, hic omnis officiis voluptatem natus, at minima distinctio quo, modi delectus veritatis! Ullam ut repudiandae mollitia cumque alias, sunt cum obcaecati reprehenderit illo temporibus debitis numquam similique quos ipsum.</p>

        </div>
    </main>

<?php
    incluirTemplate('footer');
?>