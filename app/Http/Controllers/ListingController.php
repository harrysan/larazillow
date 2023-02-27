<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except(['index', 'show']);
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths',
            'areaFrom', 'areaTo'
        ]);

        // if ($filters['priceFrom'] ?? false) {
        //     $query->where('price', '>=', $filters['priceFrom']);
        // }

        // if ($filters['priceTo'] ?? false) {
        //     $query->where('price', '<=', $filters['priceTo']);
        // }

        // if ($filters['beds'] ?? false) {
        //     $query->where('beds', $filters['beds']);
        // }

        // if ($filters['baths'] ?? false) {
        //     $query->where('baths', $filters['baths']);
        // }

        // if ($filters['areaFrom'] ?? false) {
        //     $query->where('area', '>=', $filters['areaFrom']);
        // }

        // if ($filters['areaTo'] ?? false) {
        //     $query->where('area', '<=', $filters['areaTo']);
        // }

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                // 'listings' => Listing::orderByDesc('created_at')
                'listings' => Listing::mostRecent()
                    ->filter($filters)
                    ->withoutSold()
                    ->paginate(10)
                    ->withQueryString() //for paginate without losing filters
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        // FIRST WAY
        // if (Auth::user()->can('view', $listing)) {
        //     abort(403);
        // };

        // SECOND WAY
        // $this->authorize('view', $listing);

        $listing->load(['images']);
        $offer = !Auth::user() ?
            null : $listing->offers()->byMe()->first();

        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
                'offerMade' => $offer
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Listing $listing)
    // {
    //     //
    //     $listing->delete();

    //     return redirect()->back()->with('success', 'Listing was deleted!');
    // }
}
