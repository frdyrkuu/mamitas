<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Customer;
use App\Models\GCash;
use App\Models\Ticket;
use App\Models\History;
use App\Models\Shift;
use App\Models\PendingItems;
use App\Models\Stocks;
use App\Models\Supplier;
use App\Models\SupplierOrder;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;
use App\Models\Cms;
use App\Models\GcashTransaction;

class POSController extends Controller
{

    public function dashboard()
    {
        $cashier_name = session('cashier_name');
        if (!isset($cashier_name)) {
            return redirect()->route('login');
        } else {
            $cmsData = Cms::first(); // This will get the first CMS entry
            $started_shift = false;
            $today = Carbon::today()->toDateString();
            $menu = Menu::all();
            $items = Stocks::all();
            $stocks_alert = Stocks::where('quantity', '<=', 20)->get();
            // dd($stocks_alert);
            $lastTicket = History::latest('ticket')->first(); // Retrieve the latest ticket
            $ticket = $lastTicket->ticket + 1;
            $cashier_name = session('cashier_name');
            $shift = Shift::where('cashier', $cashier_name)
                ->whereDate('created_at', $today)
                ->get();
            if ($shift->isEmpty()) {
                return view('cashier', compact('cmsData')); // Changed this line
            } else {
                return view('dashboard', [
                    'menus' => $items,
                    'ticket' => $ticket,
                    'alerts' => $stocks_alert,
                    'cms' => $cmsData
                ]);
            }
        }

    }

    public function livesearch($key = null)
    {
        if (empty($key)) {
            // Return all items if the search key is empty
            $menus = Stocks::all();
        } else {
            // Perform the search query
            $menus = Stocks::where('item', 'LIKE', "%{$key}%")->get();
        }

        // Return the results as a JSON response
        return response()->json(['menus' => $menus]);
    }

    public function ticketDetails(Request $request)
    {
        $action = $request->input('action');
        $customer = $request->input('customer');
        if (empty($customer)) {
            $customer = 'Customer';
        }
        $ticket = $request->input('ticket');

        switch ($action) {
            case 'proceed':
                // Handle the logic for the "Order's Empty" button
                $data = ([
                    'ticket' => $ticket,
                    'name' => $customer
                ]);
                Customer::create($data);

                $foodNames = $request->input('food_name');
                foreach ($foodNames as $foodName) {
                    // Create a new Food instance
                    $food = new Ticket();

                    // Set the name attribute
                    $food->food_name = $foodName;

                    // Set the ticket_number attribute
                    $food->ticket = $ticket; // Or whatever the specific ticket number is

                    // Save the record to the database
                    $food->save();
                }

                $foods = Ticket::select('food_name')
                    ->selectRaw('COUNT(*) as count')
                    ->where('ticket', $ticket)
                    ->groupBy('food_name')
                    ->get();

                $prices = Stocks::all();

                // Create the foodPrices array
                $foodPrices = [];
                foreach ($prices as $price) {
                    $foodPrices[$price->item] = $price->retail;
                }

                $time = Ticket::where('ticket', $ticket)
                    ->orderBy('created_at', 'desc')
                    ->pluck('created_at')
                    ->first();

                $time_formatted = Carbon::parse($time)->format('F d, Y \a\t h:ia');

                return view('order_details', [
                    'ticket' => $ticket,
                    'customer' => $customer,
                    'foods' => $foods,
                    'prices' => $foodPrices,
                    'time' => $time_formatted
                ]);

            case 'gcash':
                // Handle the logic for the "GCash" button
                $time_formatted = Carbon::now()->format('F d, Y \a\t h:ia');
                return view('gcash_payment', ['time' => $time_formatted]);

            default:
                // Handle default action or throw an error
                return redirect()->back()->with('error', 'Invalid action.');
        }
    }

