<?php

namespace App\Http\Controllers;

use App\ContactUs;  // Ensure this import is correct
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    // Show contact form
    public function showForm()
    {
        return view('frontEnd.contactus');
    }

    // Store contact message
    public function storeMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('contact.store')->with('success', 'Message sent successfully!');
    }

    // Display all messages in the dashboard
    public function showMessages()
    {
        // Retrieve all contact messages from the database
        $messages = ContactUs::all();

        // Pass both the $messages and $menu_active to the view
        $menu_active = '7';  // This will highlight the "Messages" menu
        return view('backEnd.contactus.contactus', compact('messages', 'menu_active'));
    }
}
