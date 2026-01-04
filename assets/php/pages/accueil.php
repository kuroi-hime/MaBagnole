<!DOCTYPE html>
<html lang="fr">
<?php
    require_once '../classes/Categorie.php';
    require_once '../classes/Vehicule.php';
    require_once '../classes/Reservation.php';
    require_once '../classes/Commentaire.php';
    require_once '../classes/DataBase.php';
    
    session_start();
    $pdo = DataBase::getPDO();

    // --- LOGIQUE DE PAGINATION ---
    // $items_per_page = 6;
    // $page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
    // $offset = ($page - 1) * $items_per_page;

    $view = 'home';
    if(isset($_GET['Catégories']))
        $view = 'categories';
    if(isset($_GET['Voitures']))
        $view = 'voitures';
    if(isset($_GET['MesRéservations']))
        $view = 'reservations';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URDrive - Location de Véhicules</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-gradient {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900 overflow-x-hidden">
    <nav class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 left-0 right-0 z-50 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="bg-blue-600 p-2 rounded-lg">
                <i class="fas fa-car-side text-white text-xl"></i>
            </div>
            <span class="text-2xl font-black tracking-tighter uppercase">Ur<span class="text-blue-600">drive</span></span>
        </div>
        
        <div class="hidden md:flex gap-8 font-semibold text-sm uppercase tracking-wide">
            <a href="accueil.php" class="<?= $view == 'home' ? 'text-blue-600' : 'hover:text-blue-600' ?> transition">Accueil</a>
            <a href="?Catégories" class="<?= $view == 'categories' ? 'text-blue-600' : 'hover:text-blue-600' ?> transition">Catégories</a>
            <a href="?Voitures" class="<?= $view == 'voitures' ? 'text-blue-600' : 'hover:text-blue-600' ?> transition">Voitures</a>
            <a href="?MesRéservations" class="<?= $view == 'reservations' ? 'text-blue-600' : 'hover:text-blue-600' ?> transition">Mes réservation</a>
        </div>

        <div class="flex items-center gap-4 text-sm font-medium">
            <p class="hidden sm:block">Bienvenue, <span class="text-blue-600 font-bold"><?= $_SESSION['name'] ?? 'Invité' ?></span></p>
            <a href="../actions/deconnexion.php" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold shadow-lg hover:bg-blue-700 transition">Déconnexion</a>
        </div>
    </nav>

    <?php if($view == 'home'): ?>
    <section class="relative min-h-screen flex flex-col pt-20 overflow-hidden bg-slate-900">
        <div class="absolute inset-0 hero-gradient opacity-60"></div>
        <div class="relative flex-grow flex flex-col items-center justify-center text-center text-white px-4 z-10">
            <div class="max-w-4xl"> 
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">Roulez vers votre <br><span class="text-blue-500">prochaine aventure</span></h1>
                <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto mb-10">Large sélection de véhicules premium au Maroc. Réservation instantanée et service 24/7.</p>
                <a href="?Voitures" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:scale-105 transition-all shadow-xl">Réserver dès maintenant <i class="fas fa-arrow-right ml-2 text-sm"></i></a>
            </div>
        </div>
    </section>
    <!-- Extrait des catégories -->
    <section class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tight">Parcourez par style</h2>
                <div class="h-1.5 w-20 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <?php $categories = Categorie::allCategories($pdo); $min = min(count($categories), 4);?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-<?= min(count($categories), 4) ?> gap-8">
                <?php foreach($categories as $categorie): ?>
                    <div class="group relative bg-white rounded-3xl p-8 shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div class="mb-5 rounded-2xl bg-blue-50 p-4 w-fit text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i class="fas fa-tags text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2"><?= $categorie->nom_categorie ?></h3>
                        <p class="text-slate-500 leading-relaxed"><?= $categorie->description ?></p>
                        <a href="liste_vehicules.php?cat=<?= $categorie->id_categorie ?>" class="absolute inset-0 z-10" aria-label="Voir <?= $categorie->nom_categorie ?>"></a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-16 text-center">
                <a href="?Catégories" class="px-8 py-3 border-2 border-blue-600 text-blue-600 font-bold rounded-full hover:bg-blue-600 hover:text-white transition-all">
                    Voir plus de catégories
                </a>
            </div>
        </div>
    </section>
    <!-- Top véhicules -->
    <section class="pb-24 bg-slate-50 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <h2 class="text-4xl font-black text-slate-900">MODÈLES VEDETTES</h2>
                    <p class="mt-3 text-slate-600 text-lg">L'excellence automobile à portée de main.</p>
                </div>
                <a href="?Voitures" class="bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                    Voir tout l'inventaire
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all">
                    <div class="relative h-72 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=800" alt="Audi RS" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-black text-blue-600 shadow-sm">DISPONIBLE</div>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-2xl font-bold text-slate-900">Audi RS e-tron GT</h3>
                            <span class="text-blue-600 text-xl font-black">145€<span class="text-xs text-slate-400 font-medium">/j</span></span>
                        </div>
                        <div class="flex gap-6 text-sm text-slate-500 mb-8 font-medium">
                            <span class="flex items-center gap-2"><i class="fas fa-bolt text-blue-500"></i> Électrique</span>
                            <span class="flex items-center gap-2"><i class="fas fa-cog text-blue-500"></i> Auto</span>
                        </div>
                        <a href="#" class="block w-full text-center bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-blue-600 transition-colors">Détails du véhicule</a>
                    </div>
                </div>
                </div>
        </div>
    </section>
    <!-- Avis utilisateurs -->
    <section class="py-24 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-black text-slate-900 mb-4 tracking-tight">VOTRE SATISFACTION, NOTRE PRIORITÉ</h2>
                <div class="flex justify-center text-yellow-400 gap-1 mb-2">
                    <?php for($i=0; $i<5; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                </div>
                <p class="text-slate-500 font-bold uppercase text-sm tracking-widest">Basé sur +1,200 avis vérifiés</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-slate-50 p-10 rounded-[3rem] border border-slate-100 relative">
                    <i class="fas fa-quote-left text-blue-200 text-5xl absolute top-8 left-8 opacity-50"></i>
                    <p class="relative z-10 text-slate-700 leading-relaxed text-lg italic mb-8">
                        "Une expérience d'achat incroyable. L'équipe a été très professionnelle et m'a aidé à trouver la Tesla de mes rêves."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?u=1" alt="Avatar Marc" class="w-14 h-14 rounded-full border-2 border-white shadow-md">
                        <div>
                            <h4 class="font-bold text-slate-900">Marc-Antoine D.</h4>
                            <span class="text-xs text-blue-600 font-bold uppercase tracking-tighter">Client Vérifié</span>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Section catégories -->
    <?php if($view == 'categories'): ?>
    <section class="pt-32 pb-24 px-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tight">Parcourez par style</h2>
                <div class="h-1.5 w-20 bg-blue-600 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <?php $categories = Categorie::allCategories($pdo);  $min = min(count($categories), 4);?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-<?= $min ?> gap-8">
                <?php foreach($categories as $categorie): ?>
                    <div class="max-w-1/3 group relative bg-white rounded-3xl p-8 shadow-sm border border-slate-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div class="mb-5 rounded-2xl bg-blue-50 p-4 w-fit text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i class="fas fa-tags text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2"><?= $categorie->nom_categorie ?></h3>
                        <p class="text-slate-500 leading-relaxed"><?= $categorie->description ?></p>
                        <a href="liste_vehicules.php?cat=<?= $categorie->id_categorie ?>" class="absolute inset-0 z-10" aria-label="Voir <?= $categorie->nom_categorie ?>"></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Section véhicules -->
    <?php if($view == 'voitures'): ?>
    <section class="pt-32 pb-24 px-6 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-black text-slate-900 mb-12 uppercase">
                <?= $view == 'categories' ? 'Toutes les Catégories' : 'Notre Inventaire' ?>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php if($view == 'categories'): 
                    // Exemple de logique pagination pour catégories
                    $all_cats = Categorie::allCategories($pdo); 
                    $display_cats = array_slice($all_cats, $offset, $items_per_page);
                    foreach($display_cats as $cat): ?>
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl transition-all">
                            <h3 class="text-2xl font-bold mb-4"><?= htmlspecialchars($cat->nom_categorie) ?></h3>
                            <p class="text-slate-500 mb-6"><?= htmlspecialchars($cat->description) ?></p>
                            <a href="liste_vehicules.php?cat=<?= $cat->id_categorie ?>" class="text-blue-600 font-bold flex items-center gap-2">Découvrir <i class="fas fa-chevron-right text-xs"></i></a>
                        </div>
                    <?php endforeach; 
                    $total_items = count($all_cats);
                else: 
                    // Exemple de logique pagination pour véhicules
                    // Supposons une méthode Vehicule::getPaginated($pdo, $limit, $offset)
                    $vehs = Vehicule::getPaginated($pdo, $items_per_page, $offset); 
                    foreach($vehs as $veh): ?>
                        <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all">
                            <div class="relative h-64 overflow-hidden">
                                <img src="<?= $veh->image_url ?>" class="w-full h-full object-cover group-hover:scale-110 transition-duration-700">
                                <div class="absolute top-6 left-6 bg-white/90 px-4 py-1.5 rounded-full text-xs font-black text-blue-600">DISPONIBLE</div>
                            </div>
                            <div class="p-8">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-2xl font-bold text-slate-900"><?= htmlspecialchars($veh->modele) ?></h3>
                                    <span class="text-blue-600 text-xl font-black"><?= $veh->prix_journalier ?>€<span class="text-xs text-slate-400">/j</span></span>
                                </div>
                                <a href="details.php?id=<?= $veh->id_vehicule ?>" class="block w-full text-center bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-blue-600 transition-colors">Détails</a>
                            </div>
                        </div>
                    <?php endforeach; 
                    $total_items = Vehicule::countAll($pdo);
                endif; ?>
            </div>

            <div class="flex justify-center mt-16 gap-2">
                <?php 
                $total_pages = ceil($total_items / $items_per_page);
                for($i=1; $i<=$total_pages; $i++): ?>
                    <a href="?<?= $view == 'categories' ? 'Catégories' : 'Voitures' ?>&p=<?= $i ?>" 
                       class="w-12 h-12 flex items-center justify-center rounded-xl font-bold transition-all <?= $page == $i ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white text-slate-600 hover:bg-slate-100' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Section réservations -->
    <?php if($view == 'reservations'): ?>
        <?php 
            $reservations = Reservation::getByClient($pdo, $_SESSION['id']);
        ?>
        <section class="py-24 px-6 bg-slate-50">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-4xl font-black text-slate-900 mb-12">MES RÉSERVATIONS</h2>

                <div class="space-y-6">
                    <?php if(empty($reservations)): ?>
                        <p class="text-center text-slate-500">Vous n'avez aucune réservation.</p>
                    <?php endif; ?>

                    <?php foreach($reservations as $res): ?> 
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row gap-8 items-center">
                            <img src="<?= htmlspecialchars($res->image) ?>" class="w-40 h-28 object-cover rounded-2xl bg-gray-100">

                            <div class="flex-grow">
                                <h3 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($res->modele) ?></h3>
                                <p class="text-sm text-slate-500">
                                    <span class="font-semibold">Départ :</span> <?= date('d/m/Y', strtotime($res->date_debut)) ?><br>
                                    <span class="font-semibold">Durée :</span> <?= $res->duree ?> jours
                                </p>
                                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold 
                                    <?= $res->statut == 'terminer' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' ?>">
                                    <?= strtoupper($res->statut) ?>
                                </span>
                            </div>

                            <div class="w-full md:w-80 border-t md:border-t-0 md:border-l border-slate-100 pt-6 md:pt-0 md:pl-8">
                                
                                <?php if($res->statut == 'terminer'): ?>
                                    
                                    <?php if($res->note): // Déjà commenté ?>
                                        <div class="bg-slate-50 p-4 rounded-2xl">
                                            <div class="flex text-yellow-400 mb-2">
                                                <?php for($i=0; $i<$res->note; $i++): ?><i class="fas fa-star text-xs"></i><?php endfor; ?>
                                            </div>
                                            <p class="text-sm text-slate-600 italic">"<?= htmlspecialchars($res->texte_avis) ?>"</p>
                                        </div>

                                    <?php else: // Formulaire ?>
                                        <form action="../actions/ajouter_avis.php" method="POST" class="space-y-3">
                                            <input type="hidden" name="vehicule_id" value="<?= $res->vehicule_id ?>">
                                            <select name="note" class="w-full text-sm border-none bg-slate-100 rounded-lg p-2" required>
                                                <option value="">Note / 5</option>
                                                <option value="5">5 - Excellent</option>
                                                <option value="4">4 - Très bien</option>
                                                <option value="3">3 - Moyen</option>
                                                <option value="2">2 - Déçu</option>
                                                <option value="1">1 - Horrible</option>
                                            </select>
                                            <textarea name="contenu" placeholder="Votre avis..." class="w-full text-sm bg-slate-100 border-none rounded-xl p-3 h-20" required></textarea>
                                            <button type="submit" class="w-full bg-blue-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-700 transition">PUBLIER</button>
                                        </form>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <p class="text-slate-400 text-sm italic text-center">
                                        <i class="fas fa-lock mr-2"></i>Avis disponible après le trajet
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <footer class="bg-slate-900 text-white py-20 px-6 border-t border-slate-800">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
            <div class="space-y-6">
                <h4 class="text-3xl font-black tracking-tighter">UR<span class="text-blue-500">DRIVE</span></h4>
                <p class="text-slate-400 leading-relaxed">Le leader de la location de voitures premium avec plus de 50 agences à travers le Maroc. Excellence et confort garantis.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center hover:bg-blue-600 transition-all shadow-lg"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center hover:bg-blue-600 transition-all shadow-lg"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="lg:col-span-2 grid grid-cols-2 gap-8">
                <div>
                    <h5 class="font-black text-lg mb-6 uppercase tracking-widest">Navigation</h5>
                    <ul class="text-slate-400 space-y-4 font-medium">
                        <li><a href="#" class="hover:text-blue-500 transition">Accueil</a></li>
                        <li><a href="#" class="hover:text-blue-500 transition">Catalogue</a></li>
                        <li><a href="#" class="hover:text-blue-500 transition">Réservations</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-black text-lg mb-6 uppercase tracking-widest">Contact</h5>
                    <ul class="text-slate-400 space-y-4 font-medium">
                        <li class="flex items-center gap-3"><i class="fas fa-phone text-blue-500"></i> +212 522 00 00 00</li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope text-blue-500"></i> contact@urdrive.ma</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-slate-800 text-center text-slate-500 text-sm">
            &copy; <?= date('Y') ?> URDRIVE Morocco. Tous droits réservés.
        </div>
    </footer>
</body>
</html>