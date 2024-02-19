<?php

namespace App\Http\Controllers\Dashboard\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
use App\Traits\ImageUploader;

class BrandController extends Controller
{
    use ImageUploader;

    // INDEX OK!!
    public function index()
    {
        $brands = Brand::all();
        return view('dashboard.Brand.index', compact('brands'));
    }

    // CREATE OK!!
    public function create()
    {
        return view('dashboard.Brand.create');
    }

    // STORE OK!!
    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255',
                    'description' => 'required|max:255',
                    'image' => 'required|image|max:5000|mimes:jpeg,png,jpg',
                ],
                [
                    'name.required' => 'Enter the brand name',
                    'name.max' => 'Maximum length is 255 characters',
                    'description.required' => 'Enter the brand description',
                    'description.max' => 'Maximum length is 255 characters',
                    'image.required' => 'At least one image is required',
                    'image.image' => 'The selected image must be in JPEG, PNG, JPG, or GIF format',
                    'image.max' => 'The selected image must not be larger than 5MB',
                    'image.mimes' => 'The selected image must be in JPEG, PNG, JPG, or GIF format',
                ],
            );

            if ($validator->fails()) {
                $errorField = $validator->errors()->keys()[0];
                return $this->sendError($errorField, __('validators.' . $validator->errors()->first()), 400);
            }

            $input = $request->all();

            $user_id = Auth::id();
            $input['user_id'] = $user_id;
            $input['image'] = $this->saveImage($request->image, 'brand');
            $brand = Brand::create($input);

            return $this->sendResponses('Success', __('responses.:_THIS_VAR_ has been added successfully', ['_THIS_VAR_' => __('the brand')]), 200);
        } catch (\Exception $e) {
            return $this->sendError('error', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // EDIT OK!!
    public function edit(string $id)
    {
        $value = Brand::find($id);
        if (!$value) {
            return back()->with('error', __('responses.:_THIS_VAR_ not found', ['_THIS_VAR_' => __('the brand')]));
        }

        return view('dashboard.Brand.edit', compact('value'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $brand = Brand::findOrFail($id);
        if (!$brand) {
            return back()->with('error', __('responses.:_THIS_VAR_ not found', ['_THIS_VAR_' => __('the brand')]));
        }

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255',
                    'description' => 'required|max:255',
                ],
                [
                    'name.required' => 'Enter the brand name',
                    'name.max' => 'Maximum length is 255 characters',
                    'description.required' => 'Enter the brand description',
                    'description.max' => 'Maximum length is 255 characters',
                ],
            );

            if ($validator->fails()) {
                $errorField = $validator->errors()->keys()[0];
                return $this->sendError($errorField, __('validators.' . $validator->errors()->first()), 400);
            }

            $input = $request->all();

            $user_id = Auth::id();
            $input['user_id'] = $user_id;

            $image = $brand->image;
            if ($image == null) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'image' => 'required|image|max:5000|mimes:jpeg,png,jpg',
                    ],
                    [
                        'image.required' => 'At least one image is required',
                        'image.image' => 'The selected image must be in JPEG, PNG, JPG, or GIF format',
                        'image.max' => 'The selected image must not be larger than 5MB',
                        'image.mimes' => 'The selected image must be in JPEG, PNG, JPG, or GIF format',
                    ],
                );

                if ($validator->fails()) {
                    $errorField = $validator->errors()->keys()[0];
                    return $this->sendError($errorField, __('validators.' . $validator->errors()->first()), 400);
                }
            }
            if ($request->image) {
                $input['image'] = $this->saveImage($request->image, 'brand');
            }
            $brand->update($input);

            return $this->sendResponses('Success', __('responses.:_THIS_VAR_ has been Updated successfully', ['_THIS_VAR_' => __('the brand')]));
        } catch (\Exception $e) {
            return $this->sendError('error', $e->getMessage(), 500);
        }
    }

    //GetImages OK!!
    public function getImages(Request $request)
    {
        $id = $request->id;
        $brand = Brand::find($id);

        return view('dashboard.Brand.components.images', compact('brand'));
    }

    //Delete Image OK!!
    public function deleteImage(Request $request)
    {
        try {
            $id = $request->id;
            $brand = Brand::find($id);

            if (!$brand) {
                return $this->sendError('Error', __('responses.:_THIS_VAR_ not found', ['_THIS_VAR_' => __('the brand')]), 404);
            }

            $path = $brand->image;
            if (file_exists($path)) {
                unlink($path);
            }

            $brand->image = null;
            $brand->save();

            return $this->sendResponses('Success', __('responses.Image deleted successfully'), 200);
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }

    //Delete OK!!
    public function destroy(string $id)
    {
        try {
            $brand = Brand::find($id);
            if (!$brand) {
                return $this->sendError('Error', __('responses.:_THIS_VAR_ not found', ['_THIS_VAR_' => __('the brand')]), 404);
            }

            $name = __($brand->name);
            $count = $brand->products->count();

            if ($count > 0) {
                return $this->sendError('Error', __('responses.:_THIS_VAR_ :_KEY_ contains :_VALUE_ products that must be deleted or moved to another : _VAR_  in order to be able to delete :_THIS_VAR_', ['_THIS_VAR_' => __('the brand'), '_VAR_' => __('brand'), '_KEY_' => $name, '_VALUE_' => $count]), 404);
            }

            $image = $brand->image;
            $brand->delete();
            if ($image) {
                $path = $image;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            return $this->sendResponses('Success', __('responses.:_THIS_VAR_ deleted successfully', ['_THIS_VAR_' => __('the brand')]), 200);
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage(), 500);
        }
    }
}
