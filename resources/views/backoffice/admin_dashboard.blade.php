<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/css/app.css')
    <title>Back Office</title>
</head>

<body class="w-full h-screen overflow-hidden bg-[#f2f2f2]">
    <div class="w-full flex items-center h-[7%] bg-main px-10">
        <p class="text-lg font-medium text-white">Sales summary</p>
    </div>
    <div class="w-full h-[93%] flex">
        <div class="w-[5%] pt-10 bg-[#fefefe]">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center pb-4 mb-3">
                <img src="{{ asset($cms->company_logo) }}" alt="">
            </div>
            <div class="w-full relative">
                <button onclick="openDashboard()"
                    class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{ asset('images/chart-red.png') }}" alt="" class="w-[30px] h-auto">
                </button>
                <div id="dash_options" class="hidden w-[200px] absolute left-20 top-0 z-10 bg-slate-50 text-sm">
                    <div class="w-full flex flex-col py-2">
                        <a href="{{ route('office.dashboard') }}" class="hover:bg-[#e6e6e6] p-2">Sales summary</a>
                        <a href="{{ route('office.sales_by_item') }}" class="hover:bg-[#e6e6e6] p-2">Sales by item</a>
                        <a href="{{ route('office.sales_history') }}" class="hover:bg-[#e6e6e6] p-2">Sales history</a>
                    </div>
                </div>
            </div>
            <div class="w-full relative">
                <a href="{{ route('office.items_list') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/prod-new.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <button onclick="openInventoryOptions()" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/inv-new.png') }}" alt="" class="w-[30px] h-auto">
                </button>
                <div id="inventory_options"
                    class="hidden w-[200px] absolute left-20 top-0 z-10 bg-slate-50 p-3 text-sm">
                    <div class="w-full flex flex-col gap-3">
                        <a href="{{ route('office.stocks_adjustment') }}">Stocks Adjustment</a>
                        <a href="{{ route('office.inventory') }}">Inventory</a>
                    </div>
                </div>
            </div>
            {{-- <div class="w-full relative">
                <a href="{{route('qr_printing')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/qr.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div> --}}
            <div class="w-full relative">
                <a href="{{ route('office.cashiers') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/employee-new.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{ route('office.supplier') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/supplier-new.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{ route('office.ordering') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/order-new.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{ route('office.cms') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/cms.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <form id="logoutForm" action="{{ route('office.logout') }}" method="POST">
                    @csrf
                    <a href="#" id="logoutLink" class="w-full flex items-center justify-center h-auto py-4">
                        <img src="{{ asset('images/logout-new.png') }}" alt="Logout" class="w-[30px] h-auto">
                    </a>
                </form>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.getElementById('logoutLink').addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent the default link action

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You will be logged out of the system.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, log me out!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the logout form
                            document.getElementById('logoutForm').submit();
                        }
                    });
                });
            </script>

        </div>
        <div id="main" class="w-[95%] p-7 h-screen overflow-auto">
            <div class="w-full">
                <div class="mb-10">
                    <div class="bg-white mb-7 p-6">
                        <select name="date" id="date" class="outline-none p-2 border mb-6">
                            <script>
                                var currentYear = new Date().getFullYear(); // Fetch the current year
                                var currentMonth = new Date().getMonth(); // Fetch the current month (0-indexed)
                                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
                                    "November", "December"
                                ];
                                for (var i = 0; i < months.length; i++) {
                                    var option = document.createElement("option");
                                    option.text = months[i] + " " + currentYear; // Add current year to the month
                                    option.value = months[i] + " " + currentYear; // Add current year to the value
                                    if (i === currentMonth) {
                                        option.selected = true; // Automatically select the current month
                                    }
                                    document.getElementById("date").add(option);
                                }
                            </script>
                        </select>
                        <div class="w-full flex justify-between gap-4">
                            <div class="w-[70%] relative h-[500px]">
                                <canvas id="myChart" class="w-full"></canvas>
                            </div>
                            <div class="w-[30%] h-[500px]">
                                <p id="sales_today" class="text-center font-medium mb-3">Sales today
                                    ({{ $date_today }})</p>
                                <div class="w-full flex gap-2 py-2 bg-[#a19f9f] text-white px-2 text-sm">
                                    <p class="w-1/2">Sale #</p>
                                    <p class="w-1/2 text-right">Total</p>
                                </div>
                                <div id="date_result" class="h-[440px] overflow-y-auto">
                                    @foreach ($salesToday as $s)
                                        <div class="w-full flex gap-2 py-2 border-b-2 px-2 text-sm">
                                            <p class="w-1/2">{{ $s->id }}</p>
                                            <p class="w-1/2 text-right">₱{{ $s->total }}.00</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-7 w-full flex gap-5 rounded-xl">
                        <div class="w-[70%] bg-white p-5">
                            <p class="text-center font-medium mb-2">Monthly sales</p>
                            <canvas id="monthlyGraph" class="w-full"></canvas>
                        </div>
                        <div class="w-[30%] bg-white p-5">
                            <p class="text-center font-medium mb-2">Average buying time</p>
                            <canvas id="polarGraph" class="w-full mt-12"></canvas>
                        </div>
                        <script>
                            var ctxPolar = document.getElementById('polarGraph').getContext('2d');
                            var polarChart = new Chart(ctxPolar, {
                                type: 'polarArea',
                                data: {
                                    labels: @php echo json_encode($polarLabels); @endphp, // Convert array to JavaScript array
                                    datasets: [{
                                        label: 'Average Items Sold by Time of Day',
                                        data: @php echo json_encode($polarData); @endphp, // Convert array to JavaScript array
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        r: {
                                            angleLines: {
                                                display: false
                                            },
                                            suggestedMin: 0
                                        }
                                    }
                                }
                            });

                            var monthlyGraphDiv = document.getElementById('monthlyGraph').getContext('2d');
                            var monthlyGraphChart = new Chart(monthlyGraphDiv, {
                                type: 'bar',
                                data: {
                                    labels: @php echo json_encode($chartLabels); @endphp,
                                    datasets: [{
                                        label: 'Monthly Totals',
                                        data: @php echo json_encode($chartData); @endphp,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                    {{-- <div class="w-full bg-white p-6">
                        <div class="w-full flex items-center py-3 border-y justify-between font-semibold">
                            <p class="w-1/2 text-left">Date</p>
                            <p class="w-1/2 text-right">Gross sales</p>
                            <p class="w-1/2 text-right">Net sales</p>
                            <p class="w-1/2 text-right">Gross profit</p>
                        </div>
                        <div class="w-full">
                            @foreach ($dailyTotalSales as $date => $total)
                                <div class="py-3 flex w-full justify-between border-b">
                                    <p class="w-1/4">{{ $date }}</p>
                                    <p class="w-1/4 text-right">₱{{ $total }}.00</p>
                                    <p class="w-1/4 text-right">
                                        ₱{{ isset($dailySubTotalSales[$date]) ? $dailySubTotalSales[$date] : 0 }}</p>
                                    <p class="w-1/4 text-right">
                                        @php
                                            $profit =
                                                $total -
                                                (isset($dailySubTotalSales[$date]) ? $dailySubTotalSales[$date] : 0);
                                            echo '₱' . $profit;
                                        @endphp
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <script>
            const ctx = document.getElementById('myChart');
            const dailySales = @json($sales);


            // Function to format date to YYYY-MM-DD
            function formatDate(dateStr) {
                const date = new Date(dateStr);
                const year = date.getFullYear();
                const month = ('0' + (date.getMonth() + 1)).slice(-2); // Months are 0-based
                const day = ('0' + date.getDate()).slice(-2);
                return `${year}-${month}-${day}`;
            }

            // Declare the myChart variable in the global scope
            let myChart;

            document.addEventListener('DOMContentLoaded', (event) => {
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(dailySales), // Use the formatted dates as labels
                        datasets: [{
                            label: 'Total sales in Peso (₱)',
                            data: Object.values(dailySales), // Use the sales values
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        onClick: function(event, elements) {
                            if (elements.length > 0) {
                                const elementIndex = elements[0].index;
                                const dateStr = myChart.data.labels[elementIndex];
                                const formattedDate = formatDate(dateStr);

                                // show an alert
                                // alert(`Date: ${formattedDate}`);

                                let url = "{{ route('office.get_sales_per_month', ['date' => ':date']) }}"
                                url = url.replace(':date', encodeURIComponent(formattedDate))
                                // alert(url)

                                $.ajax({
                                    url: url,
                                    method: "GET",
                                    success: function(response) {
                                        // Assuming 'response' contains the 'salesToday' data
                                        $('#sales_today').html(
                                            `Sales on (${response.datePicked})`)
                                        var data = '';
                                        response.sales.forEach(function(sale) {
                                            data += `
                                                <div class="w-full flex gap-2 py-2 border-b-2 px-2 text-sm ">
                                                    <p class="w-1/2">${sale.id}</p>
                                                    <p class="w-1/2 text-right">₱${sale.total}.00</p>
                                                </div>
                                            `;
                                        });

                                        $('#date_result').html(data);
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle the error
                                        console.log("Error: " + error);
                                    }
                                });

                            }
                        }
                    }
                });
            });
        </script>


    </div>
    <script>
        var main = document.getElementById('main')

        $(document).ready(function() {
            $("#date").change(function() {
                var selectedDate = $(this).val();

                // Make AJAX request
                $.ajax({
                    url: "/back-office/get_monthly_sales",
                    method: "GET",
                    data: {
                        selectedDate: selectedDate
                    },
                    success: function(response) {

                        // Update gross sales and net sales values
                        $("#gross_sales").text('₱' + response.gross_sales.toFixed(2));
                        $("#net_sales").text('₱' + response.net_sales.toFixed(2));

                        // If chart exists, update chart data
                        var ctx = document.getElementById('myChart');
                        var chart = Chart.getChart(ctx);
                        if (chart) {
                            chart.data.labels = Object.keys(response.daily_sales);
                            chart.data.datasets[0].data = Object.values(response.daily_sales);
                            chart.update();
                        } else {
                            // Create new chart if it doesn't exist
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: Object.keys(response.daily_sales),
                                    datasets: [{
                                        label: 'Total sales in Peso (₱)',
                                        data: Object.values(response
                                            .daily_sales),
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function openInventoryOptions() {
            var inventoryOptions = document.getElementById('inventory_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openDashboard() {
            var inventoryOptions = document.getElementById('dash_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openItems() {
            var inventoryOptions = document.getElementById('items_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }
    </script>
</body>

</html>
