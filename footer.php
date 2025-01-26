<link rel="stylesheet" href="includes/styles.css">

<div class="footer">
    <div class="wrapper">
        <div class="col1">
            <img class="logo" src="imgs/logos/logo.png" alt="LogoFreemaker_soul" class="failory-logo-image">
            <h3>Freemaker Soul®</h3>
            <p>Acredite no seu potencial <br> e conquiste o impossível!</p>
        </div>
        <div class="col2">
            <h3>Quem somos</h3>
            <p>A Freemaker Soul é um projeto recente e<br>
                o seu principal objetivo é disponibilizar um serviço<br>
                de impressão 3D para todos aqueles que desejam<br>
                obter algo diferente do habitual.
            </p>
            <hr>
        </div>
        <div class="col3">
            <h3>Segue-nos!</h3>
            <a class="social" href="https://www.instagram.com/freemaker_soul/" target="_blank">
                <img title="Instagram" src="https://uploads-ssl.webflow.com/5966ea9a9217ca534caf139f/5c8dbfe70fcf5a0514c5b1da_Instagram%20Icon.svg" width="20" alt="Instagram">
            </a>
            <a class="social" href="https://www.facebook.com/FreemakerSoul" target="_blank">
                <img title="Facebook" src="https://uploads-ssl.webflow.com/5966ea9a9217ca534caf139f/5c8dbe42e1e6034fdaba46f6_Facebook%20Icon.svg" width="20" alt="Facebook">
            </a>
            <p>Endereço email:<br>
                <a href="mailto:freemakersoul@gmail.com">
                    <strong class="link-email-footer" title="Freemaker soul email">freemakersoul@gmail.com</strong>
                </a>
            </p>
        </div>
    </div>
    <div class="ft_topBtn ">
        ©Site realizado por André Proença em 2024
        <img src="imgs/icons/arrow_up.png" onclick="topFunction()" id="topBtn" title="Voltar ao topo" alt="Ir para o topo da página">
    </div>
</div>
</body>

</html>


<script>
    let mybutton = document.getElementById("topBtn");

    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0; // Safari
        document.documentElement.scrollTop = 0; // Chrome, Firefox, IE, Opera
    }
</script>