    public function gCash(Request $request)
    {
        $lastTicket = History::latest('ticket')->first(); // Retrieve the latest ticket
        $ticket = $lastTicket->ticket + 1;
        $amount = $request->input('cash');
        $charge = 0;
        $cashier_name = session('cashier_name');
        $shift = Shift::where('cashier', $cashier_name)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();
        $menu = Menu::all();
        $lastTicket = Customer::latest('ticket')->first(); // Retrieve the latest ticket
        $ticket = $lastTicket->ticket + 1;
        $action = $request->input('btn');

        if ($amount >= 1 && $amount <= 500) {
            $charge = 10;
        } elseif ($amount >= 501 && $amount <= 1000) {
            $charge = 20;
        } elseif ($amount >= 1001 && $amount <= 1500) {
            $charge = 30;
        } elseif ($amount >= 1501 && $amount <= 2000) {
            $charge = 40;
        } elseif ($amount >= 2001 && $amount <= 2500) {
            $charge = 50;
        } elseif ($amount >= 2501 && $amount <= 3000) {
            $charge = 60;
        } elseif ($amount >= 3001 && $amount <= 3500) {
            $charge = 70;
        } elseif ($amount >= 3501 && $amount <= 4000) {
            $charge = 80;
        } elseif ($amount >= 4001 && $amount <= 4500) {
            $charge = 90;
        } elseif ($amount >= 4501 && $amount <= 5000) {
            $charge = 100;
        } elseif ($amount >= 5001 && $amount <= 5500) {
            $charge = 110;
        } elseif ($amount >= 5501 && $amount <= 6000) {
            $charge = 120;
        } elseif ($amount >= 6001 && $amount <= 6500) {
            $charge = 130;
        } elseif ($amount >= 6501 && $amount <= 7000) {
            $charge = 140;
        } elseif ($amount >= 7001 && $amount <= 7500) {
            $charge = 150;
        } elseif ($amount >= 7501 && $amount <= 8000) {
            $charge = 160;
        } elseif ($amount >= 8001 && $amount <= 8500) {
            $charge = 170;
        } elseif ($amount >= 8501 && $amount <= 9000) {
            $charge = 180;
        } elseif ($amount >= 9001 && $amount <= 9500) {
            $charge = 190;
        } elseif ($amount >= 9501 && $amount <= 10000) {
            $charge = 200;
        } else {
            // Handle cases where the amount is outside the expected range
            $charge = "Invalid amount";
        }

        switch ($action) {
            case 'cash-in':
                $data = [
                    'transaction_number' => $request->input('transaction_number'),
                    'type' => 'Cash In',
                    'amount' => $amount,
                    'charge' => $charge
                ];

                $saleTransactionData = [
                    'ticket' => $ticket,
                    'cashier' => $cashier_name,
                    'customer' => 'Customer',
                    'type' => 'CASH IN',
                    'sub_total' => 0,
                    'tax' => 0,
                    'cash' => $amount,
                    'total' => $amount,
                    'change' => 0
                ];

                $historySave = History::create($saleTransactionData);
                $gcashSave = GCash::create($data);

                // $paid_in = $shift->cash_in += $amount;
                // $shift->cash_in = $paid_in;
                if ($historySave && $gcashSave) {
                    return redirect()->intended(route('dashboard', ['menus' => $menu, 'ticket' => $ticket]));
                } else {
                    return redirect()->back()->withErrors(['Unable to save shift data.']);
                }
            case 'cash-out':
                $data = [
                    'transaction_number' => $request->input('transaction_number'),
                    'type' => 'Cash Out',
                    'amount' => $amount,
                    'charge' => $charge
                ];

                $saleTransactionData = [
                    'ticket' => $ticket,
                    'cashier' => $cashier_name,
                    'customer' => 'Customer',
                    'type' => 'CASH OUT',
                    'sub_total' => 0,
                    'tax' => 0,
                    'cash' => $amount,
                    'total' => $amount,
                    'change' => 0
                ];

                $historySave = History::create($saleTransactionData);
                $gcashSave = GCash::create($data);

                // $paid_out = $shift->cash_out += $amount;
                // $shift->cash_out = $paid_out;
                if ($historySave && $gcashSave) {
                    return redirect()->intended(route('dashboard', ['menus' => $menu, 'ticket' => $ticket]));
                } else {
                    return redirect()->back()->withErrors(['Unable to save shift data.']);
                }
        }
    }

    public function history()
    {
        $cashier_name = session('cashier_name');
        if (!isset($cashier_name)) {
            return redirect()->route('login');
        }
        
        $cmsData = Cms::first();  // Add this line
        // Get today's date
        $today = Carbon::today();

        // Query to fetch records with matching date
        $history = History::whereDate('created_at', $today)->get();

        $gcash_transactions = GCash::whereDate('created_at', $today)->get();

        return view('history', [
            'history' => $history, 
            'gcash' => $gcash_transactions,
            'cms' => $cmsData  // Add this line
        ]);
    }

