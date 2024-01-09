<?php
    require_once("templates/header.php");

    require_once("dao/UserDAO.php");

    $userDAO = new UserDAO($conn, $BASE_URL);

    $userData = $userDAO->verificToken(true);
?>
<body>
    <div id="main-container" class="container-fluid">
        <h1>Edição de Perfil</h1>
    </div>
</body>
</html>
<?php
    require_once("templates/footer.php");
?>