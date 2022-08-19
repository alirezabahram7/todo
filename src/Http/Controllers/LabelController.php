<?php

namespace Http\Controllers;

use Http\Requests\LabelStoreRequest;
use Http\Resources\BasicResource;
use Http\Resources\LabelCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Label;
use function response;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
       $labels = Label::paginate(30);
        return response(new LabelCollectionResource(['data' => $labels]),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LabelStoreRequest $request
     * @return Response
     */
    public function store(LabelStoreRequest $request): Response
    {
        $label = Label::create($request->all());
        return response(new BasicResource(['data' => $label, 'message' => __('messages.successfulStore')]),201);
    }

    /**
     * Display the specified resource.
     *
     * @param Label $label
     * @return Response
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Label $label
     * @return Response
     */
    public function edit(Label $label)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Label $label
     * @return Response
     */
    public function update(Request $request, Label $label)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return Response
     */
    public function destroy(Label $label)
    {
        //
    }
}
