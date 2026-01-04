<!DOCTYPE html>
<html lang="fr">
    <?php
        require_once '../classes/DataBase.php';
        require_once '../classes/Reservation.php';
        require_once '../classes/Client.php';
        require_once '../classes/Commentaire.php';
        require_once '../classes/Categorie.php';
        require_once '../classes/Vehicule.php';

        session_start();
        $pdo = DataBase::getPDO();
        $tab = $_GET['tab'] ?? 'statistiques';
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard - UrDrive</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    </head>
    <body class="bg-slate-50 flex min-h-screen">
        <!-- Menu latérale -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full">
            <div class="p-6">
                <span class="text-2xl font-black tracking-tighter uppercase text-white">Ur<span class="text-blue-500">drive</span></span>
                <p class="text-xs text-slate-400 mt-1 uppercase font-bold tracking-widest">Admin Panel</p>
            </div>

            <nav class="flex-grow mt-6 px-4 space-y-2">
                <a href="?tab=statistiques" class="flex items-center gap-3 p-3 rounded-xl transition <?= $tab == 'statistiques' ? 'bg-blue-600' : 'hover:bg-slate-800' ?>">
                    <i class="fas fa-chart-pie w-6"></i> Statistiques
                </a>
                <a href="?tab=clients" class="flex items-center gap-3 p-3 rounded-xl transition <?= $tab == 'clients' ? 'bg-blue-600' : 'hover:bg-slate-800' ?>">
                    <i class="fas fa-users w-6"></i> Clients
                </a>
                <a href="?tab=categories" class="flex items-center gap-3 p-3 rounded-xl transition <?= $tab == 'categories' ? 'bg-blue-600' : 'hover:bg-slate-800' ?>">
                    <i class="fas fa-layer-group w-6"></i> Catégories
                </a>
                <a href="?tab=voitures" class="flex items-center gap-3 p-3 rounded-xl transition <?= $tab == 'voitures' ? 'bg-blue-600' : 'hover:bg-slate-800' ?>">
                    <i class="fas fa-car w-6"></i> Voitures
                </a>
                <a href="?tab=reservations" class="flex items-center gap-3 p-3 rounded-xl transition <?= $tab == 'reservations' ? 'bg-blue-600' : 'hover:bg-slate-800' ?>">
                    <i class="fas fa-calendar-check w-6"></i> Réservations
                </a>
                <a href="?tab=commentaires" class="flex items-center gap-3 p-3 rounded-xl transition <?= $tab == 'commentaires' ? 'bg-blue-600' : 'hover:bg-slate-800' ?>">
                    <i class="fas fa-comments w-6"></i> Commentaires
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <a href="../actions/deconnexion.php" class="flex items-center gap-3 p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition">
                    <i class="fas fa-sign-out-alt w-6"></i> Déconnexion
                </a>
            </div>
        </aside>
        <!-- Contenu -->
        <main class="ml-64 flex-grow p-10">
            <!-- section statistiques -->
            <?php if($tab == 'statistiques'): ?>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <p class="text-slate-500 text-sm font-bold uppercase">Réservations</p>
                        <h3 class="text-3xl font-black text-slate-900 mt-2"><?= count(Reservation::allReservations($pdo)); ?></h3>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <p class="text-slate-500 text-sm font-bold uppercase">Clients Actifs</p>
                        <h3 class="text-3xl font-black text-blue-600 mt-2"><?= Client::actifsClients($pdo); ?></h3>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <p class="text-slate-500 text-sm font-bold uppercase">Véhicules</p>
                        <h3 class="text-3xl font-black text-slate-900 mt-2"><?= Vehicule::countVehicules($pdo); ?></h3>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <p class="text-slate-500 text-sm font-bold uppercase">Revenus(MAD)</p>
                        <h3 class="text-3xl font-black text-green-600 mt-2"><?= Reservation::revenu($pdo); ?></h3>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($tab == 'clients'): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                        <h2 class="text-xl font-bold">Gestion des Clients</h2>
                        <input type="text" placeholder="Rechercher..." class="bg-slate-100 border-none rounded-xl px-4 py-2 text-sm">
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Nom</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php 
                            // Simulation de données
                            $clients = Client::allClients($pdo);
                            foreach($clients as $client): ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-bold"><?= $client->getNom() ?></td>
                                <td class="px-6 py-4 text-slate-500"><?= $client->getEmail() ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black <?= $client->statut ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                                        <?= $client->statut ? 'ACTIF' : 'BLOQUÉ' ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="../actions/changerStatutClient.php" method="POST">
                                        <input type="hidden" name="id_user" value="<?= $client->getId() ?>">
                                        <button name="action" type="submit" class="text-sm font-bold <?= $client->statut ? 'text-red-600' : 'text-green-600' ?>">
                                            <?= $client->statut ? 'Bloquer' : 'Débloquer' ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            
            <?php if($tab == 'categories'): ?>
            <?php endif; ?>
             
            <?php if($tab == 'voitures'): ?>
            <?php endif; ?>

            <?php if($tab == 'reservations'): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50">
                        <h2 class="text-xl font-bold">Suivi des Réservations</h2>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Client</th>
                                <th class="px-6 py-4">Véhicule</th>
                                <th class="px-6 py-4">Date Début</th>
                                <th class="px-6 py-4">Durée</th>
                                <th class="px-6 py-4">Statut</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php 
                                $allRes = Reservation::allReservations($pdo);
                                foreach($allRes as $res):
                                    $currentVoiture = Vehicule::getById($pdo, $res->vehicule_id);
                                    $currentClient = Client::getById($res->client_id, $pdo);
                            ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-bold"><?= $currentClient->getNom() ?></td>
                                <td class="px-6 py-4"><?= $currentVoiture->modele ?></td>
                                <td class="px-6 py-4"><?= $res->date_debut ?></td>
                                <td class="px-6 py-4"><?= $res->duree ?> jours</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black 
                                        <?= $res->statut == 'Confirmée' ? 'bg-green-100 text-green-600' : ($res->statut == 'Annulée' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600') ?>">
                                        <?= $res->statut ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <?php if($res->statut == 'En attente'): ?>
                                        <form action="../actions/admin_actions.php" method="POST" class="inline">
                                            <input type="hidden" name="id_res" value="<?= $res->id_reservation ?>">
                                            <button name="action" value="valider" class="text-green-600 hover:text-green-800 font-bold text-sm">Approuver</button>
                                        </form>
                                        <form action="../actions/admin_actions.php" method="POST" class="inline">
                                            <input type="hidden" name="id_res" value="<?= $res->id_reservation ?>">
                                            <button name="action" value="annuler" class="text-red-600 hover:text-red-800 font-bold text-sm">Refuser</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <?php if($tab == 'commentaires'): ?>
                <div class="grid grid-cols-1 gap-4">
    <?php 
    $commentaires = Commentaire::allCommentaires($pdo);
    foreach($commentaires as $com): ?>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 flex justify-between items-center shadow-sm">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="font-bold"><?= $com->nom_client ?></span>
                <span class="text-slate-400 text-xs">sur <?= $com->modele_vehicule ?></span>
                <span class="text-yellow-400 text-xs ml-2">
                    <i class="fas fa-star"></i> <?= $com->note ?>/5
                </span>
                <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-500 uppercase">
                    <?= $com->statut ?>
                </span>
            </div>
            <p class="text-slate-600 italic">"<?= $com->contenu ?>"</p>
            <p class="text-[10px] text-slate-400 mt-2"><?= $com->date_commentaire ?></p>
        </div>
        <?php if($com->statut != 'deleted'): ?>
        <div class="flex gap-2">
            <form action="../actions/admin_actions.php" method="POST">
                <input type="hidden" name="id_com" value="<?= $com->id_commentaire ?>">
                <button name="action" value="delete_com" class="bg-red-50 text-red-600 p-3 rounded-xl hover:bg-red-600 hover:text-white transition">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
            <?php endif; ?>

        </main>
    </body>
</html>