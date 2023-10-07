<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
        ]);
    }

    // 'listings' => Listing::all()

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        // Don't forget the fillable property(To allow mass assignment) in the model
        // Or use model unguard

        if ($request->hasFile('logo')) {
            // Store the image file in public/logos
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        // return redirect('/');
        return redirect('/')->with('message', 'Listing Created Successfully');
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        // Update Listing Data
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        // Don't forget the fillable property(To allow mass assignment) in the model
        // Or use model unguard

        if ($request->hasFile('logo')) {
            // Store the image file in public/logos
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        // return redirect('/');
        return back()->with('message', 'Listing Updated Successfully');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect('/')->with('message', "Listing Deleted Successfully");
    }

    public function manage()
    {
        return view(
            'listings.manage',
            // ['listings' => auth()->user()->listing()->get()]
        );
    }
}
