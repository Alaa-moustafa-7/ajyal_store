<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'parent_id', 'description', 'image', 'status', 'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => '-'
            ]);
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', $status);
    }

    public function scopeFilter(Builder $builder, $filter)
    {
        $builder->when($filter['name'] ?? false, function($builder, $value){
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });

        $builder->when($filter['status'] ?? false, function($builder, $value){
            $builder->where('categories.status', '=', $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
            'required',
            'string', 
            'min:3',
            'max:255',
            // "unique:categories,name,$id",
            Rule::unique('categories', 'name')->ignore($id),
            /*function($attribute, $value, $fails){
                if (strtolower($value) == 'laravel'){
                    $fails('this name is forbeddien!!');
                }
            }*/
            'filter:php,laravel,css',
            // new Filter(['laravel', 'php', 'Css', 'javascript', 'C#', 'Java'])
            ],
            'parent_id' => [
                'nullable', 'int', 'exists:categories, id'
            ],
            'image' => [
                'image', 'max:1048576', 'dimensions:min_width:100px, min_height:100px',
            ],
            'status' => 'in:active,archived',
        ];
    }
}
