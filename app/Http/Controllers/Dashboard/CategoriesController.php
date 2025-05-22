<?php

namespace App\Http\Controllers\Dashboard;

//use App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('categories.view')){
            abort(403);
        }

        $request = request();

        // SELECT a.*, b.name as parent_name
        // FROM categories as a
        // LEFT JOIN categories as b on b.id = a.parent_id

        $categories = Category::with('parent')
            /*leftjoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ]) */
            // ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as product_count')
            ->withCount([
                'products' => function($query){
                    $query->where('status', '=', 'active');
                }
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate(5); // جلب جميع الفئات
            // ->dd();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('categories.create')){
            abort(403);
        }

        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');

        // $request->validate(Category::rules(), [
        //     'name.required' => 'This field (name) is required.',  // تحديد الحقل name
        //     'name.unique' => 'This name already exists!', 
        // ]);

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);

        return redirect()->route('dashboard.categories.index')->with('success', 'Created Successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (!Gate::allows('categories.view')){
            abort(403);
        }

        return view('dashboard.categories.show',[
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('categories.update');

        try {
            $category = Category::findOrFail($id);
        } catch (\Exception $e) {
            return redirect()->route('dashboard.categories.index')->with('info', 'Record Not Found!!');
        }
        $parents = Category::where('id', '<>', $id)
                    // 'id', '=', $someValue
                    ->where(function($query) use ($id) {
                    $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
                })->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        // $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);

        $old_image = $category->image;
        $data = $request->except('image');
       
        $new_image = $this->uploadImage($request);
        if ($new_image){
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')->with('success', 'Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('categories.delete');

        $category = Category::findOrFail($id);
        $category->delete();

        // Category::destroy($id);
        return Redirect::route('dashboard.categories.index')
            ->with('success', 'Category deleted!!');

    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')){
            return;
        }

        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public',
        ]);
        return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category Restored!');
    }

     public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image){
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category Deleted forever!');
    }
}
