<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thermal Printer Page</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            @page {
                size: 80mm auto; /* Width 80mm, height auto */
                margin: 0;
            }
        }
    </style>
</head>
<body class="w-full flex h-fit justify-center">
    <div id="contentToSave" class="bg-red-500">
        <div class="header">
            <h1>Receipt</h1>
        </div>
        <div class="content">
            <div class="item">
                <strong>Item Name:</strong> Example Product<br>
                <strong>Quantity:</strong> 1<br>
                <strong>Price:</strong> $10.00
            </div>
            <div class="item">
                <strong>Item Name:</strong> Another Product<br>
                <strong>Quantity:</strong> 2<br>
                <strong>Price:</strong> $20.00
            </div>
        </div>
        <div class="footer">
            Thank you for shopping with us!
        </div>
    </div>
    <button id="saveButton">Save as JPG</button>

    <script src="{{asset('html2canvas.min.js')}}"></script>
    <script>
        document.getElementById('saveButton').addEventListener('click', function() {
            html2canvas(document.getElementById('contentToSave'), {
                scale: 2 // Increase scale for better quality
            }).then(function(canvas) {
                var link = document.createElement('a');
                link.href = canvas.toDataURL('image/jpeg');
                link.download = 'receipt.jpg';
                link.click();
            });
        });
    </script>
</body>
</html>
