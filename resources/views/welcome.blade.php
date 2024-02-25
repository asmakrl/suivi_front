<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Style to make header fixed at the top */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999; /* Ensure header stays on top of other content */
        }

        /* Style to give margin top to content to avoid overlap with fixed header */
        .main-content {
            margin-top: 64px; /* Adjust this value according to your header height */
        }
    </style>
</head>
<body class="antialiased flex flex-col h-screen">

<!-- Header Section -->
<header class="bg-gray-800 text-white py-4 fixed-header w-full">
    <div class="container mx-auto flex justify-between items-center px-4">
        <div class="text-xl font-semibold">منصة متابعة الملفات</div>
    </div>
</header>



<!-- Main Content Section -->
<div class="flex-1 overflow-y-auto main-content">
    <!-- Livewire Component -->
    <livewire:requests-table />
</div>

</body>
</html>
