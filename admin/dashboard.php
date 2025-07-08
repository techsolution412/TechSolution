<?php
require_once '../config/DataBase.php';
require_once 'gestionReservation.php';
// session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: acces.php");
    exit;
}
$stmt = $conn->prepare("SELECT * FROM rendezvous WHERE statut != :statut ORDER BY date ASC, heure ASC");
$stmt -> execute([':statut' => 'archive']);
// $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rendezvous = $stmt->fetchAll(PDO::FETCH_ASSOC);


$dateAujourdhui = date('Y-m-d');
$stmt = $conn->query("SELECT COUNT(*) as nombre FROM rendezvous WHERE date = CURDATE() AND statut != 'archive'");
// $stmt->execute([':date_aujourdhui' => $dateAujourdhui]);
$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - TechSolution </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        dark: '#1F2937',
                        light: '#F3F4F6',
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }
        .calendar-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar fixed md:relative w-64 bg-white shadow-md z-10">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-primary flex items-center">
                    <img src="../assets/img/ts.png" alt="techSolution" id="logo" width="50px" height="50px">
                </h1>
                <p class="text-xs text-gray-500 mt-2">Panel Admin</p>
            </div>
            <nav class="p-4">
                <ul>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 text-white bg-primary rounded-lg">
                            <i class="fas fa-calendar-alt mr-3"></i> Rendez-vous
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-users mr-3"></i> Clients
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-chart-line mr-3"></i> Statistiques
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-cog mr-3"></i> Paramètres
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="w-8 h-8 rounded-full mr-2">
                    <div>
                        <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['admin'] )?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <button id="sidebarToggle" class="md:hidden text-gray-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-800">Gestion des Rendez-vous</h2>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-bell"></i>
                    </button>
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-question-circle"></i>
                    </button>
                </div>
            </header>

            <!-- Filters and Actions -->
            <div class="bg-white p-4 mx-4 my-4 rounded-lg shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex flex-col sm:flex-row gap-4 flex-1">
                        <div class="relative flex-1">
                            <input type="text" placeholder="Rechercher un rendez-vous..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        <div class="relative flex-1">
                            <select class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg appearance-none focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                <option value="">Toutes les catégories</option>
                                <option value="consultation">Consultation</option>
                                <option value="development">Développement</option>
                                <option value="meeting">Réunion</option>
                                <option value="support">Support technique</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1">
                            <input type="date" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            <i class="fas fa-calendar-alt calendar-icon text-gray-400"></i>
                        </div>
                        <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filtrer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mx-4 mb-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-primary">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Rendez-vous aujourd'hui</p>
                            <p class="text-2xl font-bold"><?= $resultat['nombre'] ?></p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-calendar-day text-primary text-xl"></i>
                        </div>
                    </div>
                </div>
                <?php 
                $enCours = 0;
                $enAttente = 0;
                $enRetard = 0;
                foreach ($rendezvous as $rdv ){
                  if ($rdv['statut'] == 'en cours') {
                    $enCours +=1;
                  }
                  if ($rdv['statut'] == "en attente") {
                    $enAttente +=1;
                  }
                  if ($rdv['statut'] == "en retard") {
                    $enRetard +=1;
                  }

                }?>
                  
              <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">En cours</p>
                            <p class="text-2xl font-bold"><?= htmlspecialchars($enCours) ?></p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">En attente</p>
                            <p class="text-2xl font-bold"><?= htmlspecialchars($enAttente) ?></p>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="fas fa-clock text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-red-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">En retard</p>
                            <p class="text-2xl font-bold"><?= htmlspecialchars($enRetard) ?></p>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <i class="fas fa-times-circle text-red-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="bg-white mx-4 my-4 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Liste des Rendez-vous</h3>
                    <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Nouveau RDV
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Heure</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"> 
                            <!-- Loop through rendezvous data -->

                          <?php foreach ($rendezvous as $rdv): ?>

                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/75.jpg" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($rdv['nom']) ?></div>
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($rdv['email']) ?></div>
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($rdv['telephone']) ?></div>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        // Définir la couleur selon le service
                                        switch (strtolower($rdv['service'])) {
                                            case 'siteweb':
                                            case 'site vitrine':
                                                $badgeClass = 'bg-blue-100 text-blue-800';
                                                break;
                                            case 'e-commerce':
                                            case 'applicationmobile':
                                                $badgeClass = 'bg-purple-100 text-purple-800';
                                                break;
                                            case 'maintenance':
                                                $badgeClass = 'bg-green-100 text-green-800';
                                                break;
                                            case 'installation':
                                            case "installation des systemes d'exploitation":
                                                $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                break;
                                            default:
                                                $badgeClass = 'bg-gray-100 text-gray-800';
                                        }
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badgeClass ?>">
                                        <?= htmlspecialchars($rdv['service']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $rdv['date'] ?></div>
                                    <div class="text-sm text-gray-500"><?$rdv['heure'] ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    60 min
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                  <?php
                                        // Définir la couleur selon le service
                                        switch (strtolower($rdv['statut'])) {
                                            case 'en cours':
                                                $badgeClass = 'bg-green-100 text-green-800';
                                                break;
                                            case 'en attente':
                                                $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'termine':
                                                $badgeClass = 'bg-gray-100 text-gray-800';
                                                break;
                                            case "en retard":
                                                $badgeClass = 'bg-red-100 text-red-800';
                                                break;
                                            default:
                                                $badgeClass = 'bg-purple-100 text-purple-800';
                                        }
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badgeClass ?>"><?= htmlspecialchars($rdv['statut'])?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-primary hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></button>
                                    <button 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="archiverRendezVous(<?= htmlspecialchars($rdv['id'], ENT_QUOTES) ?>)"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>                                
                                  </td>
                            </tr>
                          <?php endforeach; ?>

                            <!-- <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Jean Martin</div>
                                            <div class="text-sm text-gray-500">jean@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Consultation</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">16 Juin 2023</div>
                                    <div class="text-sm text-gray-500">10:00 - 10:30</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    30 min
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-primary hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></button>
                                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/68.jpg" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Sophie Lambert</div>
                                            <div class="text-sm text-gray-500">sophie@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Support</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">16 Juin 2023</div>
                                    <div class="text-sm text-gray-500">16:00 - 17:00</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    60 min
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmé</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-primary hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></button>
                                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/75.jpg" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">Thomas Leroy</div>
                                            <div class="text-sm text-gray-500">thomas@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Réunion</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">17 Juin 2023</div>
                                    <div class="text-sm text-gray-500">09:00 - 10:30</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    90 min
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Annulé</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-primary hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></button>
                                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <!-- <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Précédent
                        </button>
                        <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Suivant
                        </button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Affichage de <span class="font-medium">1</span> à <span class="font-medium">4</span> sur <span class="font-medium">12</span> résultats
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Précédent</span>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button aria-current="page" class="z-10 bg-primary border-primary text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    1
                                </button>
                                <button class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    2
                                </button>
                                <button class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    3
                                </button>
                                <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Suivant</span>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Sample data for demonstration
        const appointments = [
            {
                id: 1,
                client: {
                    name: "Marie Dupont",
                    email: "marie@example.com",
                    avatar: "https://randomuser.me/api/portraits/women/44.jpg"
                },
                category: "Développement",
                date: "15 Juin 2023",
                time: "14:30 - 15:30",
                duration: "60 min",
                status: "Confirmé",
                statusClass: "bg-green-100 text-green-800"
            },
            // More appointment data would go here
        ];

        // You could use this data to dynamically populate the table
        // For a complete implementation, you would fetch this data from an API
    </script>
    <script>
      function archiverRendezVous(id) {
          if (confirm("Êtes-vous sûr de vouloir supprimer ce rendez-vous ?")) {
              fetch('archiver_rendezvous.php', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/x-www-form-urlencoded',
                  },
                  body: 'id=' + id
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      // Recharger la page ou supprimer la ligne du tableau
                      location.reload();
                  } else {
                      alert("Erreur lors de l'archivage: " + data.message);
                  }
              })
              .catch(error => {
                  console.error('Error:', error);
                  alert("Une erreur est survenue");
              });
          }
      }
    </script>
</body>
</html>