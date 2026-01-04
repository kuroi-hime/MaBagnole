<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Authentification - DriveSelect</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Montserrat', sans-serif; }

        /* Animation pour le basculement desktop */
        @keyframes move {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }
        .animate-move { animation: move 0.6s; }

        /* Masquer le panneau latéral sur mobile */
        @media (max-width: 767px) {
            .toggle-container { display: none; }
            .form-container { width: 100% !important; position: relative !important; opacity: 1 !important; z-index: 1 !important; }
            .container.active .sign-in { display: none; }
            .container:not(.active) .sign-up { display: none; }
        }
    </style>
</head>

<body class="bg-[#c9d6ff] bg-gradient-to-r from-[#e2e2e2] to-[#c9d6ff] flex flex-col items-center justify-center min-h-screen p-4">

    <div class="container relative overflow-hidden w-full max-w-[768px] min-h-[500px] bg-white rounded-[30px] shadow-[0_5px_15px_rgba(0,0,0,0.35)]" id="container">
        
        <div class="form-container sign-up absolute top-0 h-full transition-all duration-600 ease-in-out left-0 w-full md:w-1/2 opacity-0 z-[1] 
                    [.container.active_&]:md:translate-x-full [.container.active_&]:opacity-100 [.container.active_&]:z-[5] [.container.active_&]:animate-move">
            <form action="../actions/addUser.php" method="post" class="bg-white flex flex-col items-center justify-center px-8 md:px-10 h-full">
                <h1 class="text-2xl font-bold mb-3">Créer un compte</h1>
                <span class="text-xs text-gray-500 mb-3">Utilisez votre email pour l'inscription</span>
                <input type="text" name="nom" placeholder="Nom complet" class="bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none">
                <input type="text" name="email" placeholder="Email" class="bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none">
                <input type="password" name="password" placeholder="Mot de passe" class="bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none">
                <div class="flex gap-2 w-full">
                    <input type="text" name="telephone" placeholder="Téléphone" class="md:w-2/3 bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none">
                    <input type="text" name="cin" placeholder="CIN" class="md:w-1/3 bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none">
                </div>
                <div class="flex gap-2 w-full">
                    <input type="text" name="adresse" placeholder="Adresse" class="md:w-2/3 bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none">
                    <input type="text" name="ville" placeholder="Ville" class="md:w-1/3 bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none">
                </div>
                <button class="bg-[#2da0a8] text-white text-xs py-3 px-11 border border-transparent rounded-lg font-semibold uppercase tracking-wider mt-4 cursor-pointer transition active:scale-95">S'inscrire</button>
                
                <button type="button" class="md:hidden mt-4 text-sm text-[#2da0a8] font-bold" id="dejaCompte">
                    Déjà un compte ? Se connecter
                </button>
            </form>
        </div>

        <div class="form-container sign-in absolute top-0 h-full transition-all duration-600 ease-in-out left-0 w-full md:w-1/2 z-[2]
                    [.container.active_&]:md:translate-x-full">
            <form action="../actions/userLogin.php" method="post" class="bg-white flex flex-col items-center justify-center px-8 md:px-10 h-full">
                <h1 class="text-2xl font-bold mb-4">Connexion</h1>
                <span class="text-xs text-gray-500 mb-4">Entrez vos identifiants</span>
                <input type="email" name="email" placeholder="Email" class="bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none" />
                <input type="password" name="password" placeholder="Mot de passe" class="bg-[#eee] border-none my-2 p-3 text-sm rounded-lg w-full outline-none mb-4" />
                <button class="bg-[#2da0a8] text-white text-xs py-3 px-11 border border-transparent rounded-lg font-semibold uppercase tracking-wider cursor-pointer transition active:scale-95">Se connecter</button>
                
                <button type="button" class="md:hidden mt-4 text-sm text-[#2da0a8] font-bold" id="creerCompte">
                    Pas de compte ? Créer un compte
                </button>
            </form>
        </div>

        <div class="toggle-container absolute top-0 left-1/2 w-1/2 h-full overflow-hidden transition-all duration-600 ease-in-out z-[1000] rounded-l-[150px]
                    [.container.active_&]:-translate-x-full [.container.active_&]:rounded-l-none [.container.active_&]:rounded-r-[150px]">
            
            <div class="toggle bg-[#2da0a8] bg-gradient-to-r from-[#5c6bc0] to-[#2da0a8] text-white relative -left-full h-full w-[200%] translate-x-0 transition-all duration-600 ease-in-out
                        [.container.active_&]:translate-x-1/2">
                
                <div class="toggle-panel toggle-left absolute w-1/2 h-full flex flex-col items-center justify-center px-8 text-center top-0 transition-all duration-600 ease-in-out -translate-x-full
                            [.container.active_&]:translate-x-0">
                    <h1 class="text-2xl font-bold">Heureux de vous revoir !</h1>
                    <p class="text-sm my-5">Connectez-vous pour accéder à toutes les fonctionnalités de votre compte.</p>
                    <button class="bg-transparent border-white border text-white text-xs py-2.5 px-11 rounded-lg font-semibold uppercase tracking-wider cursor-pointer mt-2" id="login">Connexion</button>
                </div>

                <div class="toggle-panel toggle-right absolute w-1/2 h-full flex flex-col items-center justify-center px-8 text-center top-0 right-0 transition-all duration-600 ease-in-out translate-x-0
                            [.container.active_&]:translate-x-full">
                    <h1 class="text-2xl font-bold">Bonjour !</h1>
                    <p class="text-sm my-5">Inscrivez-vous pour commencer l'aventure avec URDRIVE.</p>
                    <button class="bg-transparent border-white border text-white text-xs py-2.5 px-11 rounded-lg font-semibold uppercase tracking-wider cursor-pointer mt-2" id="register">Inscription</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/authentification.js"></script>
</body>
</html>