    public function sale(Request $request)
    {
        $ticketNumber = $request->input('ticket');
        $cashier_name = session('cashier_name');
        if (!isset($cashier_name)) {
            return redirect()->route('login');
        }
        $menu = Menu::all();
        $ticket = $ticketNumber + 1;
        $change = $request->input('cash') - $request->input('pay');
        $quantities = [];
        $items = Ticket::select('food_name')
            ->where('ticket', $ticketNumber)
            ->groupBy('food_name')
            ->selectRaw('food_name, COUNT(*) as count')
            ->get();

        foreach ($items as $item) {
            $item_sold = $item->count;
            $quantity = Stocks::where('item', $item->food_name)->first();
            $current_stock = $quantity->quantity;
            $quantities[$item->food_name] = $quantity;
            $new_stock = $current_stock - $item_sold;
            $quantity->quantity = $new_stock;
            $quantity->save();
        }

        $data = [
            'ticket' => $request->input('ticket'),
            'cashier' => $cashier_name,
            'customer' => $request->input('customer'),
            'type' => 'SALE',
            'sub_total' => $request->input('sub_total'),
            'tax' => $request->input('tax'),
            'cash' => $request->input('cash'),
            'total' => $request->input('pay'),
            'change' => $change,
        ];

        $insert = History::create($data);

        $shift_sales_total = History::where('cashier', $cashier_name)
            ->whereDate('created_at', Carbon::today()) //created at must be the date today formatted by 2024-05-17. Get only the date part of the created_at
            ->sum('total');

        $shift = Shift::where('cashier', $cashier_name)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();
        $starting_cash = $shift->starting_cash ?? 0;
        $sales_today = $starting_cash + $shift_sales_total;
        $shift->closing_cash = $sales_today;
        $shift->save();

        if ($insert) {
            return redirect()->intended(route('dashboard', ['menus' => $menu, 'ticket' => $ticket]));
        }
    }

    public function purchasedDate(Request $request)
    {
        $date = $request->input('date');
        // Query to fetch records with matching date
        $history = History::whereDate('created_at', $date)->get();
        $gcash_transactions = GCash::wheredate('created_at', $date)->get();

        return view('history', ['history' => $history, 'gcash' => $gcash_transactions]);
    }

    public function cashier()
    {
        $pos_number = session('pos_number');
        $cashier_name = session('cashier_name');
        $cmsData = Cms::first();  // Add this line
        $stocks_alert = Stocks::where('quantity', '<=', 20)->get();
        $shift = Shift::where('cashier', $cashier_name)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();

        $gcash = GcashTransaction::all();

        $shift_start = $shift->created_at;

        $date_today = Carbon::today();
        $sales_today = History::whereDate('created_at', $date_today)->where('cashier', $cashier_name)->get();

        $formatted_shift_start = Carbon::parse($shift_start)->format('F d, Y \- h:ia');

        $shift_sales_total = History::where('cashier', $cashier_name)
            ->where('type', 'SALE')
            ->whereDate('created_at', Carbon::today()) //created at must be the date today formatted by 2024-05-17. Get only the date part of the created_at
            ->sum('total');

        $cash_in_payments = History::where('cashier', $cashier_name)
            ->where('type', 'CASH IN')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $cash_out_payments = History::where('cashier', $cashier_name)
            ->where('type', 'CASH OUT')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $cash_in_charge = GCash::where('type', 'Cash In')
            ->whereDate('created_at', Carbon::today())
            ->sum('charge');

        $cash_out_charge = GCash::where('type', 'Cash Out')
            ->whereDate('created_at', Carbon::today())
            ->sum('charge');

        $net_sales = History::where('cashier', $cashier_name)
            ->where('cashier', $cashier_name)
            ->whereDate('created_at', Carbon::today())
            ->sum('sub_total');

        if (is_null($shift)) {
            // If no shift is found, render the cashier view
            return view('cashier', [
                'cms' => $cmsData  // Add this line
            ]);
        } else {
            // If at least one shift is found, render the cashier_menu view
            return view('cashier_menu', [
                'shift' => $shift,
                'net_sales' => $net_sales,
                'cash' => $shift_sales_total,
                'pos' => $pos_number,
                'alerts' => $stocks_alert,
                'time' => $formatted_shift_start,
                'sales' => $sales_today,
                'cashInPayments' => $cash_in_payments,
                'cashOutPayments' => $cash_out_payments,
                'cashInCharge' => $cash_in_charge,
                'cashOutCharge' => $cash_out_charge,
                'cms' => $cmsData,  // Add this line
                'gcash' => $gcash
            ]);
        }
    }

