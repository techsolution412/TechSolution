<?php
require_once '../config/DataBase.php';
require_once 'gestionReservation.php';
// session_start();
$erreurs = [];
$reservation = null;
if (!isset($_SESSION['admin'])) {
    header("Location: acces.php");
    exit;
}

if(!isset($_GET['id'])){
    $erreurs[] = "Aucun identifiant de réservation fourni.";
}else{
    $idReservation = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM rendezvous WHERE id = :id");
    $stmt->bindParam(':id', $idReservation, PDO::PARAM_INT);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

}
require_once "header.php";

?> 



        <!-- Reservation Card -->
        <div class="p-2">
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Réservation #R<?= htmlspecialchars($reservation['id'])?></h2>
                    <?php
                        // Définir la couleur selon le service
                        switch (strtolower($reservation['statut'])) {
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
                    <span class="<?=$badgeClass?> text-xs font-medium px-2.5 py-0.5 rounded-full"><?= htmlspecialchars($reservation['statut'])?></span>
                </div>

                <!-- Form Section -->
                <div class="mt-4">
                        <div id="messageConfirm" class=" "></div>
                </div>
                <form method="POST" id="updateForm" class="space-y-6">
                    <!-- Client Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informations Client</h3>
                            
                            <div class="mb-4">
                                <label for="clientName" class="block mb-2 text-sm font-medium text-gray-900">Nom complet</label>
                                <input type="text" id="clientName" name="nom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($reservation['nom'])?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="clientEmail" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                <input type="email" id="clientEmail" name="email"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($reservation['email'])?>" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="clientPhone" class="block mb-2 text-sm font-medium text-gray-900">Téléphone</label>
                                <input type="tel" id="clientPhone" name="telephone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($reservation['telephone'])?>" required>
                            </div>
                            
                            <div>
                                <label for="clientNotes" class="block mb-2 text-sm font-medium text-gray-900">Message</label>
                                <textarea id="clientNotes" rows="2" name="message" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"><?= htmlspecialchars($reservation['message'])?></textarea>
                            </div>
                            
                        </div>

                        <!-- Reservation Details -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Détails de la Réservation</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['id']) ?>">
                                <div>
                                    <label for="reservationDate" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                                    <input type="date" id="reservationDate" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($reservation['date'])?>" required>
                                </div>
                                
                                <div>
                                    <label for="reservationTime" class="block mb-2 text-sm font-medium text-gray-900">Heure</label>
                                    <input type="time" id="reservationTime" name="heure" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($reservation['heure'])?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="reservationService" class="block mb-2 text-sm font-medium text-gray-900">Service</label>
                                <select id="reservationService" name="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 custom-select">
                                    <option value="SiteWeb">SiteVitrine</option>
                                    <option value="applicatonMobile">ApplicationMobile</option>
                                    <option value="E-commerce">Site E-commerce</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Installation">Installation des systemes d'exploitation</option>

                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="reservationStatus" class="block mb-2 text-sm font-medium text-gray-900">Statut</label>
                                <select id="reservationStatus" name="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 custom-select">
                                    <option value="en cours">en cours</option>
                                    <option value="en attente">En attente</option>
                                    <option value="termine">Terminée</option>
                                    <option value="en retard">En retard</option>

                                </select>
                            </div>

                            
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t">
                        <button type="button" id="cancelBtn" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 transition duration-300">
                            Annuler les modifications
                        </button>
                        <button type="submit" id="saveBtn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center animate-pulse transition duration-300">
                            <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                        </button>
                    </div>

                    
                </form>
            </div>
        </div>

        <!-- History Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Historique des modifications</h3>
                
                <div class="relative">
                    <!-- Timeline -->
                    <div class="border-l-2 border-gray-200 pl-8 pb-8 space-y-8">
                        <!-- Timeline Item -->
                        <div class="relative">
                            <div class="absolute -left-3.5 top-1 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">Réservation créée</p>
                                    </div>
                                    <span class="text-xs text-gray-500"><?=htmlspecialchars($reservation['dateCreation'])?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Timeline Item -->
                        <div class="relative">
                            <div class="absolute -left-3.5 top-1 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-pen text-white text-xs"></i>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">Modification de l'heure</p>
                                        <p class="text-sm text-gray-500">De: 19:00 à 19:30</p>
                                        <p class="text-sm text-gray-500">Par: Jean Dupont (client)</p>
                                    </div>
                                    <span class="text-xs text-gray-500">20 Nov 2023, 14:15</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Timeline Item -->
                        <div class="relative">
                            <div class="absolute -left-3.5 top-1 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-xs"></i>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900">Ajout d'une note</p>
                                        <p class="text-sm text-gray-500">"Client a demandé une place près de la fenêtre"</p>
                                        <p class="text-sm text-gray-500">Par: Marie Martin</p>
                                    </div>
                                    <span class="text-xs text-gray-500">22 Nov 2023, 09:45</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
    <!-- Help Modal -->
    <div id="helpModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none modal-transition">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform translate-y-4 modal-transition">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Aide - Modification de réservation</h3>
                    <button id="closeHelpModal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2"><i class="fas fa-info-circle text-blue-500 mr-2"></i>Informations client</h4>
                        <p class="text-sm text-gray-600">Vous pouvez modifier les informations de contact du client. Assurez-vous que l'email et le téléphone sont valides.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2"><i class="fas fa-calendar-alt text-blue-500 mr-2"></i>Date et heure</h4>
                        <p class="text-sm text-gray-600">Modifiez la date et l'heure de la réservation. Le système vérifiera automatiquement la disponibilité.</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2"><i class="fas fa-utensils text-blue-500 mr-2"></i>Préférences</h4>
                        <p class="text-sm text-gray-600">Indiquez les préférences du client concernant la table et les besoins spéciaux.</p>
                    </div>
                </div>
                <div class="mt-6">
                    <button id="closeHelpModalBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">
                        J'ai compris
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 pointer-events-none modal-transition">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform translate-y-4 modal-transition">
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600 text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 text-center mb-2">Modifications enregistrées</h3>
                <p class="text-sm text-gray-600 text-center mb-6">Les modifications de la réservation #RDV-2023-0587 ont été enregistrées avec succès.</p>
                <div class="flex space-x-4">
                    <button id="viewReservationBtn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">
                        Voir la réservation
                    </button>
                    <button id="closeConfirmationModalBtn" class="flex-1 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 py-2 px-4 rounded-lg transition duration-300">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <cript src="assets/scripts/script.js"></script>
    <script src="assets/scripts/traitement.js"></script>

</body>
</html>