<?php
require_once '../config/DataBase.php';
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (!isset($_SESSION['admin'])) {
    header("Location: acces.php");
    exit;
}

$conditions = ["statut != 'archive'"];
$params = [];

if (!empty($_GET['search'])) {
    $conditions[] = "(rdv.nom LIKE :search OR rdv.email LIKE :search OR rdv.telephone LIKE :search OR rdv.statut LIKE :search)";
    $params[':search'] = '%' . $_GET['search'] . '%';
}
if (!empty($_GET['categorie'])) {
    $conditions[] = "srv.nom = :categorie";
    $params[':categorie'] = $_GET['categorie'];
}
if (!empty($_GET['date'])) {
    $conditions[] = "rdv.date = :date";
    $params[':date'] = $_GET['date'];
}




$log = $conn ->query("SELECT * FROM connexions_admin ORDER BY date_connexion DESC");
$acces_log = $log ->fetchAll(PDO::FETCH_ASSOC);
require_once 'header.php';

$where = '';
// Requête adaptée à la table `Clients` dans la base Host (respect de la casse)
$params = [];
$sql = "SELECT IdClients AS id, NomClients AS nom, NumeroClients AS numero, Email AS email, Montant AS montant, MontantPaye AS montant_paye, MontantRestant AS montant_restant FROM Clients";
if (!empty($_GET['search'])) {
    $sql .= " WHERE NomClients LIKE :search OR Email LIKE :search OR NumeroClients LIKE :search";
    $params[':search'] = '%' . $_GET['search'] . '%';
}
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
                    
               <!-- Filters and Actions -->
            <div class="bg-white p-4 mx-4 my-4 rounded-lg shadow-sm">
                <form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <div class="flex flex-col sm:flex-row gap-4 flex-1">
                        <div class="relative flex-1">
                            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Rechercher un rendez-vous..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        <div class="relative flex-1">
                            <select name="categorie" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg appearance-none focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                <option value="">Toutes les catégories</option>
                                <option value="site vitrine" <?= (($_GET['categorie'] ?? '') == 'site vitrine') ? 'selected' : '' ?>>Site vitrine</option>
                                <option value="e-commerce" <?= (($_GET['categorie'] ?? '') == 'e-commerce') ? 'selected' : '' ?>>E-commerce</option>
                                <option value="maintenance" <?= (($_GET['categorie'] ?? '') == 'maintenance') ? 'selected' : '' ?>>Maintenance</option>
                                <option value="installation" <?= (($_GET['categorie'] ?? '') == 'installation') ? 'selected' : '' ?>>Installation OS</option>
                                <option value="Logiciel Bureau" <?= (($_GET['categorie'] ?? '') == 'Logiciel Bureau') ? 'selected' : '' ?>>Logiciel Bureau</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-1">
                            <input type="date" name="date" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            <i class="fas fa-calendar-alt calendar-icon text-gray-400"></i>
                        </div>
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filtrer
                        </button>
                        <a href="dashboard.php" class="bg-red-200 text-red-700 px-4 py-2 rounded-lg hover:bg-red-300 transition flex items-center">
                            <i class="fas fa-times mr-2"></i> Supprimer les filtres
                        </a>
                    </div>
                </form>
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
                    <h3 class="font-semibold text-gray-800">Liste des Clients</h3>
                    <button class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition flex items-center">
                        <a href="new_clients.php"><i class="fas fa-plus mr-2"></i> Nouveau Clients</a>
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Nom Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Numero Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">	Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">	Montant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">	Montant Paye</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">	Montant Restant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                          <?php foreach ($clients as $client): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-8 h-8 rounded-full mr-2"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($client['nom']) ?></div>
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($client['email']) ?></div>
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($client['numero']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($client['numero']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($client['email']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= number_format($client['montant'], 0, ',', ' ') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= number_format($client['montant_paye'], 0, ',', ' ') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= number_format($client['montant_restant'], 0, ',', ' ') ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="modifier_client.php?id=<?= htmlspecialchars($client['id'], ENT_QUOTES) ?>" class="text-primary hover:text-indigo-900 mr-3"><i class="fas fa-edit"></i></a>
                                    <button class="text-red-600 hover:text-red-900" onclick="if(confirm('Archiver ce client ?')) window.location.href='archiver_client.php?id=<?= htmlspecialchars($client['id'], ENT_QUOTES) ?>'"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                          <?php endforeach; ?>
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