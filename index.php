<?php
include_once 'config/DataBase.php';
 $messageConfirm = "";
// Récupération des services depuis la base de données
$sql = "SELECT * FROM services";
$stmt = $conn->prepare($sql);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSolutions - Votre Partenaire Informatique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body class="font-sans antialiased text-gray-800">
    <header class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-indigo-600">Tech<span class="text-gray-800">Solutions</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="nav-link text-gray-800 hover:text-indigo-600">Accueil</a>
                    <a href="#services" class="nav-link text-gray-800 hover:text-indigo-600">Services</a>
                    <a href="#projects" class="nav-link text-gray-800 hover:text-indigo-600">Projets</a>
                    <a href="#about" class="nav-link text-gray-800 hover:text-indigo-600">À Propos</a>
                    <a href="#contact" class="nav-link text-gray-800 hover:text-indigo-600">Contact</a>
                </div>
                <button class="md:hidden focus:outline-none" id="menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div class="md:hidden hidden mt-4" id="mobile-menu">
                <a href="#home" class="block py-2 text-gray-800 hover:text-indigo-600">Accueil</a>
                <a href="#services" class="block py-2 text-gray-800 hover:text-indigo-600">Services</a>
                <a href="#projects" class="block py-2 text-gray-800 hover:text-indigo-600">Projets</a>
                <a href="#about" class="block py-2 text-gray-800 hover:text-indigo-600">À Propos</a>
                <a href="#contact" class="block py-2 text-gray-800 hover:text-indigo-600">Contact</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-20 gradient-bg text-white">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Solutions Informatiques sur Mesure</h1>
                <p class="text-xl mb-8">Nous transformons vos idées en solutions technologiques innovantes pour
                    propulser votre entreprise vers l'avenir.</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#contact"
                        class="bg-white text-indigo-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition duration-300 text-center">Demander
                        un devis</a>
                    <a href="#services"
                        class="border-2 border-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-indigo-600 transition duration-300 text-center">Nos
                        services</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="https://cdn-icons-png.flaticon.com/512/3242/3242257.png" alt="Hero Image"
                    class="w-3/4 animate-float">
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Nos Services Experts</h2>
                <div class="w-20 h-1 bg-indigo-600 mx-auto mb-6"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">Nous offrons une gamme complete de services informatiques
                    pour repondre à tous vos besoins technologiques.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg transition duration-500 card-hover">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-code text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Developpement Web</h3>
                    <p class="text-gray-600">Creation de sites web et applications sur mesure</p>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg transition duration-500 card-hover">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-mobile-alt text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Applications Mobiles</h3>
                    <p class="text-gray-600">Developpement d'applications Android natives pour atteindre vos clients
                        partout.</p>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg transition duration-500 card-hover">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-shield-alt text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">maintenance Informatique</h3>
                    <p class="text-gray-600">Protection de vos donnees et maintenance de votre Pc</p>
                </div>

                <!-- Service 4 -->
                <div class="bg-white p-8 rounded-xl shadow-lg transition duration-500 card-hover">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-database text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Bases de Donnees</h3>
                    <p class="text-gray-600">Conception, optimisation et maintenance de bases de donnees pour une
                        gestion efficace de vos informations.</p>
                </div>

                <!-- Service 5 -->
                <div class="bg-white p-8 rounded-xl shadow-lg transition duration-500 card-hover">
                    <div class="text-indigo-600 mb-4">
                        <i class="fas fa-headset text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Support Technique</h3>
                    <p class="text-gray-600">Assistance technique 24/7 pour resoudre vos problemes informatiques
                        rapidement et efficacement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->


    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Notre Histoire</h2>
                    <div class="w-20 h-1 bg-indigo-600 mb-6"></div>
                    <p class="text-gray-600 mb-6">Fondee en 2025 par deux passionnés de technologie, TechSolutions est
                        nee de la volonté d'apporter des solutions informatiques innovantes et accessibles aux
                        entreprises de toutes tailles.</p>
                    <p class="text-gray-600 mb-6">Notre équipe est composée d'experts dans divers domaines de
                        l'informatique, unis par une même passion pour la technologie et l'innovation.</p>
                    <div class="flex items-center space-x-4">
                    </div>
                </div>
                <div class="md:w-1/2">
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h3 class="text-xl font-bold mb-4">Notre Approche</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="text-indigo-600 mt-1 mr-4">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Écoute Active</h4>
                                    <p class="text-gray-600 text-sm">Nous prenons le temps de comprendre vos besoins
                                        spécifiques avant de proposer des solutions.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="text-indigo-600 mt-1 mr-4">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Solutions Sur Mesure</h4>
                                    <p class="text-gray-600 text-sm">Pas de solutions préfabriquées, nous créons des
                                        outils adaptés à votre entreprise.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="text-indigo-600 mt-1 mr-4">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Support Continu</h4>
                                    <p class="text-gray-600 text-sm">Nous restons à vos côtés après la livraison pour
                                        assurer le bon fonctionnement de vos solutions.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="text-indigo-600 mt-1 mr-4">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Innovation Constante</h4>
                                    <p class="text-gray-600 text-sm">Nous suivons les dernières tendances technologiques
                                        pour vous offrir des solutions d'avenir.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Contactez-Nous</h2>
                <div class="w-20 h-1 bg-indigo-600 mx-auto mb-6"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">Prêt à transformer votre idée en réalité? Remplissez le
                    formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.</p>
            </div>

            <div class="flex flex-col md:flex-row">
                <div class="container">
                    <form method="POST" class="space-y-6" id="contactForm">
                        <input type="text" name="nom" id="Nom"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                            placeholder="Votre nom complet" required>
                        <input type="email" name="email" id="Email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                            placeholder="Votre email" required>
                        <input type="text" name="telephone" placeholder="Téléphone" id="telephone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                            required>
                        <input type="date" name="date" required>
                        <input type="time" name="heure" required>
                        <select name="service" id="Services"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                            required>
                            
                            <?php foreach($services as $service) : ?>
                                <option value='<?=$service['id']?>'><?=$service['nom']?></option>";
                            <?php endforeach ?>
                            <!-- <option value="SiteWeb">SiteVitrine</option>
                            <option value="applicatonMobile">ApplicationMobile</option>
                            <option value="E-commerce">Site E-commerce</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Installation">Installation des systemes d'exploitation</option> -->
                        </select>
                        <textarea name="message" id="Message" rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                            placeholder="Laissez un message (facultatif)" rows="4"></textarea>
                        
                        <div id="messageConfirm" class=" "></div>
                        
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">Réserver</button>
                    </form>
                </div>

                <div class="md:w-1/2">
                    <div class="bg-gray-50 p-8 rounded-xl h-full">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Informations de Contact</h3>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="text-indigo-600 mt-1 mr-4">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">phone</h4>
                                    <p class="text-gray-600">+221 70 234 67 89</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="text-indigo-600 mt-1 mr-4">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Email</h4>
                                    <p class="text-gray-600">contact@techsolutions.fr</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="text-indigo-600 mt-1 mr-4">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Heures d'Ouverture</h4>
                                    <p class="text-gray-600">Lundi - Vendredi: 9h - 18h</p>
                                    <!-- <p class="text-gray-600">Samedi: 10h - 14h</p> -->
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h4 class="font-semibold text-gray-800 mb-4">Suivez-Nous</h4>
                            <div class="flex space-x-4">
                                <a href="#" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                                <a href="#" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="text-2xl font-bold text-white mb-4">Tech<span class="text-indigo-400">Solutions</span>
                    </div>
                    <p class="text-gray-400">Votre partenaire technologique pour des solutions innovantes et sur mesure.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Développement Web</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Applications Mobiles</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Solutions Cloud</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Sécurité Informatique</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens Utiles</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition">Accueil</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition">À Propos</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="#projects" class="text-gray-400 hover:text-white transition">Projets</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                            <span>123 Rue de la Technologie, 75000 Paris</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3"></i>
                            <span>+33 1 23 45 67 89</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3"></i>
                            <span>contact@techsolutions.fr</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">© 2023 TechSolutions. Tous droits réservés.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <script src="assets/script.js"></script>
    <script src="assets/traitement.js"></script>
</body>

</html>