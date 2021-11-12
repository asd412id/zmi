<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;
	protected $table = 'category';

	public function links()
	{
		return $this->hasMany(Link::class)
			->orderBy('position', 'asc')
			->orderBy('created_at', 'asc');
	}

	public function getActiveAttribute($value)
	{
		return '<span class="badge ' . ($value ? 'badge-primary' : 'badge-danger') . '">' . ($value ? 'Aktif' : 'Tidak Aktif') . '</span>';
	}

	public function getActiveValAttribute()
	{
		return $this->attributes['active'];
	}

	public function getColorAttribute()
	{
		return @Config::where('config', 'cat_' . $this->id . '_color')->first()->value;
	}
}
