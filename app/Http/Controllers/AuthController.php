<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Authentication;
use App\Models\Admin;
use App\Models\PendingAccount;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Shift;
use Illuminate\Support\Facades\Mail;

use App\Mail\AdminPasswordResetRequest;
use App\Models\Cms;

class AuthController extends Controller
{
    public function authLoginCashier(Request $request)
    {
        // dd($request);
        $pos_number = 'pos1';

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'Cashier') {
                $cashier_name = Auth::user()->name; // Assuming the user model has a 'name' attribute
                session(['cashier_name' => $cashier_name]);
                session(['pos_number' => $pos_number]);
                return redirect()->intended(route('dashboard'));
            }
        }

        return redirect()
            ->route('welcome')
            ->with('error', 'Authentication failed. Please check your credentials.');
    }

    public function authLoginAdmin(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        // Extract credentials
        $credentials = $request->only('name', 'password');

        // Authentication Attempt
        if (Auth::guard('admin')->attempt($credentials)) {
            // dd(Auth::check());

            // If authenticated, get the user
            $user = Auth::guard('admin')->user();
            // dd($user)

            if ($user->role === 'Admin') {
                session(['admin_name' => $user->name]); // Use $user directly
                return redirect()->intended(route('office.dashboard'));
            }
        }

        return redirect()
            ->back()
            ->with('error', 'Authentication failed. Please check your credentials.');
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('office.login');
    }



    public function addCashier(Request $request)
    {
        $name = $request->input('cashier_name');
        $password = $request->input('password');
        $role = "Cashier";
        $cmsData = Cms::first(); // This will get the first CMS entry
        $hashedPassword = Hash::make($password);

        $data = ([
            'name' => $name,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        $create = Authentication::create($data);

        if (!$create) {
            return view('welcome');
        }

        $cashiers = Authentication::all();
        $pending = PendingAccount::all();

        return view('backoffice/cashiers/cashiers', ['cashiers' => $cashiers, 'pendings' => $pending,   'cms' => $cmsData])->with('success', 'Cashier added successfully!');
    }

    public function addAdmin()
    {
        $name = "Admin";
        $password = "admin1";
        $role = "Admin";

        $hashedPassword = Hash::make($password);

        $data = ([
            'name' => $name,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        $create = Admin::create($data);

        if (!$create) {
            return view('welcome');
        }
        return redirect()->route('office.login');
    }

    public function endShift(Request $request) // Add Request type hinting
    {
        $cashier_name = session('cashier_name');
        $shift = Shift::where('cashier', $cashier_name)->delete();
        // Log out the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent CSRF attacks
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('welcome'); // Adjust the redirect path as needed
    }

    public function forgotPassword(Request $request)
    {
        $cashier = Authentication::where('name', $request->username)->get();
        // dd($cashier->isEmpty());
        if ($cashier->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Cashier not found!']);
        } else {
            return view('reset_password/reset_password', ['cashier' => $cashier]);
        }
    }

    public function changePassword(Request $request)
    {
        // dd($request);
        $new_password = Hash::make($request->new_password);
        $cashier = Authentication::where('name', $request->name)->first();

        if ($cashier) {
            $cashier->password = $new_password;

            $cashier->save();

            return redirect()->route('welcome')->with('success', 'Password changed successfully!');
        }
    }

    public function registerView()
    {
        return view('accounts.register');
    }

    public function register(Request $request)
    {
        $name = $request->name;
        $password = $request->password;
        $hashedPassword = Hash::make($password);

        $data = [
            'name' => $name,
            'password' => $hashedPassword
        ];

        $create = PendingAccount::create($data);

        if ($create) {
            return redirect()->route('welcome')->with('success', 'Account successfully submitted!');
        } else {
            return redirect()->back()->withErrors('error', 'Account submission failed!');
        }
    }

    public function viewAdminPassword(Request $request)
    {
        $returnVal = 0;
        return view('backoffice.admin_forgot_password', [
            'value' => $returnVal
        ]);
    }

    public function forgotAdminPassword(Request $request)
    {
        $email = $request->email;

        // Fetch the email from the database
        $dbemail = Admin::where('email', $email)->first();

        // Define the return variable
        $return = '';
        $returnVal = [];

        // Define a variable to track if the email was already sent
        $emailSent = false;

        // If email matched
        if ($dbemail) {
            $return = "Email Matched from the db";

            // Check if the email has already been sent
            if (!$emailSent) {
                try {
                    // Generate a token
                    $token = Str::random(60);

                    // Send the password reset email with the token in the URL
                    Mail::to($dbemail->email)->send(new AdminPasswordResetRequest($dbemail->email, $token));
                    // Mark the email as sent to prevent duplication
                    $emailSent = true;
                    $returnVal = 1;
                } catch (\Exception $e) {
                    echo "Failed to send email: " . $e->getMessage();
                }
            } else {
                echo "The password reset request has already been sent.";
            }
        } else {
            // If email does not match
            $returnVal = 2;
        }

        // Return view or further actions
        return view('backoffice.admin_forgot_password', [
            'email' => $email, // Pass the email entered by the user
            'return' => $return, // Pass the result message
            'value' => $returnVal
        ]);
    }

    public function resetPasswordForm()
    {
        return view('backoffice.reset_password');
    }
    public function resetPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'adminEmail' => 'required|email',
            'newPassword' => 'required|string|min:8',
            'confirmPassword' => 'required|string|same:newPassword',
        ]);

        // Hash the new password
        $new_password = Hash::make($request->newPassword);

        // Find the admin by email
        $admin = Admin::where('email', $request->adminEmail)->first();

        if ($admin) {
            // Update the password
            $admin->password = $new_password;

            // Save the updated password
            $admin->save();

            // Redirect with success message to trigger SweetAlert
            return redirect()->route('welcome')->with('success', 'Password updated successfully!');
        } else {
            $returnAuth = "Invalid credentials given from Admin details";

            return view('backoffice.reset_password', [
                'returnAuth' => $returnAuth,
            ]);
        }
    }
}
