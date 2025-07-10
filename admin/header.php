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