    public function startShift(Request $request)
    {
        $cashier_name = session('cashier_name');
        $pos = session('pos_number');
        $stocks_alert = Stocks::where('quantity', '<=', 20)->get();

        $starting_cash = $request->input('starting_cash');

        $data = [
            'cashier' => $cashier_name,
            'POS_number' => $pos,
            'starting_cash' => $starting_cash,
        ];

        $data['closing_cash'] = 0;

        Shift::create($data);

        $items = Stocks::all();
        $lastTicket = Customer::latest('ticket')->first(); // Retrieve the latest ticket
        $ticket = $lastTicket->ticket + 1;
        $cashier_name = session('cashier_name');
        return view('dashboard', ['menus' => $items, 'ticket' => $ticket, 'alerts' => $stocks_alert]);
    }

    public function historyTicket(Request $request, $ticket)
    {
        $sanitizedTicket = str_replace('1-', '', $ticket);

        // Query the database with the sanitized ticket
        $orders = Ticket::where('ticket', $sanitizedTicket)->get();

        $foodQuantities = [];

        // Loop through each order
        foreach ($orders as $order) {
            // Get the food_name for this order
            $foodName = $order->food_name;

            // Increment the quantity of this food name in the associative array
            if (isset($foodQuantities[$foodName])) {
                $foodQuantities[$foodName]++;
            } else {
                $foodQuantities[$foodName] = 1;
            }
        }

        $foodPrices = [];

        // Loop through each unique food name
        foreach ($foodQuantities as $foodName => $quantity) {
            // Query the Menu model to get the price of this food
            $foodPrice = Stocks::where('item', $foodName)->value('retail');

            // Add the food name, its price, and quantity to the foodPrices array
            $foodPrices[] = [
                'food_name' => $foodName,
                'price' => $foodPrice,
                'quantity' => $quantity
            ];
        }

        // Query the database for other ticket details
        $result = History::where('ticket', $sanitizedTicket)->get();

        $data = [
            'result' => $result,
            'food_prices' => $foodPrices
        ];

        // Return the combined data as JSON
        return response()->json($data);
    }

    public function cashManagement(Request $request)
    {
        $lastTicket = Customer::latest('ticket')->first(); // Retrieve the latest ticket
        $ticket = $lastTicket->ticket + 1;
        $cashier_name = session('cashier_name');
        $shift = Shift::where('cashier', $cashier_name)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();
        $mode = $request->input('reason');
        $amount = $request->input('amount');
        $customer = [
            'ticket' => $ticket,
            'name' => 'Customer'
        ];

        if ($mode == 'paid_in') {
            $data = [
                'ticket' => $ticket,
                'cashier' => $cashier_name,
                'customer' => 'Customer',
                'type' => 'PAY IN',
                'sub_total' => 0.0,
                'tax' => 0.0,
                'cash' => 0.0,
                'total' => $amount,
                'change' => 0.0,
            ];

            $paid_in = $shift->cash_in += $amount;
            $shift->cash_in = $paid_in;
            $create = History::create($data);
            Customer::create($customer);
            if ($shift->save() && $create) {
                return redirect()->back()->with('status', 'Cash in successfully updated.'); // Redirect back with success message
            } else {
                return redirect()->back()->withErrors(['Unable to save shift data.']);
            }
        } else {
            $data = [
                'ticket' => $ticket,
                'cashier' => $cashier_name,
                'customer' => 'Customer',
                'type' => 'PETTY CASH',
                'sub_total' => 0.0,
                'tax' => 0.0,
                'cash' => 0.0,
                'total' => $amount,
                'change' => 0.0,
            ];

            $paid_out = $shift->cash_out += $amount;
            $shift->cash_out = $paid_out;
            $create = History::create($data);
            Customer::create($customer);
            if ($shift->save() && $create) {
                return redirect()->back()->with('status', 'Cash out successfully updated.'); // Redirect back with success message
            } else {
                return redirect()->back()->withErrors(['Unable to save shift data.']);
            }
        }
    }

