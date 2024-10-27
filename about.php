<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1</title>
</head>
<body>
    <header align="center">
        <h1 class="header__title">Sobre ti</h1>
        <div class="menu_section">
            <nav class="menu__nav">
                <ul class="menu__list" align="left">
                    <li class="menu__item menu__item"><a href="index.html" class="menu__link">Home</a></li>
                    <li class="menu__item menu__item--active"><a href="about.html" class="menu__link">Sobre ti</a></li>
                    <li class="menu__item menu__item"><a href="register.html" class="menu__link">Registro</a></li>
                    <li class="menu__item menu__item"><a href="blog.html" class="menu__link">Blog</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="table_section">
        <table border="1" class="table">
            <caption class="table__caption"><h3>Tabla de usuarios registrados</h3></caption>
            <thead class="table__header">
                <tr class="table__row table__row--header">
                    <th class="table__header--cell">Nombre</th>
                    <th class="table__header--cell">Apellidos</th>
                    <th class="table__header--cell">Teléfono</th>
                    <th class="table__header--cell">Correo electrónico</th>
                    <th class="table__header--cell">Género</th>
                    <th class="table__header--cell">F. Nacimiento</th>
                    <th class="table__header--cell">Cómo nos conoció</th>
                    <th class="table__header--cell">Política de privacidad</th>
                    <th class="table__header--cell">Publicidad</th> 
                </tr>
            </thead>
            <tbody class="table__body">
                <?php
                require_once 'ws/GetUser.php';

                $getUser = new GetUser();
                
                $users = $getUser->getUsers();

                if (!empty($users)) {
                    foreach ($users as $user) {
                        echo "<tr class='table__row table__row--body'>";
                        echo "<td class='table__body--cell'>" . $user->getName() . "</td>";
                        echo "<td class='table__body--cell'>" . $user->getLastName() . "</td>";
                        echo "<td class='table__body--cell'>" . $user->getPhone() . "</td>";
                        echo "<td class='table__body--cell'>" . $user->getEmail() . "</td>";
                        echo "<td class='table__body--cell'>" . $user->getGender() . "</td>";
                        echo "<td class='table__body--cell'>" . $user->getBirthDate()->format('d-m-Y') . "</td>";
                        echo "<td class='table__body--cell'>" . $user->getHowMeetUs() . "</td>";
                        echo "<td class='table__body--cell'>" . ($user->getPrivatePolicy() ? 'True' : 'False') . "</td>";
                        echo "<td class='table__body--cell'>" . ($user->getNewsletter() ? 'True' : 'False') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='table__body--cell'>No se encontraron usuarios.</td></tr>";
                }
                ?>
              </tbody>
        </table>
    </div>
    <footer class="footer">
        <p class="footer__rights">&copy; 2024 Práctica 1 HTML. Todos los derechos reservados.</p>
        <ul class="footer__list">
            <li class="footer__item"><a href="private.html" class="footer__link">Política de privacidad</a></li>
        </ul>
    </footer>
</body>
</html>