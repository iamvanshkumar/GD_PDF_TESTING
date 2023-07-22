<!DOCTYPE html>
<html>

<head>
    <title>PDF File Display</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <style>
        .container {
            width: 500px;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            font-size: 24px;
        }
    </style>


<script src="./script.js"></script>
</head>

<body>
    <div class="container">
        <h1>PDF File Display</h1>
        <div class="grid grid-cols-3 gap-2 rounded-md shadow-md hover:shadow-lg bg-white dark:bg-gray-800 p-2 h-38 duration-300">
            <div class="border-r pr-2 flex justify-center items-center">
                <div id="pdf-img" class="pdf-container"></div>
            </div>
            <div class="col-span-2 flex-col flex justify-between">
                <a onclick="openNote(7,'Software Engg. Handwritten Notes pdf download free')">
                    <h6 class="text-gray-600 amber-hover-text font-bold text-md">
                        Software Engg. Handwritten Notes pdf download free </h6>
                </a>
                <div class="block">
                    <span class="amber uppercase text-white px-1 text-xs">
                        Data Structures </span>
                </div>
                <div class="flex justify-between uppercase font-medium items-center text-sm ">
                    <span class="text-gray-500">
                        BSC IT </span>
                    <span id="paid" class="my-1 px-2 text-white ">
                        paid </span>
                </div>
                <div class="flex justify-between items-center text-gray-400 uppercase text-sm ">
                    <span class="">
                        <i class="bx bx-calendar"></i>
                        2023-07-17 </span>
                    <span class="">
                        <i class="bx bx-bar-chart"></i>
                        10000 </span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