    public function inventory()
    {
        $cmsData = Cms::first();  // Add this line
        $data = Stocks::paginate(13);
        return view('pos_inventory', [
            'item' => $data,
            'cms' => $cmsData  // Add this line
        ]);
    }

    public function itemSearch($key = null)
    {
        if (empty($key)) {
            // Return all items if the search key is empty
            $menus = Stocks::all();
        } else {
            // Perform the search query
            $menus = Stocks::where('item', 'LIKE', "%{$key}%")->get();
        }

        // Return the results as a JSON response
        return response()->json(['menus' => $menus]);
    }

    public function orders()
    {
        // Get all orders with pending status
        $pendingOrders = SupplierOrder::where('status', 'Pending')->get();
        $cmsData = Cms::first();  // Add this line

        // Group orders by batch number and calculate summary data
        $batches = $pendingOrders->groupBy('batch_number')->map(function ($group) {
            return [
                'batch_number' => $group->first()->batch_number,
                'total_items' => $group->sum('quantity'),
                'total_rows' => $group->count(),
                'created_at' => $group->first()->created_at
            ];
        });

        // Pass the summary data to the view
        return view('orders', [
            'batches' => $batches,
            'cms' => $cmsData  // Add this line
        ]);
    }


    public function ordersFromSupplier($name)
    {
        $orders = SupplierOrder::where('batch_number', $name)
            ->where('status', 'Pending')
            ->get();

        // Format the created_at attribute
        $formattedOrders = $orders->map(function ($order) {
            $order->created_at = $order->created_at->format('F d, Y');
            return $order;
        });

        return response()->json(['orders' => $formattedOrders]);
    }

    public function completeOrder(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'exists:supplier_orders,id', // Ensure each ID exists in the supplier_orders table
            'orders.*.expiration_date' => 'required|date_format:m/d/Y' // Validate the expiration_date
        ]);

        // Extract the orders data
        $ordersData = $validated['orders'];

        foreach ($ordersData as $orderData) {
            // Retrieve the order by ID
            $order = SupplierOrder::find($orderData['id']);

            if ($order) {
                // Retrieve the item name and quantity from the order
                $itemName = $order->item; // Adjust this if your column name is different
                $quantity = $order->quantity; // Adjust this if your column name is different

                // Find the corresponding item in the Stocks model
                $stock = Stocks::where('item', $itemName)->first();

                if ($stock) {
                    // Update the quantity in the Stocks model
                    $stock->quantity += $quantity;
                    $stock->update_reason = 'New stocks';
                    $stock->save();
                }

                // Update the expiration date and status for the order
                $order->status = 'Delivered';
                $order->expiration_date = Carbon::createFromFormat('m/d/Y', $orderData['expiration_date'])->format('Y-m-d');
                $order->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Orders updated successfully.']);
    }

    public function addItem()
    {
        $supplier = Supplier::all();
        return view('add_item', [
            'suppliers' => $supplier
        ]);
    }

    public function toPendingItems(Request $request)
    {
        // dd($request);
        $data = Stocks::paginate(8);
        $quantity = 0;
        $profit = 0;
        $cost = $request->input('cost');
        $retail = $request->input('retail');
        $profit = $retail - $cost;
        $size = $request->input('size');
        $legend = $request->input('size_legend');

        // Handle the image upload
        if ($request->hasFile('item_image')) {
            $image = $request->file('item_image');
            $imageName = $request->input('item_name') . '.' . $image->extension();
            $image->move(public_path('images/items'), $imageName);
        } else {
            $imageName = null;
        }

        $data = [
            'item' => $request->input('item_name'),
            'category' => $request->input('category'),
            'supplier' => $request->input('supplier'),
            'product_unit' => $request->input('product_unit'),
            'color' => $request->input('color'),
            'size' => $size . ' ' . $legend,
            'barcode' => $request->input('barcode'),
            'quantity' => $quantity,
            'cost' => $request->input('cost'),
            'retail' => $request->input('retail'),
            'profit' => $profit,
        ];

        $add = PendingItems::create($data);

        if ($add) {
            return redirect()->intended(route('inventory', ['item' => $data]));
        }
    }

    public function displayCMS()
    {
        // Retrieve the CMS data
        $cmsData = Cms::first(); // This will get the first CMS entry

        // Return the view with CMS data
        return view('welcome', ['cms' => $cmsData]);
    }
}
